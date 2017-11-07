<?php

namespace Huifang\Service\Contract;

use Carbon\Carbon;
use Huifang\Admin\Http\Requests\Request;
use Huifang\Src\Contract\Domain\Model\ContractEntity;
use Huifang\Src\Contract\Domain\Model\ContractSpecification;
use Huifang\Src\Contract\Domain\Model\SignTaskEntity;
use Huifang\Src\Contract\Infra\Repository\ContractRepository;
use Huifang\Src\Contract\Infra\Repository\SignTaskRepository;
use Huifang\Src\Customer\Infra\Repository\CustomerRepository;
use Huifang\Src\Product\Infra\Repository\ProductRepository;
use Huifang\Src\Surport\Infra\Repository\ResourceRepository;
use Huifang\Web\User;
use Illuminate\Cache\Repository;
use Illuminate\Pagination\LengthAwarePaginator;

class SignTaskService
{
    /**
     * @param int $user_id
     * @return array
     */
    public function getSignTasksByUserId($user_id)
    {
        $items = [];
        $sign_task_repository = new SignTaskRepository();
        $sign_task_entities = $sign_task_repository->getSignTasksByUserId($user_id);
        /** @var SignTaskEntity $sign_task_entity */
        foreach ($sign_task_entities as $sign_task_entity) {
            $item = $sign_task_entity->toArray();
            $item['format_month'] = format_ym($sign_task_entity->month);
            $items[] = $item;
        }
        return $items;
    }


    public function getMonthList()
    {
        $months = [];
        $start_month = Carbon::now()->subYear(1);
        $end_month = Carbon::now()->addYear(1);
        for ($month = $start_month; $month < $end_month; $month->addMonth()) {
            $months[$month->format('Ym')] = $month->format('Y年m月');
        }
        return $months;
    }


    public function getSignTaskInfo($id)
    {
        $data = [];
        $sign_task_repository = new SignTaskRepository();
        /** @var SignTaskEntity $sign_task_entity */
        $sign_task_entity = $sign_task_repository->fetch($id);
        if (isset($sign_task_entity)) {
            $data = $sign_task_entity->toArray();
        }
        return $data;
    }

    /**
     * @param $user_id
     * @return array
     */
    public function getTaskSignMonths($user_id)
    {
        $months = [];
        $sign_task_repository = new SignTaskRepository();
        $sign_task_entities = $sign_task_repository->getSignTasksByUserId($user_id);
        /** @var SignTaskEntity $sign_task_entity */
        foreach ($sign_task_entities as $sign_task_entity) {
            $key = $sign_task_entity->month;
            $value = format_ym($sign_task_entity->month);
            $months[$key] = $value;
        }
        return $months;
    }

    /**
     * @param int|array $user_id
     * @param int       $month
     * @return mixed
     */
    public function getSignTaskAmountByUserIdsAndMonth($user_id, $month)
    {
        $sign_amount = 0;
        $sign_task_repository = new SignTaskRepository();
        $sign_task_entities = $sign_task_repository->getSignTasksByUserIdAndMonth($user_id, $month);
        if (!$sign_task_entities->isEmpty()) {
            $sign_amount = $sign_task_entities->sum(function ($item) {
                return $item->amount;
            });
        }
        return $sign_amount;
    }
}

