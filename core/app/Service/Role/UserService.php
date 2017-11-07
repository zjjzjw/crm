<?php

namespace Huifang\Service\Role;

use Huifang\Src\Role\Domain\Model\DataType;
use Huifang\Src\Role\Domain\Model\DepartEntity;
use Huifang\Src\Role\Domain\Model\RoleEntity;
use Huifang\Src\Role\Domain\Model\UserDataEntity;
use Huifang\Src\Role\Domain\Model\UserEntity;
use Huifang\Src\Role\Domain\Model\UserSpecification;
use Huifang\Src\Role\Infra\Repository\DepartRepository;
use Huifang\Src\Role\Infra\Repository\UserDataRepository;
use Huifang\Src\Role\Infra\Repository\UserRepository;
use Huifang\Src\Surport\Domain\Model\ResourceEntity;
use Huifang\Src\Surport\Infra\Repository\ResourceRepository;

class UserService
{
    /**
     * @param UserSpecification $spec
     * @param                   $per_page
     * @return array
     */
    public function getRoleList(UserSpecification $spec, $per_page)
    {
        $data = [];
        $user_repository = new UserRepository();
        $paginate = $user_repository->search($spec, $per_page);
        $items = [];
        /**
         * @var mixed      $key
         * @var RoleEntity $role_entity
         */
        foreach ($paginate as $key => $role_entity) {
            $item = $role_entity->toArray();
            $paginate[$key] = $item;
            $items[] = $item;
        }
        $data['paginate'] = $paginate;
        $data['items'] = $items;
        $data['pager']['total'] = $paginate->total();
        $data['pager']['last_page'] = $paginate->lastPage();
        $data['pager']['current_page'] = $paginate->currentPage();
        return $data;
    }


    /**
     * 获取user
     * @param $id
     * @return array
     */
    public function getUserInfoById($id)
    {
        $data = [];
        $user_repository = new UserRepository();
        /** @var UserEntity $user_entity */
        $user_entity = $user_repository->fetch($id);
        if (isset($user_entity)) {
            $data = $user_entity->toArray();
            if (!empty($user_entity->roles)) {
                $role = current($user_entity->roles);
                $data['role_name'] = $role['name']; //角色就是职位
            }
            if (!empty($user_entity->departs)) {
                $depart = current($user_entity->departs);
                $data['depart_name'] = $depart['name']; //部门
            }
            $data['start_time'] = $user_entity->start_time->format('Y-m-d');
            $data['end_time'] = $user_entity->end_time->format('Y-m-d');

            //得到头像信息
            $user_images = [];
            if (!empty($user_entity->image_id)) {
                $image = [];
                $image['image_id'] = $user_entity->image_id;
                $resource_repository = new ResourceRepository();
                $image_entities = $resource_repository->getResourceUrlByIds($user_entity->image_id);
                $image['url'] = $image_entities[$user_entity->image_id]->url ?? '';
                $user_images[] = $image;
            }
            $data['user_images'] = $user_images;
        }
        return $data;
    }


    /**
     * 得到公司员工，分组织结构，分数据权限
     * @param int $company_id
     * @param int $user_id
     * @return array
     */
    public function getAssignUsers($company_id, $user_id)
    {
        $depart_repository = new DepartRepository();
        $depart_entities = $depart_repository->getDepartByCompanyId($company_id);
        $departs = [];
        /** @var DepartEntity $depart_entity */
        foreach ($depart_entities as $depart_entity) {
            $departs[$depart_entity->id] = $depart_entity->toArray();
        }

        $user_data_repository = new UserDataRepository();
        $user_data_entities = $user_data_repository->getUserDataByUserId($user_id);

        $data_departs = [];
        $data_depart_ids = [];


        //这个地方的分配,只分配管理范围内的人
        /** @var UserDataEntity $user_data_entity */
        foreach ($user_data_entities as $user_data_entity) {
            if ($user_data_entity->data_type == DataType::TYPE_DEPART) {
                if (isset($departs[$user_data_entity->data_id])) {
                    $data_departs[] = $departs[$user_data_entity->data_id];
                    $data_depart_ids[] = $user_data_entity->data_id;
                }
            }
        }

        //得到部门下面的人
        $user_repository = new UserRepository();
        foreach ($data_departs as &$data_depart) {
            $user_entities = $user_repository->getUsersByDepartIds(array($data_depart['id']));
            /** @var UserEntity $user_entity */
            foreach ($user_entities as $user_entity) {
                $data_depart['users'][] = $user_entity->toArray();
            }
        }

        return $data_departs;
    }

