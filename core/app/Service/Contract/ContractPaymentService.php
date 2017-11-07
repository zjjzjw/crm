<?php

namespace Huifang\Service\Contract;

use Carbon\Carbon;
use Huifang\Src\Contract\Domain\Model\ContractEntity;
use Huifang\Src\Contract\Domain\Model\ContractPaymentEntity;
use Huifang\Src\Contract\Domain\Model\ContractPaymentStatus;
use Huifang\Src\Contract\Domain\Model\ContractPaymentType;
use Huifang\Src\Contract\Domain\Model\ContractSpecification;
use Huifang\Src\Contract\Infra\Repository\ContractPaymentRepository;
use Huifang\Src\Contract\Infra\Repository\ContractRepository;
use Huifang\Src\Customer\Infra\Repository\CustomerRepository;
use Huifang\Src\Product\Infra\Repository\ProductRepository;
use Illuminate\Pagination\LengthAwarePaginator;

class ContractPaymentService
{
    public function getContractPaymentInfo($id)
    {
        $data = [];
        $contract_payment_repository = new ContractPaymentRepository();
        /** @var ContractPaymentEntity $contract_payment_entity */
        $contract_payment_entity = $contract_payment_repository->fetch($id);
        if (isset($contract_payment_entity)) {
            $data = $contract_payment_entity->toArray();
            $data['payment_at'] = $contract_payment_entity->payment_at->toDateString();
        }

        return $data;
    }


    public function getContractPaymentList($contract_id)
    {
        $lists = [];
        $periods = $this->getPeriodList();
        $payments = [];
        $contract_payment_repository = new ContractPaymentRepository();
        $payment_entities = $contract_payment_repository->getPaymentsByContractId($contract_id);
        /** @var ContractPaymentEntity $payment_entity */
        $contract_payment_types = ContractPaymentType::acceptableEnums();
        $contract_payment_statuses = ContractPaymentStatus::acceptableEnums();
        foreach ($payment_entities as $payment_entity) {
            $payment = $payment_entity->toArray();
            $payment['payment_at'] = $payment_entity->payment_at->format('Y-m-d');
            $payment['payment_type_name'] = $contract_payment_types[$payment_entity->payment_type] ?? '';
            $payment['status_name'] = $contract_payment_statuses[$payment_entity->status] ?? '';
            $payments[] = $payment;
        }
        foreach ($periods as $period) {
            $items = collect($payments)->where('period', $period['id']);
            if (!$items->isEmpty()) {
                $items = $items->sort(function ($a, $b) {
                    return $a['payment_at'] > $b['payment_at'];
                })->sort(function ($a, $b) {
                    return $a['payment_type'] > $b['payment_type'];
                });
                $period['items'] = $items->toArray();
                $lists[] = $period;
            }
        }
        return $lists;
    }


    public function getPeriodList()
    {
        return
            [
                ['id' => 1, 'name' => '第一期'],
                ['id' => 2, 'name' => '第二期'],
                ['id' => 3, 'name' => '第三期'],
                ['id' => 4, 'name' => '第四期'],
                ['id' => 5, 'name' => '第五期'],
                ['id' => 6, 'name' => '第六期'],
                ['id' => 7, 'name' => '第七期'],
                ['id' => 8, 'name' => '第八期'],
                ['id' => 9, 'name' => '第九期'],
                ['id' => 10, 'name' => '第十期'],
            ];
    }


    public function getHasPaymentAmount($contract_id)
    {
        $payments = [];
        $contract_payment_repository = new ContractPaymentRepository();
        $payment_entities = $contract_payment_repository->getPaymentsByContractId($contract_id);
        foreach ($payment_entities as $payment_entity) {
            $payment = $payment_entity->toArray();
            $payments[] = $payment;
        }
        $amount = 0;
        if (!empty($payments)) {
            $amount = collect($payments)->where('payment_type',
                ContractPaymentType::TYPE_RECORD)->sum(
                function ($payment) {
                    return $payment['payment_amount'];
                });
        }
        return $amount;
    }

    /**
     * 得到指定公司，指定用户，指定人员的回款总金额
     * @param int       $company_id
     * @param Carbon    $start_time
     * @param Carbon    $end_time
     * @param int|array $user_id
     */
    public function getHasPaymentAmountByDate($company_id, $user_id, $start_time, $end_time)
    {
        $payment_amount = 0;
        $contract_payment_repository = new ContractPaymentRepository();
        $payment_entities = $contract_payment_repository->getPaymentByDate($company_id, $user_id, $start_time, $end_time);
        $payment_amount = $payment_entities->filter(function ($item) {
            return $item->payment_type == ContractPaymentType::TYPE_RECORD;
        })->sum(function ($item) {
            return $item->payment_amount;
        });
        return $payment_amount;
    }

}

