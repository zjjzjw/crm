<?php

namespace Huifang\Service\Sale\LargeArea;

use Huifang\Src\Sale\LargeArea\Domain\Model\LargeAreaEntity;
use Huifang\Src\Sale\LargeArea\Domain\Model\LargeAreaSpecification;
use Huifang\Src\Sale\LargeArea\Infra\Repository\LargeAreaRepository;

class LargeAreaService
{
    /**
     * @param LargeAreaSpecification $spec
     * @param int                    $per_page
     * @return array
     */
    public function getLargeAreaList(LargeAreaSpecification $spec, $per_page)
    {

        $data = [];
        $largeArea_repository = new LargeAreaRepository();

        $paginate = $largeArea_repository->search($spec, $per_page);
        $items = [];
        foreach ($paginate as $key => $largeArea_entity) {
            $item = $largeArea_entity->toArray();
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
     * 大区详情
     * @param $id
     * @return array
     */
    public function getLargeAreaInfo($id)
    {
        $data = [];
        $largeArea_repository = new LargeAreaRepository();
        $largeArea_entity = $largeArea_repository->fetch($id);

        if (isset($largeArea_entity)) {
            $data = $largeArea_entity->toArray();
        }
        return $data;
    }

    public function getLargeAreaByCompanyId($company_id)
    {
        $data = [];
        $large_area_repository = new LargeAreaRepository();
        $large_area_entities = $large_area_repository->getLargeAreaByCompanyId($company_id);
        /** @var LargeAreaEntity $large_area_entity */
        foreach ($large_area_entities as $large_area_entity) {
            $data[] = $large_area_entity->toArray();
        }
        return $data;
    }
}