    /**
     * 得到管辖范围的用户
     * 与getAssignUsers比少了部门的详细数据
     * @param int $company_id
     * @param int $user_id
     * @return array
     */
    public function getSearchUsers($company_id, $user_id)
    {
        $users = [];
        $depart_ids = [];
        $user_data_repository = new UserDataRepository();
        $user_data_entities = $user_data_repository->getUserDataByUserId($user_id);
        /** @var UserDataEntity $user_data_entity */
        foreach ($user_data_entities as $user_data_entity) {
            if ($user_data_entity->data_type == DataType::TYPE_DEPART) {
                $depart_ids[] = $user_data_entity->data_id;
            }
        }
        $user_repository = new UserRepository();
        $user_entities = $user_repository->getUsersByDepartIds($depart_ids);
        /** @var UserEntity $user_entity */
        foreach ($user_entities as $user_entity) {
            $users[] = $user_entity->toArray();
        }
        return $users;
    }

    /**
     * 得到项目合作的人，不分数据权限，这个地方是公司所有的人
     * @param int $company_id
     * @return array
     */
    public function getProjectCooperationUsers($company_id)
    {
        $departs = [];
        $depart_repository = new DepartRepository();
        $user_repository = new UserRepository();
        $depart_entities = $depart_repository->getDepartByCompanyId($company_id);
        /** @var DepartEntity $depart_entity */
        foreach ($depart_entities as $depart_entity) {
            $departs[] = $depart_entity->toArray();
        }
        foreach ($departs as &$depart) {
            $user_entities = $user_repository->getUsersByDepartIds(array($depart['id']));
            /** @var UserEntity $user_entity */
            foreach ($user_entities as $user_entity) {
                $depart['users'][] = $user_entity->toArray();
            }
        }

        return $departs;
    }

    /**
     * 得到公司下面所有的人员，按部门分组，部分数据权限
     * @param $company_id
     * @return array
     */
    public function getCompanyDepartUsers($company_id)
    {
        $departs = [];
        $depart_repository = new DepartRepository();
        $user_repository = new UserRepository();
        $depart_entities = $depart_repository->getDepartByCompanyId($company_id);
        /** @var DepartEntity $depart_entity */
        foreach ($depart_entities as $depart_entity) {
            $departs[] = $depart_entity->toArray();
        }
        foreach ($departs as &$depart) {
            $user_entities = $user_repository->getUsersByDepartIds(array($depart['id']));
            /** @var UserEntity $user_entity */
            foreach ($user_entities as $user_entity) {
                $item = $user_entity->toArray();
                if (!empty($user_entity->roles)) {
                    $user_role = current($user_entity->roles);
                    $item['role_name'] = $user_role['name']; //角色就是职位
                }
                if (!empty($user_entity->departs)) {
                    $user_depart = current($user_entity->departs);
                    $item['depart_name'] = $user_depart['name']; //部门
                }
                $depart['users'][] = $item;
            }
        }
        return $departs;
    }

    /**
     * 得到公司下面所有的用户，不按部门分组，不分数据权限
     * @param int $company_id
     * @return array
     */
    public function getUsersByCompanyId($company_id)
    {
        $items = [];
        $user_repository = new UserRepository();
        $user_entities = $user_repository->getUsersByCompanyId($company_id);
        /** @var UserEntity $user_entity */
        foreach ($user_entities as $user_entity) {
            $item = $user_entity->toArray();
            $items[] = $item;
        }
        return $items;
    }
}