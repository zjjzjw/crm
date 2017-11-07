<?php

namespace Huifang\Service\Sale\Brand;

use Huifang\Src\Sale\Brand\Domain\Model\BrandEntity;
use Huifang\Src\Sale\Brand\Domain\Model\BrandSpecification;
use Huifang\Src\Sale\Brand\Infra\Repository\BrandRepository;

class BrandService
{


    /**
     * @param BrandSpecification $spec
     * @param int                $per_page
     * @return array
     */
    public function getBrandList(BrandSpecification $spec, $per_page)
    {
        $data = [];
        $brand_repository = new BrandRepository();
        $paginate = $brand_repository->search($spec, $per_page);
        $items = [];
        foreach ($paginate as $key => $brand_entity) {
            $item = $brand_entity->toArray();
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
    public function getBrandInfo($id)
    {
        $data = [];
        $brand_repository = new BrandRepository();
        $brand_entity = $brand_repository->fetch($id);

        if (isset($brand_entity)) {
            $data = $brand_entity->toArray();
        }
        return $data;
    }


}

