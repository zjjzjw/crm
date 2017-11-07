<?php namespace Huifang\Src\Sale\Infra\Repository;

use Carbon\Carbon;
use Huifang\Src\Foundation\Domain\Repository;
use Huifang\Src\Sale\Domain\Interfaces\SalePropertyInterface;
use Huifang\Src\Sale\Domain\Model\SalePropertyEntity;
use Huifang\Src\Sale\Domain\Model\SalePropertySpecification;
use Huifang\Src\Sale\Infra\Eloquent\SalePropertyModel;


class SalePropertyRepository extends Repository implements SalePropertyInterface
{
    /**
     * Store an entity into persistence.
     *
     * @param SalePropertyEntity $sale_entity
     */
    protected function store($sale_entity)
    {
        if ($sale_entity->isStored()) {
            $model = SalePropertyModel::find($sale_entity->id);
        } else {
            $model = new SalePropertyModel();
        }
        $model->fill(
            [
                'sale_id'                      => $sale_entity->sale_id,
                'developer_id'                 => $sale_entity->developer_id,
                'developer_group_id'           => $sale_entity->developer_group_id,
                'record_time'                  => $sale_entity->record_time,
                'loupan_name'                  => $sale_entity->loupan_name,
                'project_region_id'            => $sale_entity->project_region_id,
                'sale_status'                  => $sale_entity->sale_status,
                'building_developer_name'      => $sale_entity->building_developer_name,
                'decoration_type'              => $sale_entity->decoration_type,
                'house_total'                  => $sale_entity->house_total,
                'hardcover_standard'           => $sale_entity->hardcover_standard,
                'at_hardcover_house_total'     => $sale_entity->at_hardcover_house_total,
                'floor_condition'              => $sale_entity->floor_condition,
                'floor_total'                  => $sale_entity->floor_total,
                'area_covered'                 => $sale_entity->area_covered,
                'architecture_covered'         => $sale_entity->architecture_covered,
                'project_schedule'             => $sale_entity->project_schedule,
                'property_type'                => $sale_entity->property_type,
                'property_company'             => $sale_entity->property_company,
                'housing_price'                => $sale_entity->housing_price,
                'has_sample_house'             => $sale_entity->has_sample_house,
                'brand_id'                     => $sale_entity->brand_id,
                'opening_time'                 => $sale_entity->opening_time,
                'handing_time'                 => $sale_entity->handing_time,
                'sale_phone'                   => $sale_entity->sale_phone,
                'strategy_id'                  => $sale_entity->strategy_id,
                'strategy_brand_other'         => $sale_entity->strategy_brand_other,
                'kitchen_budget'               => $sale_entity->kitchen_budget,
                'kitchen_configuration'        => $sale_entity->kitchen_configuration,
                'contend_brand'                => $sale_entity->contend_brand,
                'project_position'             => $sale_entity->project_position,
                'project_status'               => $sale_entity->project_status,
                'project_estimate_signed_time' => $sale_entity->project_estimate_signed_time,
                'project_estimate_price'       => $sale_entity->project_estimate_price,
                'project_estimate_status'      => $sale_entity->project_estimate_status,
                'project_loss_reason'          => $sale_entity->project_loss_reason,
                'remake'                       => $sale_entity->remake,
            ]
        );
        $model->save();
        $sale_entity->setIdentity($model->id);
    }

    /**
     * Reconstitute an entity from persistence.
     *
     * @param mixed $id
     * @param array $params Additional params.
     *
     * @return SalePropertyEntity
     */
    protected function reconstitute($id, $params = [])
    {
        $model = SalePropertyModel::find($id);
        if (!isset($model)) {
            return null;
        }
        return $this->reconstituteFromModel($model);
    }

    /**
     * @param SalePropertyModel $model
     *
     * @return SalePropertyEntity
     */
    private function reconstituteFromModel($model)
    {
        $entity = new SalePropertyEntity();
        $entity->id = $model->id;
        $entity->sale_id = $model->sale_id;
        $entity->developer_id = $model->developer_id;
        $entity->developer_group_id = $model->developer_group_id;
        $entity->record_time = $model->record_time;
        $entity->loupan_name = $model->loupan_name;
        $entity->project_region_id = $model->project_region_id;
        $entity->sale_status = $model->sale_status;
        $entity->building_developer_name = $model->building_developer_name;
        $entity->decoration_type = $model->decoration_type;
        $entity->house_total = $model->house_total;
        $entity->hardcover_standard = $model->hardcover_standard;
        $entity->at_hardcover_house_total = $model->at_hardcover_house_total;
        $entity->floor_condition = $model->floor_condition;
        $entity->floor_total = $model->floor_total;
        $entity->area_covered = $model->area_covered;
        $entity->architecture_covered = $model->architecture_covered;
        $entity->project_schedule = $model->project_schedule;
        $entity->property_type = $model->property_type;
        $entity->property_company = $model->property_company;
        $entity->housing_price = $model->housing_price;
        $entity->has_sample_house = $model->has_sample_house;
        $entity->brand_id = $model->brand_id;
        $entity->opening_time = $model->opening_time;
        $entity->handing_time = $model->handing_time;
        $entity->sale_phone = $model->sale_phone;
        $entity->strategy_id = $model->strategy_id;
        $entity->strategy_brand_other = $model->strategy_brand_other;
        $entity->kitchen_budget = $model->kitchen_budget;
        $entity->kitchen_configuration = $model->kitchen_configuration;
        $entity->contend_brand = $model->contend_brand;
        $entity->project_position = $model->project_position;
        $entity->project_status = $model->project_status;
        $entity->project_estimate_signed_time = $model->project_estimate_signed_time;
        $entity->project_estimate_price = $model->project_estimate_price;
        $entity->project_estimate_status = $model->project_estimate_status;
        $entity->project_loss_reason = $model->project_loss_reason;
        $entity->remake = $model->remake;
        $entity->created_at = $model->created_at;
        $entity->updated_at = $model->updated_at;
        $entity->setIdentity($model->id);
        $entity->stored();
        return $entity;
    }

    /**
     * @param SalePropertySpecification $spec
     * @param int                       $per_page
     * @return mixed
     */
    public function search(SalePropertySpecification $spec, $per_page = 10)
    {
        $builder = SalePropertyModel::query();

        if ($spec->page) {
            $paginator = $builder->paginate($per_page, ['*'], 'page', $spec->page);
        } else {
            $paginator = $builder->paginate($per_page);
        }

        foreach ($paginator as $key => $model) {
            $paginator[$key] = $this->reconstituteFromModel($model)->stored();
        }

        return $paginator;
    }


    /**
     * @param int|array $ids
     */
    public function delete($ids)
    {
        $builder = SalePropertyModel::query();
        $builder->whereIn('id', (array)$ids);
        $models = $builder->get();
        foreach ($models as $model) {
            $model->delete();
        }
    }

    public function getSalePropertyBySaleId($sale_id)
    {
        $builder = SalePropertyModel::query();
        $builder->where('sale_id', $sale_id);
        $model = $builder->first();
        if (!isset($model)) {
            return null;
        }
        return $this->reconstituteFromModel($model);
    }
}