<?php namespace Huifang\Src\Contract\Infra\Repository;

use Carbon\Carbon;
use Huifang\Src\Contract\Domain\Interfaces\ContractInterface;
use Huifang\Src\Contract\Domain\Model\ContractEntity;
use Huifang\Src\Contract\Domain\Model\ContractSpecification;
use Huifang\Src\Contract\Infra\Eloquent\ContractModel;
use Huifang\Src\Contract\Infra\Eloquent\ContractProductModel;
use Huifang\Src\Foundation\Domain\Repository;


class ContractRepository extends Repository implements ContractInterface
{
    /**
     * Store an entity into persistence.
     *
     * @param ContractEntity $contract_entity
     */
    protected function store($contract_entity)
    {
        if ($contract_entity->isStored()) {
            $model = ContractModel::find($contract_entity->id);
        } else {
            $model = new ContractModel();
        }
        $model->fill(
            [
                'user_id'             => $contract_entity->user_id,
                'company_id'          => $contract_entity->company_id,
                'contract_number'     => $contract_entity->contract_number,
                'contract_name'       => $contract_entity->contract_name,
                'signed_at'           => $contract_entity->signed_at,
                'customer_id'         => $contract_entity->customer_id,
                'customer_name'       => $contract_entity->customer_name,
                'product_id'          => $contract_entity->product_id,
                'product_number'      => $contract_entity->product_number,
                'product_price'       => $contract_entity->product_price,
                'contract_amount'     => $contract_entity->contract_amount,
                'down_payment'        => $contract_entity->down_payment,
                'expected_return_at'  => $contract_entity->expected_return_at,
                'tail_amount'         => $contract_entity->tail_amount,
                'tail_amount_at'      => $contract_entity->tail_amount_at,
                'product_delivery_at' => $contract_entity->product_delivery_at,
                'created_user_id'     => $contract_entity->created_user_id,
            ]
        );
        $model->save();
        $this->saveContractProducts($model, $contract_entity);
        $contract_entity->setIdentity($model->id);
    }


    /**
     * @param ContractModel  $model
     * @param ContractEntity $contract_entity
     */
    public function saveContractProducts($model, $contract_entity)
    {
        if (isset($contract_entity->products)) {
            $contract_product_models = $model->contract_products;
            foreach ($contract_product_models as $contract_product_model) {
                $contract_product_model->delete();
            }

            foreach ($contract_entity->products as $product) {
                $contract_product_model = new ContractProductModel();
                $contract_product_model->contract_id = $model->id;
                $contract_product_model->product_id = $product['product_id'];
                $contract_product_model->product_number = $product['product_number'];
                $contract_product_model->product_price = $product['product_price'];

                $contract_product_model->save();
            }
        }
    }


    /**
     * @param ContractModel $model
     *
     * @return ContractEntity
     */
    private function reconstituteFromModel($model)
    {
        $entity = new ContractEntity();
        $entity->id = $model->id;

        $entity->user_id = $model->user_id;
        $entity->company_id = $model->company_id;
        $entity->contract_number = $model->contract_number;
        $entity->contract_name = $model->contract_name;
        $entity->signed_at = $model->signed_at;
        $entity->customer_id = $model->customer_id;
        $entity->customer_name = $model->customer_name;
        $entity->product_id = $model->product_id;
        $entity->product_number = $model->product_number;
        $entity->product_price = $model->product_price;
        $entity->contract_amount = $model->contract_amount;
        $entity->down_payment = $model->down_payment;
        $entity->expected_return_at = $model->expected_return_at;
        $entity->tail_amount = $model->tail_amount;
        $entity->tail_amount_at = $model->tail_amount_at;
        $entity->product_delivery_at = $model->product_delivery_at;
        $entity->created_user_id = $model->created_user_id;
        //合同里面的产品
        $entity->products = $model->contract_products->toArray();
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
     * @return ContractEntity
     */
    protected function reconstitute($id, $params = [])
    {
        $model = ContractModel::find($id);
        if (!isset($model)) {
            return null;
        }
        return $this->reconstituteFromModel($model);
    }


    /**
     * @param ContractSpecification $spec
     * @param int                   $per_page
     * @return mixed
     */
    public function search(ContractSpecification $spec, $per_page)
    {
        $builder = ContractModel::query();

        if ($spec->user_ids) {
            $builder->whereIn('user_id', (array)$spec->user_ids);
        }
        if ($spec->user_id) {
            $builder->where('user_id', $spec->user_id);
        }

        if ($spec->select_user_id) {
            $builder->where('user_id', $spec->select_user_id);
        }

        if ($spec->company_id) {
            $builder->where('company_id', $spec->company_id);
        }

        if ($spec->keyword) {
            $builder->where('contract_name', 'like', '%' . $spec->keyword . '%');
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
     * @param ContractSpecification $spec
     * @param int                   $limit
     */
    public function getContractListByKeyword(ContractSpecification $spec, $limit = 10)
    {
        $collect = collect();
        $builder = ContractModel::query();
        if ($spec->user_ids) {
            $builder->whereIn('user_id', (array)$spec->user_ids);
        }
        if ($spec->user_id) {
            $builder->where('user_id', $spec->user_id);
        }

        if ($spec->select_user_id) {
            $builder->where('user_id', $spec->select_user_id);
        }

        if ($spec->keyword) {
            $builder->where('contract_name', 'like', '%' . $spec->keyword . '%');
        }

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
        $builder = ContractModel::query();
        $builder->whereIn('id', (array)$ids);
        $models = $builder->get();
        foreach ($models as $model) {
            $model->delete();
        }
    }

    /**
     * @param int       $company_id
     * @param int|array $user_id
     * @param Carbon    $start_time
     * @param Carbon    $end_time
     * @return array|\Illuminate\Support\Collection
     */
    public function getContractsByDate($company_id, $user_id, $start_time, $end_time)
    {
        $collect = collect();
        $builder = ContractModel::query();
        if ($company_id) {
            $builder->where('company_id', $company_id);
        }
        if (!empty($user_id)) {
            $builder->whereIn('user_id', (array)$user_id);
        }
        if ($start_time) {
            $builder->where('signed_at', '>=', $start_time);
        }
        if ($end_time) {
            $builder->where('signed_at', '<=', $end_time);
        }
        $models = $builder->get();
        foreach ($models as $model) {
            $collect[] = $this->reconstituteFromModel($model);
        }
        return $collect;
    }


}