<?php

namespace Huifang\Service\Sale\Developer;

use Huifang\Src\Sale\Developer\Domain\Model\DeveloperEntity;
use Huifang\Src\Sale\Developer\Domain\Model\DeveloperSpecification;
use Huifang\Src\Sale\Developer\Infra\Repository\DeveloperRepository;
use Huifang\Src\Surport\Domain\Model\CityEntity;
use Huifang\Src\Surport\Domain\Model\ProvinceEntity;
use Huifang\Src\Surport\Infra\Repository\CityRepository;
use Huifang\Src\Surport\Infra\Repository\ProvinceRepository;


class DeveloperService
{

    /**
     * @param DeveloperSpecification $spec
     * @param int                    $per_page
     * @return array
     */
    public function getDeveloperList(DeveloperSpecification $spec, $per_page)
    {
        $data = [];
        $developer_repository = new DeveloperRepository();
        $province_repository = new ProvinceRepository();
        $city_repository = new CityRepository();
        $paginate = $developer_repository->search($spec, $per_page);
        $items = [];
        /**
         * @var                  $key
         * @var  DeveloperEntity $developer_entity
         */
        foreach ($paginate as $key => $developer_entity) {
            $item = $developer_entity->toArray();
            $paginate[$key] = $item;
            /** @var ProvinceEntity $province_entity */
            $province_entity = $province_repository->fetch($developer_entity->province_id);
            $item['province_name'] = $province_entity->name ?? '';
            /** @var CityEntity $city_entity */
            $city_entity = $city_repository->fetch($developer_entity->city_id);
            $item['city_name'] = $city_entity->name ?? '';
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
     * 分公司详情
     * @param $id
     * @return array
     */
    public function getDeveloperInfo($id)
    {
        $data = [];
        $developer_repository = new DeveloperRepository();
        $developer_entity = $developer_repository->fetch($id);

        if (isset($developer_entity)) {
            $data = $developer_entity->toArray();
        }
        return $data;
    }


}

