<?php

namespace Huifang\Service\Contract;

use Carbon\Carbon;
use Huifang\Service\Role\UserService;
use Huifang\Src\Card\Domain\Model\CardEntity;
use Huifang\Src\Contract\Domain\Model\ContractEntity;
use Huifang\Src\Contract\Domain\Model\ContractSpecification;
use Huifang\Src\Contract\Infra\Repository\ContractRepository;
use Huifang\Src\Customer\Infra\Repository\CustomerRepository;
use Huifang\Src\Product\Infra\Repository\ProductRepository;
use Huifang\Web\User;
use Illuminate\Pagination\LengthAwarePaginator;

class ContractService
{
    /**
     * @param ContractSpecification $spec
     * @param int                   $per_page
     * @return array
     */
    public function getTouchContractList(ContractSpecification $spec, $per_page)
    {
        $data = [];
        $project_repository = new ContractRepository();
        $paginate = $project_repository->search($spec, $per_page);
        $items = [];
        /**
         * @var int                  $key
         * @var ContractEntity       $contract_entity
         * @var LengthAwarePaginator $paginate
         */
        foreach ($paginate as $key => $contract_entity) {
            $item = $contract_entity->toArray();
            $item['text'] = $contract_entity->contract_name;
            $item['time'] = Carbon::parse($contract_entity->created_at)->format('m-d H:i');
            $item['url'] = route('contract.detail', ['id' => $contract_entity->id]);
            $items[] = $item;
        }

        $data['items'] = $items;
        $data['pager']['total'] = $paginate->total();
        $data['pager']['last_page'] = $paginate->lastPage();
        $data['pager']['current_page'] = $paginate->currentPage();

        return $data;
    }

    /**
     * @param ContractSpecification $spec
     * @param int                   $limit
     * @return array
     */
    public function getContractListByKeyword($spec, $limit = 20)
    {
        $items = [];
        $contract_repository = new ContractRepository();
        $contract_entities = $contract_repository->getContractListByKeyword($spec, $limit);
        /** @var ContractEntity $contract_entity */
        foreach ($contract_entities as $contract_entity) {
            $item = $contract_entity->toArray();
            $item['name'] = $contract_entity->contract_name;
            $item['time'] = Carbon::parse($contract_entity->created_at)->format('m-d H:i');
            $item['url'] = route('project.detail', ['id' => $contract_entity->id]);
            $items[] = $item;
        }
        return $items;
    }

    /**
     * @param int $id
     * @return  array
     */
    public function getContractInfo($id)
    {
        $data = [];
        $contract_repository = new ContractRepository();
        /** @var ContractEntity $contract_entity */
        $contract_entity = $contract_repository->fetch($id);

        if (isset($contract_entity)) {
            $data = $contract_entity->toArray();
            //得到产品信息
            $product_repository = new ProductRepository();
            $product_ids = [];
            foreach ($contract_entity->products as $product) {
                $product_ids[] = $product['product_id'];
            }
            $product_items = [];
            $product_entities = $product_repository->getProductsByIds($product_ids);
            foreach ($product_entities as $product_entity) {
                $product_items[$product_entity->id] = $product_entity->toArray();
            }

            $contract_products = [];
            foreach ($contract_entity->products as $contract_product) {
                $contract_product['name'] = $product_items[$contract_product['product_id']]['name'] ?? '';
                $contract_products[] = $contract_product;
            }
            $data['contract_products'] = $contract_products;

            $data['expected_return_at'] = $contract_entity->expected_return_at->format('Y-m-d');
            $data['tail_amount_at'] = $contract_entity->tail_amount_at->format('Y-m-d');
            $data['product_delivery_at'] = $contract_entity->product_delivery_at->format('Y-m-d');
            $data['signed_at'] = $contract_entity->signed_at->format('Y-m-d');
        }

        return $data;

    }


    /**
     * 得到指定公司，指定用户，指定时间内签约合同总金额
     * @param int           $company_id
     * @param int|array     $user_id
     * @param Carbon|string $start_time
     * @param Carbon|string $end_time
     * @return int|mixed
     */
    public function getContractTotalAmountByDate($company_id, $user_id, $start_time, $end_time)
    {
        $total_amount = 0;
        $contract_repository = new ContractRepository();
        $contract_entities = $contract_repository->getContractsByDate($company_id, $user_id, $start_time, $end_time);

        $total_amount = $contract_entities->sum(function ($item) {
            return $item->contract_amount;
        });
        return $total_amount;
    }

