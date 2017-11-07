<?php

namespace Huifang\Service\Company;

use Carbon\Carbon;
use Huifang\Src\Company\Domain\Model\CompanyEntity;
use Huifang\Src\Company\Domain\Model\CompanySpecification;
use Huifang\Src\Role\Domain\Model\DepartEntity;
use Huifang\Src\Role\Domain\Model\DepartSpecification;
use Huifang\Src\Role\Domain\Model\UserEntity;
use Huifang\Src\Role\Infra\Repository\DepartRepository;
use Huifang\Src\Role\Infra\Repository\UserRepository;
use Huifang\Src\Surport\Infra\Repository\ResourceRepository;
use Illuminate\Pagination\LengthAwarePaginator;

class DepartService
{
    protected static $departs;

    public function __construct($company_id)
    {
        if (!isset(self::$departs)) {
            self::$departs = $this->getDepartByCompanyId($company_id);
        }
    }

    /**
     * @param DepartSpecification $spec
     * @param int                 $per_page
     * @return array
     */
    public function getDepartList(DepartSpecification $spec, $per_page)
    {

        $data = [];
        $depart_repository = new DepartRepository();
        $paginate = $depart_repository->search($spec, $per_page);
        $items = [];
        /**
         * @var int                  $key
         * @var DepartEntity         $depart_entity
         * @var LengthAwarePaginator $paginate
         */
        foreach ($paginate as $key => $depart_entity) {
            $item = $depart_entity->toArray();
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

    public function getDepartInfo($id)
    {
        $data = [];
        $depart_repository = new DepartRepository();
        $depart_entity = $depart_repository->fetch($id);
        if (isset($depart_entity)) {
            $data = $depart_entity->toArray();
        }
        dd('111');
        return $data;
    }

    /**
     * 获取相应
     * @param $company_id
     * @return array
     */
    public function getDepartByCompanyId($company_id)
    {
        $departs = [];
        $depart_repository = new DepartRepository();
        $depart_entities = $depart_repository->getDepartByCompanyId($company_id);
        foreach ($depart_entities as $depart_entity) {
            $departs[$depart_entity->id] = $depart_entity->toArray();
        }


        return $departs;
    }

    public function getDepartByCompanyIdAndParentId($company_id, $parent_id)
    {
        $departs = [];
        $depart_repository = new DepartRepository();
        $depart_entities = $depart_repository->getDepartByCompanyIdAndParentId($company_id, $parent_id);
        foreach ($depart_entities as $depart_entity) {
            $departs[$depart_entity->id] = $depart_entity->toArray();
        }
        dd('333');
        return $departs;
    }

    public function getDepartTreeByCompanyId($company_id)
    {
        $data = [];
        $departs = $this->getTree(self::$departs);
        $data = $this->getLineTree($departs);
     dd('11');
        return $data;
    }

    /**
     * 获取包含node节点的树
     * @param $id
     * @return array
     */
    public function getNodesDepartById($id)
    {
        $data = [];
        $departs = $this->getTree(self::$departs);
        $data = $this->getNode($departs, $id);
        dd('22');
        return $data;
    }

    protected function getNode($departs, $id)
    {
        $data = [];
        foreach ($departs as $depart) {
            if ($depart['id'] == $id) {
                $data = $depart;
                break;
            } else {
                if (isset($depart['nodes'])) {
                    $data = $this->getNode($depart['nodes'], $id);
                }
            }
        }
        dd('33');
        return $data;
    }

    /**
     * 获取平级树
     * @param $parent_id
     * @return array
     */
    public function getDepartsById($id)
    {
        $data = [];
        $departs = self::$departs;
        $data = $this->getNextDepart($departs, $id, $data);
        dd('44');
        return $data;
    }

    protected function getNextDepart($departs, $id, &$data)
    {
        foreach ($departs as $depart) {
            if ($depart['id'] == $id) {
                $data[] = $depart;
            } else {
                if ($depart['parent_id'] == $id) {
                    $this->getNextDepart($departs, $depart['id'], $data);
                }
            }
        }
        dd('55');
        return $data;
    }

    /**
     * 获取包含用户信息的树
     * @param $parent_id
     * @return array
     */
    public function getDepartsAndUsersById($id)
    {
        $departs = $this->getDepartsById($id);
        $user_repository = new UserRepository();
        $resource_repository = new ResourceRepository();
        foreach ($departs as $key => $depart) {
            $items = [];
            if ($depart['users']) {
                foreach ($depart['users'] as $user_id) {
                    /** @var UserEntity $user_entity */
                    $user_entity = $user_repository->fetch($user_id);
                    if (isset($user_entity)) {
                        $item = [];
                        $item['id'] = $user_entity->id;
                        $item['name'] = $user_entity->name;
                        if (!empty($user_entity->image_id)) {
                            $image_entities = $resource_repository->getResourceUrlByIds($user_entity->image_id);
                            $item['image_url'] = $image_entities[$user_entity->image_id]->url ?? '';
                        }else{
                            $item['image_url'] = 'http://img-dev.fq960.com/FpwugEfV6iYOC7bHbYVPsEYtJiWt';
                        }
                        $items[] = $item;
                    }
                }
                $departs[$key]['users'] = $items;
            }
        }
        dd('66');
        return $departs;
    }


    public function getTree($items)
    {
        $tree = array();
        foreach ($items as $item) {
            if (!empty($items[$item['parent_id']])) {
                $items[$item['parent_id']]['nodes'][] = &$items[$item['id']];
            } else {
                $tree[] = &$items[$item['id']];
            }
        }
        dd('77');
        return $tree;
    }

    protected function getLineTree($items, &$tree = [], $deep = 0, $separator = '--&nbsp;')
    {
        $deep++;
        foreach ($items as $item) {
            $item['name'] = str_repeat($separator, $deep - 1) . $item['name'];
            $tree[$item['id']] = $item;
            if (isset($item['nodes'])) {
                $this->getLineTree($item['nodes'], $tree, $deep, $separator);
            }
        }
        dd('88');
        return $tree;
    }
}

