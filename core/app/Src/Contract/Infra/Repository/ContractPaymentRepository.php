<?php namespace Huifang\Src\Contract\Infra\Repository;

use Carbon\Carbon;
use Huifang\Src\Contract\Domain\Interfaces\ContractPaymentInterface;
use Huifang\Src\Contract\Domain\Model\ContractPaymentEntity;
use Huifang\Src\Contract\Domain\Model\ContractPaymentStatus;
use Huifang\Src\Contract\Domain\Model\ContractPaymentType;
use Huifang\Src\Contract\Infra\Eloquent\ContractPaymentModel;
use Huifang\Src\Foundation\Domain\Repository;


class ContractPaymentRepository extends Repository implements ContractPaymentInterface
{
    /**
     * Store an entity into persistence.
     *
     * @param ContractPaymentEntity $contract_payment_entity
     */
    protected function store($contract_payment_entity)
    {
        if ($contract_payment_entity->isStored()) {
            $model = ContractPaymentModel::find($contract_payment_entity->id);
        } else {
            $model = new ContractPaymentModel();
        }
        $model->fill(
            [
                'contract_id'    => $contract_payment_entity->contract_id,
                'period'         => $contract_payment_entity->period,
                'payment_amount' => $contract_payment_entity->payment_amount,
                'payment_type'   => $contract_payment_entity->payment_type,
                'payment_at'     => $contract_payment_entity->payment_at,
                'status'         => $contract_payment_entity->status,
                'note'           => $contract_payment_entity->note,
            ]
        );
        $model->save();
        $contract_payment_entity->setIdentity($model->id);
    }

    /**
     * @param ContractPaymentModel $model
     *
     * @return ContractPaymentEntity
     */
    private function reconstituteFromModel($model)
    {
        $entity = new ContractPaymentEntity();
        $entity->id = $model->id;
        $entity->contract_id = $model->contract_id;
        $entity->period = $model->period;
        $entity->payment_amount = $model->payment_amount;
        $entity->payment_type = $model->payment_type;
        $entity->payment_at = $model->payment_at;
        $entity->status = $model->status;
        $entity->note = $model->note;
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
     * @return ContractPaymentEntity
     */
    protected function reconstitute($id, $params = [])
    {
        $model = ContractPaymentModel::find($id);
        if (!isset($model)) {
            return null;
        }
        return $this->reconstituteFromModel($model);
    }


    /**
     * @param int|array $ids
     */
    public function delete($ids)
    {
        $builder = ContractPaymentModel::query();
        $builder->whereIn('id', (array)$ids);
        $models = $builder->get();
        foreach ($models as $model) {
            $model->delete();
        }
    }

    /**
     * @param int $contract_id
     * @return array|\Illuminate\Support\Collection
     */
    public function getPaymentsByContractId($contract_id)
    {
        $collect = collect();
        $builder = ContractPaymentModel::query();
        $builder->where('contract_id', $contract_id);
        $models = $builder->get();
        foreach ($models as $model) {
            $collect[] = $this->reconstituteFromModel($model);
        }
        return $collect;
    }


    /**
     * 计算回款计划的状态
     * @param int $contract_id
     * @param int $period
     */
    public function calculatorPaymentStatus($contract_id, $period)
    {
        $plan_amount = 0;
        $record_amount = 0;
        $builder = ContractPaymentModel::query();
        $builder->where('contract_id', $contract_id);
        $builder->where('period', $period);
        $models = $builder->get();
        if (!$models->isEmpty()) {
            $plan_models = $models->where('payment_type', ContractPaymentType::TYPE_PLAN);
            if (!$plan_models->isEmpty()) {
                $plan_amount = $plan_models->sum('payment_amount');
                $record_models = $models->where('payment_type', ContractPaymentType::TYPE_RECORD);
                if (!$record_models->isEmpty()) {
                    $record_amount = $record_models->sum('payment_amount');
                }
                if ($plan_amount != 0) {
                    if ($record_amount >= $plan_amount) {
                        foreach ($plan_models as $plan_model) {
                            $plan_model->status = ContractPaymentStatus::FINISH;
                            $plan_model->save();
                        }
                    } else {
                        foreach ($plan_models as $plan_model) {
                            $plan_model->status = ContractPaymentStatus::PROGRESS;
                            $plan_model->save();
                        }
                    }
                }
            }
        }
    }

    /**
     * @param int $contract_id
     * @param int $period
     * @param int $payment_type
     * @return array|\Illuminate\Support\Collection
     */
    public function getPaymentByPeriodAndType($contract_id, $period, $payment_type)
    {
        $collect = collect();
        $builder = ContractPaymentModel::query();
        if ($contract_id) {
            $builder->where('contract_id', $contract_id);
        }
        if ($period) {
            $builder->where('period', $period);
        }
        if ($payment_type) {
            $builder->where('payment_type', $payment_type);
        }
        $models = $builder->get();
        foreach ($models as $model) {
            $collect[] = $this->reconstituteFromModel($model);
        }
        return $collect;
    }

    /**
     * @param int       $company_id
     * @param int|array $user_id
     * @param Carbon    $start_time
     * @param Carbon    $end_time
     */
    public function getPaymentByDate($company_id, $user_id, $start_time, $end_time)
    {
        $collect = collect();
        $builder = ContractPaymentModel::query();
        $builder->leftJoin('contract', function ($join) {
            $join->on('contract.id', '=', 'contract_payment.contract_id');
        });
        if ($company_id) {
            $builder->where('contract.company_id', $company_id);
        }
        if (!empty($user_id)) {
            $builder->whereIn('contract.user_id', (array)$user_id);
        }
        if ($start_time) {
            $builder->where('contract_payment.payment_at', '>=', $start_time);
        }
        if ($end_time) {
            $builder->where('contract_payment.payment_at', '<=', $end_time);
        }
        $models = $builder->get();

        foreach ($models as $model) {
            $collect[] = $this->reconstituteFromModel($model);
        }
        return $collect;
    }

}