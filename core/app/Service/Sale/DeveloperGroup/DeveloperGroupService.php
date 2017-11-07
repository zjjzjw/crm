<?php

namespace Huifang\Service\Sale\DeveloperGroup;

use Huifang\Src\Sale\DeveloperGroup\Domain\Model\DeveloperGroupEntity;
use Huifang\Src\Sale\DeveloperGroup\Domain\Model\DeveloperGroupSpecification;
use Huifang\Src\Sale\DeveloperGroup\Infra\Repository\DeveloperGroupRepository;

class DeveloperGroupService
{
    /**
     * @param DeveloperGroupSpecification $spec
     * @param int                         $per_page
     * @return array
     */
    public function getDeveloperGroupList(DeveloperGroupSpecification $spec, $per_page)
    {
        $data = [];
        $developerGroup_repository = new DeveloperGroupRepository();
        $paginate = $developerGroup_repository->search($spec, $per_page);
        $items = [];
        foreach ($paginate as $key => $developerGroup_entity) {
            $item = $developerGroup_entity->toArray();
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
     * 品牌详情
     * @param $id
     * @return array
     */
    public function getDeveloperGroupInfo($id)
    {
        $data = [];
        $developerGroup_repository = new DeveloperGroupRepository();
        $developerGroup_entity = $developerGroup_repository->fetch($id);

        if (isset($developerGroup_entity)) {
            $data = $developerGroup_entity->toArray();
        }
        return $data;
    }


}

