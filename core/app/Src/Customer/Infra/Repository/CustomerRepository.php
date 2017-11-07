<?php namespace Huifang\Src\Customer\Infra\Repository;

use Carbon\Carbon;
use Huifang\Src\Customer\Domain\Interfaces\CustomerInterface;
use Huifang\Src\Customer\Domain\Model\CustomerEntity;
use Huifang\Src\Customer\Domain\Model\CustomerSpecification;
use Huifang\Src\Customer\Infra\Eloquent\CustomerModel;
use Huifang\Src\Foundation\Domain\Repository;


class CustomerRepository extends Repository implements CustomerInterface
{
    /**
     * Store an entity into persistence.
     *
     * @param CustomerEntity $customer_entity
     */
    protected function store($customer_entity)
    {
        if ($customer_entity->isStored()) {
            $model = CustomerModel::find($customer_entity->id);
        } else {
            $model = new CustomerModel();
        }
        $model->fill(
            [
                'user_id'               => $customer_entity->user_id,
                'company_id'            => $customer_entity->company_id,
                'customer_company_name' => $customer_entity->customer_company_name,
                'province_id'           => $customer_entity->province_id,
                'city_id'               => $customer_entity->city_id,
                'contact_name'          => $customer_entity->contact_name,
                'position_name'         => $customer_entity->position_name,
                'contact_phone'         => $customer_entity->contact_phone,
                'project_count'         => $customer_entity->project_count,
                'build_project_count'   => $customer_entity->build_project_count,
                'future_potential'      => $customer_entity->future_potential,
                'record'                => $customer_entity->record,
                'use_brand'             => $customer_entity->use_brand,
                'volume'                => $customer_entity->volume,
                'level'                 => $customer_entity->level,
                'per_signed_at'         => $customer_entity->per_signed_at,
                'created_user_id'       => $customer_entity->created_user_id,
            ]
        );
        $model->save();
        $customer_entity->setIdentity($model->id);
    }

    /**
     * @param CustomerModel $model
     *
     * @return CustomerEntity
     */
    private function reconstituteFromModel($model)
    {
        $entity = new CustomerEntity();
        $entity->id = $model->id;

        $entity->user_id = $model->user_id;
        $entity->company_id = $model->company_id;
        $entity->customer_company_name = $model->customer_company_name;
        $entity->province_id = $model->province_id;
        $entity->city_id = $model->city_id;
        $entity->contact_name = $model->contact_name;
        $entity->position_name = $model->position_name;
        $entity->contact_phone = $model->contact_phone;
        $entity->project_count = $model->project_count;
        $entity->build_project_count = $model->build_project_count;
        $entity->record = $model->record;
        $entity->future_potential = $model->future_potential;
        $entity->use_brand = $model->use_brand;
        $entity->volume = $model->volume;
        $entity->level = $model->level;
        $entity->per_signed_at = $model->per_signed_at;
        $entity->created_user_id = $model->created_user_id;

        $entity->created_at = $model->created_at;
        $entity->updated_at = $model->updated_at;
        $entity->setIdentity($model->id);
        $entity->stored();

        return $entity;
    }


    /**
     * Reconstitute an entity from persistence.
     *
     * @param mixed $id
     * @param array $params Additional params.
     *
     * @return CustomerEntity
     */
    protected function reconstitute($id, $params = [])
    {
        $model = CustomerModel::find($id);
        if (!isset($model)) {
            return null;
        }
        return $this->reconstituteFromModel($model);
    }


    /**
     * @param CustomerSpecification $spec
     * @param int                   $per_page
     * @return mixed
     */
    public function search(CustomerSpecification $spec, $per_page)
    {
        $builder = CustomerModel::query();

        if ($spec->user_ids) {
            $builder->whereIn('user_id', (array)$spec->user_ids);
        }
        if ($spec->user_id) {
            $builder->where('user_id', $spec->user_id);
        }

        if ($spec->province_id) {
            $builder->where('province_id', $spec->province_id);
        }
        if ($spec->city_id) {
            $builder->where('city_id', $spec->city_id);
        }
        if ($spec->select_user_id) {
            $builder->where('user_id', $spec->select_user_id);
        }

        if ($spec->project_count_min) {
            $builder->where('project_count', '>=', $spec->project_count_min);
        }
        if ($spec->project_count_max) {
            $builder->where('project_count', '<', $spec->project_count_max);
        }

        if ($spec->build_project_count_min) {
            $builder->where('build_project_count', '>=', $spec->build_project_count_min);
        }
        if ($spec->build_project_count_max) {
            $builder->where('build_project_count', '<', $spec->build_project_count_max);
        }

        if ($spec->future_potential_min) {
            $builder->where('future_potential', '>=', $spec->future_potential_min);
        }
        if ($spec->future_potential_max) {
            $builder->where('future_potential', '<', $spec->future_potential_max);
        }

        if ($spec->keyword) {
            $builder->where('customer_company_name', 'like', '%' . $spec->keyword . '%');
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
     * 通过关键字得到客户
     * @param CustomerSpecification $spec
     * @param int                   $limit
     */
    public function getCustomerListByKeyword(CustomerSpecification $spec, $limit = 10)
    {
        $collect = collect();
        $builder = CustomerModel::query();
        if ($spec->user_ids) {
            $builder->whereIn('user_id', (array)$spec->user_ids);
        }
        if ($spec->user_id) {
            $builder->where('user_id', $spec->user_id);
        }
        if ($spec->province_id) {
            $builder->where('province_id', $spec->province_id);
        }
        if ($spec->city_id) {
            $builder->where('city_id', $spec->city_id);
        }
        if ($spec->select_user_id) {
            $builder->where('user_id', $spec->select_user_id);
        }
        if ($spec->level) {
            $builder->where('level', $spec->level);
        }

        if ($spec->keyword) {
            $builder->where('customer_company_name', 'like', '%' . $spec->keyword . '%');
        }

        $builder->limit($limit);

        $models = $builder->get();
        foreach ($models as $model) {
            $collect[] = $this->reconstituteFromModel($model);
        }

        return $collect;
    }

    /**
     * @param int $user_id
     * @return array|\Illuminate\Support\Collection
     */
    public function getCustomersByUserId($user_id)
    {
        $collect = collect();
        $builder = CustomerModel::query();
        $builder->where('user_id', $user_id);
        $models = $builder->get();
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
        $builder = CustomerModel::query();
        $builder->whereIn('id', (array)$ids);
        $models = $builder->get();
        foreach ($models as $model) {
            $model->delete();
        }
    }


}