<?php

namespace Huifang\Service\Customer;


use Carbon\Carbon;
use Huifang\Service\Surport\ProvinceService;
use Huifang\Src\Customer\Domain\Model\CustomerEntity;
use Huifang\Src\Customer\Domain\Model\CustomerLevelType;
use Huifang\Src\Customer\Domain\Model\CustomerSpecification;
use Huifang\Src\Customer\Infra\Repository\CustomerRepository;
use Huifang\Src\Product\Domain\Model\ProductEntity;
use Huifang\Src\Product\Infra\Repository\ProductRepository;
use Huifang\Src\Surport\Infra\Repository\CityRepository;
use Huifang\Src\Surport\Infra\Repository\ProvinceRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class CustomerService
{
    public function getCustomerInfo($id)
    {
        $data = [];
        $customer_repository = new CustomerRepository();
        /** @var CustomerEntity $customer_entity */
        $customer_entity = $customer_repository->fetch($id);
        if (isset($customer_entity)) {
            $data = $customer_entity->toArray();
            $data['per_signed_at'] = $customer_entity->per_signed_at->toDateString();

            $city_repository = new CityRepository();
            $city_entity = $city_repository->fetch($customer_entity->city_id);
            if ($city_entity) {
                $data['city'] = $city_entity->toArray();
            }
            $province_repository = new ProvinceRepository();
            $province_repository->fetch($customer_entity->province_id);
            $province_entity = $province_repository->fetch($customer_entity->province_id);
            if ($province_entity) {
                $data['province'] = $province_entity->toArray();
            }
            $customer_level_types = CustomerLevelType::acceptableEnums();
            $data['level_name'] = $customer_level_types[$customer_entity->level] ?? '';
        }
        return $data;
    }


    /**
     * @param CustomerSpecification $spec
     * @param int                   $per_page
     * @return array
     */
    public function getTouchCustomerList(CustomerSpecification $spec, $per_page = 10)
    {
        $data = [];
        $customer_repository = new CustomerRepository();
        $paginate = $customer_repository->search($spec, $per_page);

        $items = [];
        /**
         * @var int                  $key
         * @var CustomerEntity       $customer_entity
         * @var LengthAwarePaginator $paginate
         */
        foreach ($paginate as $key => $customer_entity) {
            $item = $customer_entity->toArray();
            $item['text'] = $customer_entity->customer_company_name;
            $item['time'] = Carbon::parse($customer_entity->created_at)->format('m-d H:i');
            $item['url'] = route('customer.detail', ['id' => $customer_entity->id]);
            $items[] = $item;
        }

        $data['items'] = $items;
        $data['pager']['total'] = $paginate->total();
        $data['pager']['last_page'] = $paginate->lastPage();
        $data['pager']['current_page'] = $paginate->currentPage();

        return $data;
    }


    /**
     * @param CustomerSpecification $pec
     * @param int                   $limit
     * @return array
     */
    public function getCustomerListByKeyword($spec, $limit = 20)
    {
        $items = [];
        $customer_repository = new CustomerRepository();
        $customer_entities = $customer_repository->getCustomerListByKeyword($spec, $limit);
        /** @var CustomerEntity $customer_entity */
        foreach ($customer_entities as $customer_entity) {
            $item = $customer_entity->toArray();
            $item['name'] = $customer_entity->customer_company_name;
            $item['time'] = Carbon::parse($customer_entity->created_at)->format('m-d H:i');
            $item['url'] = route('project.detail', ['id' => $customer_entity->id]);
            $items[] = $item;
        }
        return $items;
    }

    /**
     * @param int $user_id
     * @return array
     */
    public function getCustomersByUserId($user_id)
    {
        $items = [];
        $customer_repository = new CustomerRepository();
        $customer_entities = $customer_repository->getCustomersByUserId($user_id);
        /** @var CustomerEntity $customer_entity */
        foreach ($customer_entities as $customer_entity) {
            $item = $customer_entity->toArray();
            $items[] = $item;
        }
        return $items;
    }

}

