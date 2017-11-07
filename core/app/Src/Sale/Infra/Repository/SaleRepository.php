<?php namespace Huifang\Src\Sale\Infra\Repository;

use Carbon\Carbon;
use Huifang\Src\Foundation\Domain\Repository;
use Huifang\Src\Sale\Domain\Interfaces\SaleInterface;
use Huifang\Src\Sale\Domain\Model\SaleEntity;
use Huifang\Src\Sale\Domain\Model\SalePropertyEntity;
use Huifang\Src\Sale\Domain\Model\SaleSpecification;
use Huifang\Src\Sale\Infra\Eloquent\SaleModel;


class SaleRepository extends Repository implements SaleInterface
{
    /**
     * Store an entity into persistence.
     *
     * @param SaleEntity $sale_entity
     */
    protected function store($sale_entity)
    {
        if ($sale_entity->isStored()) {
            $model = SaleModel::find($sale_entity->id);
        } else {
            $model = new SaleModel();
        }
        $model->fill(
            [
                'user_id'              => $sale_entity->user_id,
                'sn'                   => $sale_entity->sn,
                'company_id'           => $sale_entity->company_id,
                'project_name'         => $sale_entity->project_name,
                'province_id'          => $sale_entity->province_id,
                'city_id'              => $sale_entity->city_id,
                'county_id'            => $sale_entity->county_id,
                'address'              => $sale_entity->address,
                'developer_name'       => $sale_entity->developer_name,
                'developer_group_name' => $sale_entity->developer_group_name,
                'project_volume'       => $sale_entity->project_volume,
                'project_step_id'      => $sale_entity->project_step_id,
                'contact_name'         => $sale_entity->contact_name,
                'position_name'        => $sale_entity->position_name,
                'contact_phone'        => $sale_entity->contact_phone,
                'created_user_id'      => $sale_entity->created_user_id,
                'status'               => $sale_entity->status,
                'close_status'         => $sale_entity->close_status,
                'close_reason'         => $sale_entity->close_reason,
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
     * @return SaleEntity
     */
    protected function reconstitute($id, $params = [])
    {
        $model = SaleModel::find($id);
        if (!isset($model)) {
            return null;
        }
        return $this->reconstituteFromModel($model);
    }

    /**
     * @param SaleModel $model
     *
     * @return SaleEntity
     */
    private function reconstituteFromModel($model)
    {
        $entity = new SaleEntity();
        $entity->id = $model->id;
        $entity->user_id = $model->user_id;
        $entity->sn = $model->sn;
        $entity->company_id = $model->company_id;
        $entity->project_name = $model->project_name;
        $entity->province_id = $model->province_id;
        $entity->city_id = $model->city_id;
        $entity->county_id = $model->county_id;
        $entity->address = $model->address;
        $entity->developer_name = $model->developer_name;
        $entity->developer_group_name = $model->developer_group_name;
        $entity->project_volume = $model->project_volume;
        $entity->project_step_id = $model->project_step_id;
        $entity->contact_name = $model->contact_name;
        $entity->position_name = $model->position_name;
        $entity->contact_phone = $model->contact_phone;
        $entity->created_user_id = $model->created_user_id;
        $entity->status = $model->status;
        $entity->close_status = $model->close_status;
        $entity->close_reason = $model->close_reason;
        $entity->created_at = $model->created_at;
        $entity->updated_at = $model->updated_at;
        $entity->setIdentity($model->id);
        $entity->stored();
        return $entity;
    }

    /**
     * @param SaleSpecification $spec
     * @param int               $per_page
     * @return mixed
     */
    public function search(SaleSpecification $spec, $per_page = 10)
    {
        $builder = SaleModel::query();

        if (isset($spec->user_ids)) {
            $builder->whereIn('user_id', (array)$spec->user_ids);
        }
        if ($spec->user_id) {
            $builder->where('user_id', $spec->user_id);
        }
        if ($spec->select_user_id) {
            $builder->where('user_id', $spec->select_user_id);
        }
        if ($spec->province_id) {
            $builder->where('province_id', $spec->province_id);
        }
        if ($spec->city_id) {
            $builder->where('city_id', $spec->city_id);
        }
        if ($spec->company_id) {
            $builder->where('company_id', $spec->company_id);
        }
        if ($spec->project_step_type) {
            $builder->where('project_step_id', $spec->project_step_type);
        }
        if ($spec->status) {
            $builder->whereIn('status', (array)$spec->status);
        }
        if ($spec->close_status) {
            $builder->whereIn('close_status', (array)$spec->close_status);
        }

        if ($spec->project_volume_min) {
            $builder->where('project_volume', '>=', $spec->project_volume_min);
        }
        if ($spec->project_volume_max) {
            $builder->where('project_volume', '<=', $spec->project_volume_max);
        }
        if ($spec->keyword) {
            $builder->where('project_name', 'like', '%' . $spec->keyword . '%');
        }

        if ($spec->column && $spec->sort) {
            $builder->orderBy($spec->column, $spec->sort);
        } else {
            $builder->orderBy('created_at', 'desc');
        }

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
     * @param SaleSpecification $spec
     * @param int               $limit
     * @return array|\Illuminate\Support\Collection
     */
    public function getSaleListByKeyword($spec, $limit = 20)
    {
        $collect = collect();
        $builder = SaleModel::query();

        if ($spec->company_id) {
            $builder->where('company_id', $spec->company_id);
        }
        if ($spec->user_ids) {
            $builder->whereIn('user_id', (array)$spec->user_ids);
        }
        if ($spec->user_id) {
            $builder->where('user_id', $spec->user_id);
        }
        if ($spec->select_user_id) {
            $builder->where('user_id', $spec->select_user_id);
        }
        if ($spec->close_status) {
            $builder->whereIn('close_status', (array)$spec->close_status);
        }
        $builder->where('project_name', 'like', '%' . $spec->keyword . '%');

        //条数限制
        if ($limit) {
            $builder->limit($limit);
        }

        $models = $builder->get();
        /** @var SaleModel $model */
        foreach ($models as $model) {
            $collect[] = $this->reconstituteFromModel($model);
        }
        return $collect;
    }


    /**
     * @param int|array $ids
     */
    public function delete($ids)
    {
        $builder = SaleModel::query();
        $builder->whereIn('id', (array)$ids);
        $models = $builder->get();
        foreach ($models as $model) {
            $model->delete();
        }
    }


    /**
     * @param string $project_name
     * @param string $address
     * @return mixed
     */
    public function getSaleByProjectNameAndAddress($company_id, $project_name, $address)
    {
        $builder = SaleModel::query();
        $builder->where('company_id', $company_id);
        $builder->where('project_name', $project_name);
        $builder->where('address', $address);
        $model = $builder->first();
        if (!isset($model)) {
            return null;
        }
        return $this->reconstituteFromModel($model);
    }


}