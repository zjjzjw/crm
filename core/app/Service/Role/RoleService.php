<?php

namespace Huifang\Service\Role;

use Huifang\Src\Role\Domain\Model\PermissionEntity;
use Huifang\Src\Role\Domain\Model\RoleEntity;
use Huifang\Src\Role\Domain\Model\RoleSpecification;
use Huifang\Src\Role\Infra\Repository\PermissionRepository;
use Huifang\Src\Role\Infra\Repository\RoleRepository;
use Illuminate\Pagination\LengthAwarePaginator;

class RoleService
{
    /**
     * @param RoleSpecification $spec
     * @param int               $per_page
     * @return array
     */
    public function getRoleList(RoleSpecification $spec, $per_page)
    {
        $data = [];
        $role_repository = new RoleRepository();
        $paginate = $role_repository->search($spec, $per_page);
        $items = [];
        /**
         * @var int                  $key
         * @var RoleEntity           $role_entity
         * @var LengthAwarePaginator $paginate
         */
        $permission_repository = new PermissionRepository();
        $permission_entities = $permission_repository->all();
        foreach ($paginate as $key => $role_entity) {
            $item = $role_entity->toArray();
            $item_permissions = $permission_entities->filter(function ($value) use ($item) {
                return in_array($value->id, $item['permissions'] ?? []);
            });
            $names = [];
            foreach ($item_permissions as $item_permission) {
                $names[] = $item_permission->name;
            }
            $item['permission_names'] = implode(',', $names);
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

    public function getRoleInfo($id)
    {
        $data = [];
        $role_repository = new RoleRepository();
        $role_entity = $role_repository->fetch($id);
        if (isset($role_entity)) {
            $data = $role_entity->toArray();
        }
        return $data;
    }

    public function getPermissions()
    {
        $items = [];
        $groups = [
            [
                'id' => 1, 'name' => '销售线索', 'nodes' => [1, 2, 3, 4, 5, 36],
            ],
            [
                'id' => 2, 'name' => '项目管理', 'nodes' => [6, 7, 8, 9, 10, 11,
                12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 37],
            ],
            [
                'id' => 3, 'name' => '客户信息', 'nodes' => [27, 28, 29],
            ],
            [
                'id' => 4, 'name' => '合同信息', 'nodes' => [30, 31, 32, 38],
            ],
            [
                'id' => 5, 'name' => '名片信息', 'nodes' => [33, 34, 35],
            ],
        ];


        $permissions = [];
        $permission_repository = new PermissionRepository();
        $permission_entities = $permission_repository->all();
        /** @var PermissionEntity $permission_entity */
        foreach ($permission_entities as $permission_entity) {
            $permissions[$permission_entity->id] = $permission_entity->toArray();
        }

        foreach ($groups as $group) {
            $item = [];
            $item['id'] = $group['id'];
            $item['name'] = $group['name'];
            if (!empty($group['nodes'])) {
                foreach ($group['nodes'] as $id) {
                    if (!empty($permissions[$id])) {
                        $item['nodes'][] = $permissions[$id];
                    }
                }
            }
            if (!empty($item['nodes'])) {
                $items[] = $item;
            }
        }

        return $items;
    }

    /**
     * @param $company_id
     * @return array
     */
    public function getRoleByCompanyId($company_id)
    {
        $roles = [];
        $role_repository = new RoleRepository();
        $roles_entities = $role_repository->getRoleByCompanyId($company_id);
        foreach ($roles_entities as $roles_entity) {
            $roles[] = $roles_entity->toArray();
        }
        return $roles;
    }
}

