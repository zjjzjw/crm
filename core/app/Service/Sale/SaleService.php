<?php

namespace Huifang\Service\Sale;

use Carbon\Carbon;
use Huifang\Src\Role\Domain\Model\DataType;
use Huifang\Src\Project\Domain\Model\ProjectStepType;
use Huifang\Src\Role\Domain\Model\DepartEntity;
use Huifang\Src\Role\Domain\Model\UserDataEntity;
use Huifang\Src\Role\Domain\Model\UserEntity;
use Huifang\Src\Role\Infra\Repository\DepartRepository;
use Huifang\Src\Role\Infra\Repository\UserDataRepository;
use Huifang\Src\Role\Infra\Repository\UserRepository;
use Huifang\Src\Sale\Brand\Domain\Model\BrandEntity;
use Huifang\Src\Sale\Brand\Infra\Repository\BrandRepository;
use Huifang\Src\Sale\Developer\Domain\Model\DeveloperEntity;
use Huifang\Src\Sale\Developer\Infra\Repository\DeveloperRepository;
use Huifang\Src\Sale\DeveloperGroup\Domain\Model\DeveloperGroupEntity;
use Huifang\Src\Sale\DeveloperGroup\Infra\Repository\DeveloperGroupRepository;
use Huifang\Src\Sale\Domain\Model\SaleCloseStatus;
use Huifang\Src\Sale\Domain\Model\SaleEntity;
use Huifang\Src\Sale\Domain\Model\SalePropertyEntity;
use Huifang\Src\Sale\Domain\Model\SaleSpecification;
use Huifang\Src\Sale\Domain\Model\SaleStatus;
use Huifang\Src\Sale\Infra\Eloquent\SaleModel;
use Huifang\Src\Sale\Infra\Eloquent\SalePropertyModel;
use Huifang\Src\Sale\Infra\Repository\SalePropertyRepository;
use Huifang\Src\Sale\Infra\Repository\SaleRepository;
use Huifang\Src\Sale\LargeArea\Domain\Model\LargeAreaEntity;
use Huifang\Src\Sale\LargeArea\Infra\Repository\LargeAreaRepository;
use Huifang\Src\Surport\Domain\Model\CityEntity;
use Huifang\Src\Surport\Domain\Model\CountyEntity;
use Huifang\Src\Surport\Domain\Model\ProvinceEntity;
use Huifang\Src\Surport\Infra\Repository\CityRepository;
use Huifang\Src\Surport\Infra\Repository\CountyRepository;
use Huifang\Src\Surport\Infra\Repository\ProvinceRepository;
use Illuminate\Pagination\LengthAwarePaginator;

class SaleService
{

    /**
     * @param SaleSpecification $spec
     * @param int               $per_page
     * @return array
     */
    public function getSaleList(SaleSpecification $spec, $per_page)
    {
        $data = [];
        $sale_repository = new SaleRepository();
        $paginate = $sale_repository->search($spec, $per_page);

        $items = [];
        /**
         * @var int                  $key
         * @var SaleEntity           $sale_entity
         * @var LengthAwarePaginator $paginate
         */
        foreach ($paginate as $key => $sale_entity) {
            $item = $sale_entity->toArray();
            $item['text'] = $sale_entity->project_name;
            $item['time'] = Carbon::parse($sale_entity->created_at)->format('m-d H:i');
            $items[] = $item;
        }
        $data['paginate'] = $paginate;
        $data['items'] = $items;
        $data['pager']['total'] = $paginate->total();
        $data['pager']['last_page'] = $paginate->lastPage();
        $data['pager']['current_page'] = $paginate->currentPage();

        return $data;
    }


