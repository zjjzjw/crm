<?php

namespace Huifang\Service\Product;

use Huifang\Src\Product\Domain\Model\RivalEntity;
use Huifang\Src\Product\Domain\Model\RivalSpecification;
use Huifang\Src\Product\Infra\Repository\RivalRepository;

class RivalService
{

    public function getRivalsByCompanyId($company_id)
    {
        $items = [];
        $rival_repository = new RivalRepository();
        $rival_entities = $rival_repository->getRivalsByCompanyId($company_id);
        foreach ($rival_entities as $rival_entity) {
            $item = $rival_entity->toArray();
            $items[] = $item;
        }
        return $items;
    }

    /**
     * @param RivalSpecification $spec
     * @param int                $per_page
     * @return array
     */
    public function getRivalList(RivalSpecification $spec, $per_page)
    {
        $data = [];
        $rival_repository = new RivalRepository();
        $paginate = $rival_repository->search($spec, $per_page);

        $items = [];
        /**
         * @var mixed       $key
         * @var RivalEntity $rival_entity
         */
        foreach ($paginate as $key => $rival_entity) {
            $item = $rival_entity->toArray();
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
     * 竞品公司详情
     * @param $id
     * @return array
     */
    public function getRivalInfo($id)
    {
        $data = [];
        $rival_repository = new RivalRepository();
        $rival_entity = $rival_repository->fetch($id);
        if (isset($rival_entity)) {
            $data = $rival_entity->toArray();
        }
        return $data;
    }
}

