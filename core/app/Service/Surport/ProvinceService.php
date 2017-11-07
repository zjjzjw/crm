<?php

namespace Huifang\Service\Surport;

use Huifang\Src\Surport\Infra\Eloquent\CityModel;
use Huifang\Src\Surport\Infra\Eloquent\CountyModel;
use Huifang\Src\Surport\Infra\Eloquent\ProvinceModel;
use Huifang\Src\Surport\Infra\Repository\CityRepository;
use Huifang\Src\Surport\Infra\Repository\CountyRepository;
use Huifang\Src\Surport\Infra\Repository\ProvinceRepository;

class ProvinceService
{
    public function getProvinceForMobi()
    {
        $rows = [];
        $province_repository = new ProvinceRepository();
        $province_models = $province_repository->all();
        $provinces = [];
        /** @var ProvinceModel $province_model */
        foreach ($province_models as $province_model) {
            $provinces[] = $province_model->toArray();
        }
        $all_province = [
            "id"      => 0,
            "name"    => "全国",
            "area_id" => 0,
            "nodes"   => [],
        ];
        array_unshift($provinces, $all_province);
        $city_repository = new CityRepository();
        $city_models = $city_repository->all();
        $cities = [];
        /** @var CityModel $city_model */
        foreach ($city_models as $city_model) {
            $cities[] = $city_model->toArray();
        }
        foreach ($provinces as &$province) {
            $province['nodes'] = collect($cities)->where('province_id', $province['id'])->toArray();
            $city_all = [
                "id"          => 0,
                "province_id" => $province['id'],
                "name"        => "全部",
                "lng"         => '',
                "lat"         => '',
            ];
            array_unshift($province['nodes'], $city_all);
            $rows[] = $province;
        }
        return $rows;
    }

    public function getProvinceForSale()
    {
        $rows = [];
        $province_repository = new ProvinceRepository();
        $province_models = $province_repository->all();
        $provinces = [];
        /** @var ProvinceModel $province_model */
        foreach ($province_models as $province_model) {
            $provinces[] = $province_model->toArray();
        }
        $city_repository = new CityRepository();
        $city_models = $city_repository->all();
        $cities = [];
        /** @var CityModel $city_model */
        foreach ($city_models as $city_model) {
            $cities[] = $city_model->toArray();
        }
        foreach ($provinces as &$province) {
            $province['nodes'] = array_values(collect($cities)->where('province_id', $province['id'])->toArray());
            $rows[] = $province;
        }
        return $rows;
    }

    public function getProvinceForProject()
    {
        $rows = [];
        $province_repository = new ProvinceRepository();
        $province_models = $province_repository->all();
        $provinces = [];
        /** @var ProvinceModel $province_model */
        foreach ($province_models as $province_model) {
            $provinces[] = $province_model->toArray();
        }
        $city_repository = new CityRepository();
        $city_models = $city_repository->all();
        $cities = [];
        /** @var CityModel $city_model */
        foreach ($city_models as $city_model) {
            $cities[] = $city_model->toArray();
        }
        foreach ($provinces as &$province) {
            $province['nodes'] = collect($cities)->where('province_id', $province['id'])->toArray();
            $rows[] = $province;
        }
        return $rows;
    }

    public function getProvinceForCustomer()
    {
        $rows = [];
        $province_repository = new ProvinceRepository();
        $province_models = $province_repository->all();
        $provinces = [];
        /** @var ProvinceModel $province_model */
        foreach ($province_models as $province_model) {
            $provinces[] = $province_model->toArray();
        }
        $city_repository = new CityRepository();
        $city_models = $city_repository->all();
        $cities = [];
        /** @var CityModel $city_model */
        foreach ($city_models as $city_model) {
            $cities[] = $city_model->toArray();
        }
        foreach ($provinces as &$province) {
            $province['nodes'] = collect($cities)->where('province_id', $province['id'])->toArray();
            $rows[] = $province;
        }
        return $rows;
    }


    public function getProvinceForSearch()
    {
        $rows = [];
        $province_repository = new ProvinceRepository();
        $province_models = $province_repository->all();
        $provinces = [];
        /** @var ProvinceModel $province_model */
        foreach ($province_models as $province_model) {
            $provinces[] = $province_model->toArray();
        }
        $city_repository = new CityRepository();
        $city_models = $city_repository->all();
        $cities = [];
        /** @var CityModel $city_model */
        foreach ($city_models as $city_model) {
            $cities[] = $city_model->toArray();
        }

        $counties = [];
        $county_repository = new CountyRepository();
        $county_models = $county_repository->all();
        /** @var CountyModel $county_model */
        foreach ($county_models as $county_model) {
            $counties[] = $county_model->toArray();
        }

        foreach ($provinces as &$province) {
            $province['nodes'] = collect($cities)->where('province_id', $province['id'])->toArray();
            foreach ($province['nodes'] as $key => $node) {
                $county_list = collect($counties)->where('city_id', $node['id'])->toArray();
                if (!empty($county_list)){
                    $province['nodes'][$key]['nodes'][] = collect($counties)->where('city_id', $node['id'])->toArray();
                }
            }
            $rows[] = $province;
        }

        return $rows;
    }
}