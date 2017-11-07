<?php namespace Huifang\Src\Contract\Domain\Interfaces;


use Carbon\Carbon;
use Huifang\Src\Contract\Domain\Model\ContractSpecification;
use Huifang\Src\Customer\Domain\Model\CustomerSpecification;
use Huifang\Src\Foundation\Domain\Interfaces\Repository;

interface ContractPaymentInterface extends Repository
{
    /**
     * @param int|array $ids
     */
    public function delete($ids);


    /**
     * @param int $contract_id
     * @return array|\Illuminate\Support\Collection
     */
    public function getPaymentsByContractId($contract_id);

    /**
     * @param int $contract_id
     * @param int $period
     * @param int $payment_type
     * @return array|\Illuminate\Support\Collection
     */
    public function getPaymentByPeriodAndType($contract_id, $period, $payment_type);

    /**
     * 计算回款计划的状态
     * @param int $contract_id
     * @param int $period 阶段
     */
    public function calculatorPaymentStatus($contract_id, $period);

    /**
     * @param int       $company_id
     * @param int|array $user_id
     * @param Carbon    $start_time
     * @param Carbon    $end_time
     */
    public function getPaymentByDate($company_id, $user_id, $start_time, $end_time);

}