    public function getSaleListAndProperty(SaleSpecification $spec, $per_page)
    {
        $data = [];
        $sale_repository = new SaleRepository();
        $paginate = $sale_repository->search($spec, $per_page);
        $city_repository = new CityRepository();
        $province_repository = new ProvinceRepository();
        $county_repository = new CountyRepository();
        $sale_property_repository = new SalePropertyRepository();
        $developer_repository = new DeveloperRepository();
        $large_area_repository = new LargeAreaRepository();
        $user_repository = new UserRepository();
        $items = [];
        /**
         * @var int                  $key
         * @var SaleEntity           $sale_entity
         * @var LengthAwarePaginator $paginate
         */
        foreach ($paginate as $key => $sale_entity) {
            $item = $sale_entity->toArray();

            /** @var UserEntity $user_entity */
            $user_entity = $user_repository->fetch($sale_entity->user_id);
            if (isset($user_entity)){
                $item['user_name'] = $user_entity->name;
            }
            /** @var CityEntity $city_entity */
            $city_entity = $city_repository->fetch($sale_entity->city_id);
            if (isset($city_entity)) {
                $item['city_name'] = $city_entity->name;
            }
            /** @var ProvinceEntity $province_entity */
            $province_entity = $province_repository->fetch($sale_entity->province_id);
            if (isset($province_entity)) {
                $item['province_name'] = $province_entity->name;
            }
            /** @var CountyEntity $county_entity */
            $county_entity = $county_repository->fetch($sale_entity->county_id);
            if (isset($county_entity)) {
                $item['county_name'] = $county_entity->name;
            }
            /** @var SalePropertyEntity $sale_property_entity */
            $sale_property_entity = $sale_property_repository->getSalePropertyBySaleId($sale_entity->id);
            if (isset($sale_property_entity)) {
                /** @var DeveloperEntity $developer_entity */
                $developer_entity = $developer_repository->fetch($sale_property_entity->developer_id);
                if (isset($developer_entity)) {
                    $item['developer_name'] = $developer_entity->name;
                }
                /** @var LargeAreaEntity $large_area_entity */
                $large_area_entity = $large_area_repository->fetch($sale_property_entity->project_region_id);
                if (isset($large_area_entity)) {
                    $item['large_area_name'] = $large_area_entity->name;
                }
                $item['at_hardcover_house_total'] = $sale_property_entity->at_hardcover_house_total;
                $item['house_total'] = $sale_property_entity->house_total;
                $item['hardcover_standard'] = $sale_property_entity->hardcover_standard;
                $item['housing_price'] = $sale_property_entity->housing_price;
                $item['opening_time'] = $sale_property_entity->opening_time;
                $item['handing_time'] = $sale_property_entity->handing_time;
                $item['loupan_name'] = $sale_property_entity->loupan_name;
                $item['updated_at'] = $sale_property_entity->updated_at;
            }
            $item['time'] = Carbon::parse($sale_entity->created_at)->format('m-d H:i');
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
     * @param SaleSpecification $spec
     * @param int               $per_page
     * @return array
     */
    public function getTouchSaleList(SaleSpecification $spec, $per_page)
    {
        $data = [];
        $sale_repository = new SaleRepository();
        $paginate = $sale_repository->search($spec, $per_page);

        $items = [];
        /**
         * @var int                  $key
         * @var SaleEntity           $sale_entity
         * @var LengthAwarePaginator $paginate
         */
        foreach ($paginate as $key => $sale_entity) {
            $item = $sale_entity->toArray();
            $item['text'] = $sale_entity->project_name;
            $item['time'] = Carbon::parse($sale_entity->created_at)->format('m-d H:i');
            $item['url'] = route('sale.detail', ['id' => $sale_entity->id]);
            $items[] = $item;
        }

        $data['items'] = $items;
        $data['pager']['total'] = $paginate->total();
        $data['pager']['last_page'] = $paginate->lastPage();
        $data['pager']['current_page'] = $paginate->currentPage();

        return $data;
    }


    /**
     * @param SaleSpecification $spec
     * @param int               $limit
     * @return array
     */
    public function getSaleListByKeyword(SaleSpecification $spec, $limit = 20)
    {
        $items = [];
        $sale_repository = new SaleRepository();
        $sale_entities = $sale_repository->getSaleListByKeyword($spec, $limit);

        foreach ($sale_entities as $sale_entity) {
            $item = $sale_entity->toArray();
            $item['name'] = $sale_entity->project_name;
            $item['time'] = Carbon::parse($sale_entity->created_at)->format('m-d H:i');
            $item['url'] = route('sale.detail', ['id' => $sale_entity->id]);
            $items[] = $item;
        }
        return $items;
    }


    public function getSaleInfo($id)
    {
        $sale_repository = new SaleRepository();
        /** @var SaleEntity $sale_entity */
        $sale_entity = $sale_repository->fetch($id);
        $data = $sale_entity->toArray();
        $city_repository = new CityRepository();
        $city_entity = $city_repository->fetch($sale_entity->city_id);
        if ($city_entity) {
            $data['city'] = $city_entity->toArray();
        }
        $province_repository = new ProvinceRepository();
        $province_repository->fetch($sale_entity->province_id);
        $province_entity = $province_repository->fetch($sale_entity->province_id);
        if ($province_entity) {
            $data['province'] = $province_entity->toArray();
        }
        $data['sale_user'] = [];
        //得到销售线索的负责人信息
        if ($sale_entity->user_id) {
            $user_repository = new UserRepository();
            $user_entity = $user_repository->fetch($sale_entity->user_id);
            if ($user_entity) {
                $data['sale_user'] = $user_entity->toArray();
            }
        }
        //项目阶段类型
        $project_step_types = ProjectStepType::acceptableEnums();
        $data['project_step_types'] = $project_step_types;
        if (isset($project_step_types[$sale_entity->project_step_id])) {
            $data['project_step_type_name'] = $project_step_types[$sale_entity->project_step_id];
        }
        $sale_statuses = SaleStatus::acceptableEnums();
        $data['status_name'] = $sale_statuses[$sale_entity->status] ?? '';

        $close_statuses = SaleCloseStatus::acceptableEnums();
        $data['close_status_name'] = $close_statuses[$sale_entity->close_status] ?? '';

        return $data;
    }

    public function getSaleAndPropertyInfo($id)
    {
        $data = [];
        $sale_repository = new SaleRepository();
        $sale_property_repository = new SalePropertyRepository();
        $brand_repository = new BrandRepository();
        $developer_group_repository = new DeveloperGroupRepository();
        $developer_repository = new DeveloperRepository();
        $user_repository = new UserRepository();
        /** @var SaleEntity $sale_entity */
        $sale_entity = $sale_repository->fetch($id);
        /** @var SalePropertyEntity $sale_property_entity */
        $sale_property_entity = $sale_property_repository->getSalePropertyBySaleId($id);
        if (isset($sale_entity)) {
            $data = $sale_entity->toArray();
            /** @var UserEntity $user_entity */
            $user_entity = $user_repository->fetch($sale_entity->user_id);
            if (isset($user_entity)){
                $data['user_name'] = $user_entity->name;
            }
            if (isset($sale_property_entity)) {
                $item = $sale_property_entity->toArray();
                /** @var BrandEntity $brand_entity */
                $brand_entity = $brand_repository->fetch($sale_property_entity->brand_id);
                if (isset($brand_entity)) {
                    $item['brand_name'] = $brand_entity->brand_name;
                }
                /** @var DeveloperGroupEntity $developer_group_entity */
                $developer_group_entity = $developer_group_repository->fetch($sale_property_entity->developer_group_id);
                if (isset($developer_group_entity)) {
                    $item['developer_group_name'] = $developer_group_entity->name;
                }
                /** @var DeveloperEntity $developer_entity */
                $developer_entity = $developer_repository->fetch($sale_property_entity->developer_id);
                if (isset($developer_entity)){
                    $item['developer_property_name'] = $developer_entity->name;
                }
                $data = array_merge($data, $item);
            }
        }
        return $data;
    }

    /**
     * @param SaleSpecification $spec
     * @param int               $per_page
     * @return array
     */
    public function getApprovalSaleList(SaleSpecification $spec, $per_page)
    {
        $data = [];
        $sale_repository = new SaleRepository();
        $paginate = $sale_repository->search($spec, $per_page);

        $items = [];
        /**
         * @var int                  $key
         * @var SaleEntity           $sale_entity
         * @var LengthAwarePaginator $paginate
         */
        foreach ($paginate as $key => $sale_entity) {
            $item = $sale_entity->toArray();
            $item['text'] = $sale_entity->project_name;
            $item['time'] = Carbon::parse($sale_entity->created_at)->format('m-d H:i');
            $item['url'] = route('user.approval.sale.detail', ['id' => $item['id']]);
            $items[] = $item;
        }

        $data['items'] = $items;
        $data['pager']['total'] = $paginate->total();
        $data['pager']['last_page'] = $paginate->lastPage();
        $data['pager']['current_page'] = $paginate->currentPage();

        return $data;
    }

    /**
     * 导入数据函数
     * @param array $rows
     */
    public function importSaleData($user, $rows)
    {
        $sale_repository = new SaleRepository();
        foreach ($rows as $row) {
            $sale_entity = $sale_repository->getSaleByProjectNameAndAddress($user->company->id, $row[0], $row[3]);
            if (!isset($sale_entity)) {
                $sale_entity = new SaleEntity();
                $sale_entity->user_id = 0;
                $sale_entity->company_id = $user->company->id;
                $sale_entity->project_name = $row[0];
                $sale_entity->province_id = $row[1];
                $sale_entity->city_id = $row[2];
                $sale_entity->address = $row[3];
                $sale_entity->developer_name = $row[4];
                $sale_entity->developer_group_name = $row[5];
                $sale_entity->project_volume = $row[6];
                $sale_entity->project_step_id = $row[7];
                $sale_entity->contact_name = $row[8];
                $sale_entity->position_name = $row[9];
                $sale_entity->contact_phone = $row[10];
                $sale_entity->created_user_id = $user->id;
                $sale_entity->status = SaleStatus::TO_ASSIGN;
                $sale_entity->close_status = 0;
                $sale_repository->save($sale_entity);
            }
        }
    }


    public function saveSaleProperty($sale_data)
    {
        $sale_model = SaleModel::find($sale_data['id']);
        if (isset($sale_model)) {
            if (isset($sale_data['project_name'])) {
                $sale_model->project_name = $sale_data['project_name'];
            }
            if (isset($sale_data['sn'])) {
                $sale_model->sn = $sale_data['sn'];
            }
            if (isset($sale_data['province_id'])) {
                $sale_model->province_id = $sale_data['province_id'];
            }
            if (isset($sale_data['city_id'])) {
                $sale_model->city_id = $sale_data['city_id'];
            }
            if (isset($sale_data['county_id'])) {
                $sale_model->county_id = $sale_data['county_id'];
            }
            if (isset($sale_data['user_id'])) {
                $sale_model->user_id = $sale_data['user_id'];
            }
            if (isset($sale_data['address'])) {
                $sale_model->address = $sale_data['address'];
            }
            if (isset($sale_data['developer_name'])) {
                $sale_model->developer_name = $sale_data['developer_name'];
            }
            if (isset($sale_data['developer_group_name'])) {
                $sale_model->developer_group_name = $sale_data['developer_group_name'];
            }
            if (isset($sale_data['project_volume'])) {
                $sale_model->project_volume = $sale_data['project_volume'];
            }
            if (isset($sale_data['project_step_id'])) {
                $sale_model->project_step_id = $sale_data['project_step_id'];
            }
            if (isset($sale_data['contact_name'])) {
                $sale_model->contact_name = $sale_data['contact_name'];
            }
            if (isset($sale_data['position_name'])) {
                $sale_model->position_name = $sale_data['position_name'];
            }
            if (isset($sale_data['contact_phone'])) {
                $sale_model->contact_phone = $sale_data['contact_phone'];
            }
            $sale_model->save();

            //楼盘数据
            $sale_property_model = SalePropertyModel::where(['sale_id' => $sale_data['id']])->first();
            if (!isset($sale_property_model)) {
                $sale_property_model = new SalePropertyModel();
            }
            $sale_property_model->sale_id = $sale_data['id'];
            if (isset($sale_data['developer_id'])) {
                $sale_property_model->developer_id = $sale_data['developer_id'];
            }
            if (isset($sale_data['developer_group_id'])) {
                $sale_property_model->developer_group_id = $sale_data['developer_group_id'];
            }
            if (isset($sale_data['record_time'])) {
                $sale_property_model->record_time = $sale_data['record_time'];
            }
            if (isset($sale_data['loupan_name'])) {
                $sale_property_model->loupan_name = $sale_data['loupan_name'];
            }
            if (isset($sale_data['project_region_id'])) {
                $sale_property_model->project_region_id = $sale_data['project_region_id'];
            }
            if (isset($sale_data['sale_status'])) {
                $sale_property_model->sale_status = $sale_data['sale_status'];
            }
            if (isset($sale_data['building_developer_name'])) {
                $sale_property_model->building_developer_name = $sale_data['building_developer_name'];
            }
            if (isset($sale_data['decoration_type'])) {
                $sale_property_model->decoration_type = $sale_data['decoration_type'];
            }
            if (isset($sale_data['house_total'])) {
                $sale_property_model->house_total = $sale_data['house_total'];
            }
            if (isset($sale_data['hardcover_standard'])) {
                $sale_property_model->hardcover_standard = $sale_data['hardcover_standard'];
            }
            if (isset($sale_data['at_hardcover_house_total'])) {
                $sale_property_model->at_hardcover_house_total = $sale_data['at_hardcover_house_total'];
            }
            if (isset($sale_data['floor_condition'])) {
                $sale_property_model->floor_condition = $sale_data['floor_condition'];
            }
            if (isset($sale_data['floor_total'])) {
                $sale_property_model->floor_total = $sale_data['floor_total'];
            }
            if (isset($sale_data['area_covered'])) {
                $sale_property_model->area_covered = $sale_data['area_covered'];
            }
            if (isset($sale_data['architecture_covered'])) {
                $sale_property_model->architecture_covered = $sale_data['architecture_covered'];
            }
            if (isset($sale_data['project_schedule'])) {
                $sale_property_model->project_schedule = $sale_data['project_schedule'];
            }
            if (isset($sale_data['property_type'])) {
                $sale_property_model->property_type = $sale_data['property_type'];
            }
            if (isset($sale_data['property_company'])) {
                $sale_property_model->property_company = $sale_data['property_company'];
            }
            if (isset($sale_data['housing_price'])) {
                $sale_property_model->housing_price = $sale_data['housing_price'];
            }
            if (isset($sale_data['has_sample_house'])) {
                $sale_property_model->has_sample_house = $sale_data['has_sample_house'];
            }
            if (isset($sale_data['brand_id'])) {
                $sale_property_model->brand_id = $sale_data['brand_id'];
            }
            if (isset($sale_data['opening_time'])) {
                $sale_property_model->opening_time = $sale_data['opening_time'];
            }
            if (isset($sale_data['handing_time'])) {
                $sale_property_model->handing_time = $sale_data['handing_time'];
            }
            if (isset($sale_data['sale_phone'])) {
                $sale_property_model->sale_phone = $sale_data['sale_phone'];
            }
            if (isset($sale_data['strategy_id'])) {
                $sale_property_model->strategy_id = $sale_data['strategy_id'];
            }
            if (isset($sale_data['strategy_brand_other'])) {
                $sale_property_model->strategy_brand_other = $sale_data['strategy_brand_other'];
            }
            if (isset($sale_data['kitchen_budget'])) {
                $sale_property_model->kitchen_budget = $sale_data['kitchen_budget'];
            }
            if (isset($sale_data['kitchen_configuration'])) {
                $sale_property_model->kitchen_configuration = $sale_data['kitchen_configuration'];
            }
            if (isset($sale_data['contend_brand'])) {
                $sale_property_model->contend_brand = $sale_data['contend_brand'];
            }
            if (isset($sale_data['project_position'])) {
                $sale_property_model->project_position = $sale_data['project_position'];
            }
            if (isset($sale_data['project_status'])) {
                $sale_property_model->project_status = $sale_data['project_status'];
            }
            if (isset($sale_data['project_estimate_signed_time'])) {
                $sale_property_model->project_estimate_signed_time = $sale_data['project_estimate_signed_time'];
            }
            if (isset($sale_data['project_estimate_price'])) {
                $sale_property_model->project_estimate_price = $sale_data['project_estimate_price'];
            }
            if (isset($sale_data['project_estimate_status'])) {
                $sale_property_model->project_estimate_status = $sale_data['project_estimate_status'];
            }
            if (isset($sale_data['project_loss_reason'])) {
                $sale_property_model->project_loss_reason = $sale_data['project_loss_reason'];
            }
            if (isset($sale_data['remake'])) {
                $sale_property_model->remake = $sale_data['remake'];
            }
            $sale_property_model->save();
        }
    }
}