    /**
     * 得到个人的回款
     * @param User   $user
     * @param Carbon $start_time
     * @param Carbon $end_time
     * @return mixed
     */
    public function getContractPaymentScheduleByUser($user, $start_time, $end_time)
    {
        $total_amount = $this->getContractTotalAmountByDate($user->company_id, $user->id, $start_time, $end_time);
        $data['total_amount'] = intval($total_amount);

        $contract_payment_service = new ContractPaymentService();
        $payment_amount = $contract_payment_service->getHasPaymentAmountByDate($user->company_id, $user->id, $start_time, $end_time);
        $data['payment_amount'] = intval($payment_amount);

        $data['percent'] = 0;
        if ($total_amount > 0) {
            $data['percent'] = intval(($payment_amount / $total_amount) * 100);
            if ($data['percent'] > 100) {
                $data['percent'] = 100;
            }
        } else {
            $data['percent'] = 100;
        }
        return $data;
    }

    /**
     * @return array
     */
    public function getPaymentScheduleMonths()
    {
        $months = [];
        $start_month = Carbon::createFromFormat('Y-m-d', '2017-04-01');
        $end_month = Carbon::now();
        for ($month = $start_month; $month < $end_month; $month->addMonth()) {
            $months[$month->format('Ym')] = $month->format('Y月m日');
        }
        return $months;
    }

    /**
     * 得到数据权限回款总和
     * @param User   $user
     * @param Carbon $start_time
     * @param Carbon $end_time
     * @return mixed
     */
    public function getManagerContractPaymentSchedule($user, $start_time, $end_time)
    {
        $user_ids = [];
        $user_service = new UserService();
        $manager_users = $user_service->getSearchUsers($user->company_id, $user->id);

        foreach ($manager_users as $manager_user) {
            $user_ids[] = $manager_user['id'];
        }
        $user_ids[] = $user->id;

        $total_amount = $this->getContractTotalAmountByDate($user->company_id, $user_ids, $start_time, $end_time);
        $data['total_amount'] = intval($total_amount);

        $contract_payment_service = new ContractPaymentService();
        $payment_amount = $contract_payment_service->getHasPaymentAmountByDate($user->company_id, $user_ids, $start_time, $end_time);
        $data['payment_amount'] = intval($payment_amount);

        $data['percent'] = 0;
        if ($total_amount > 0) {
            $data['percent'] = intval(($payment_amount / $total_amount) * 100);
            if ($data['percent'] > 100) {
                $data['percent'] = 100;
            }
        } else {
            $data['percent'] = 100;
        }
        return $data;
    }

    /**
     * @param int $user_id
     * @param int $month
     * @return mixed
     */
    public function getSignProgressByUserIdAndMonth($user_id, $month)
    {
        $data = [];
        $user = \Huifang\Web\User::find($user_id);
        $start_time = Carbon::createFromFormat('Ym', $month)->startOfMonth();
        $end_time = Carbon::createFromFormat('Ym', $month)->endOfMonth();
        $contract_amount = $this->getContractTotalAmountByDate($user->company_id, $user->id, $start_time, $end_time);

        $data['contract_amount'] = intval($contract_amount);

        $sign_task_service = new SignTaskService();
        $sign_task_amount = $sign_task_service->getSignTaskAmountByUserIdsAndMonth($user_id, $month);

        $data['sign_task_amount'] = intval($sign_task_amount);

        $data['percent'] = 0;
        if ($sign_task_amount > 0) {
            $data['percent'] = intval(($contract_amount / $sign_task_amount) * 100);
            if ($data['percent'] > 100) {
                $data['percent'] = 100;
            }
        } else {
            $data['percent'] = 100;
        }
        return $data;
    }


    public function getManagerProgressByUserIdAndMonth($user_id, $month)
    {
        $user_ids = [];

        $start_time = Carbon::createFromFormat('Ym', $month)->startOfMonth();
        $end_time = Carbon::createFromFormat('Ym', $month)->endOfMonth();

        $user = \Huifang\Web\User::find($user_id);
        $user_service = new UserService();
        $manager_users = $user_service->getSearchUsers($user->company_id, $user->id);

        foreach ($manager_users as $manager_user) {
            $user_ids[] = $manager_user['id'];
        }
        $user_ids[] = $user_id;

        $contract_amount = $this->getContractTotalAmountByDate($user->company_id, $user_ids, $start_time, $end_time);

        $data['contract_amount'] = intval($contract_amount);

        $sign_task_service = new SignTaskService();
        $sign_task_amount = $sign_task_service->getSignTaskAmountByUserIdsAndMonth($user_ids, $month);

        $data['sign_task_amount'] = intval($sign_task_amount);

        $data['percent'] = 0;
        if ($sign_task_amount > 0) {
            $data['percent'] = intval(($contract_amount / $sign_task_amount) * 100);
            if ($data['percent'] > 100) {
                $data['percent'] = 100;
            }
        } else {
            $data['percent'] = 100;
        }
        return $data;
    }


}

