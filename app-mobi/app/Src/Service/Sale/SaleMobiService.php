<?php namespace Huifang\Mobi\Src\Service\Sale;


use Huifang\Service\Company\DepartService;
use Huifang\Service\Role\TokenService;
use Huifang\Src\Project\Domain\Model\ProjectStepType;
use Huifang\Src\Role\Domain\Model\DataType;
use Huifang\Src\Role\Domain\Model\UserDataEntity;
use Huifang\Src\Role\Infra\Repository\UserDataRepository;
use Huifang\Src\Role\Infra\Repository\UserRepository;
use Huifang\Src\Sale\Domain\Model\SaleCloseStatus;
use Huifang\Src\Sale\Domain\Model\SaleEntity;
use Huifang\Src\Sale\Domain\Model\SaleSpecification;
use Huifang\Src\Sale\Domain\Model\SaleStatus;
use Huifang\Src\Sale\Infra\Repository\SaleRepository;
use Huifang\Src\Surport\Infra\Repository\CityRepository;
use Huifang\Src\Surport\Infra\Repository\ProvinceRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Carbon\Carbon;

class SaleMobiService
{
    /**
     * @param SaleSpecification $spec
     * @param int               $per_page
     * @return array
     */
    public function getMobiSaleList(SaleSpecification $spec, $per_page)
    {
        $data = [];
        $sale_repository = new SaleRepository();
        $paginate = $sale_repository->search($spec, $per_page);

        $items = [];
        /**
         * @var int                  $key
         * @var SaleEntity           $sale_entity
         * @var LengthAwarePaginator $paginate
         */
        foreach ($paginate as $key => $sale_entity) {
            $item = [];
            $item['id'] = $sale_entity->id;
            $item['text'] = $sale_entity->project_name;
            $item['time'] = Carbon::parse($sale_entity->created_at)->format('m-d H:i');
            $items[] = $item;
        }

        $data['items'] = $items;
        $data['pager']['total'] = $paginate->total();
        $data['pager']['last_page'] = $paginate->lastPage();
        $data['pager']['current_page'] = $paginate->currentPage();

        return $data;
    }


    /**
     * @param SaleSpecification $spec
     * @param int               $limit
     * @return array
     */
    public function getMobiSaleListByKeyword(SaleSpecification $spec, $limit = 20)
    {
        $items = [];
        $sale_repository = new SaleRepository();
        $sale_entities = $sale_repository->getSaleListByKeyword($spec, $limit);

        foreach ($sale_entities as $sale_entity) {
            $item = [];
            $item['id'] = $sale_entity->id;
            $item['name'] = $sale_entity->project_name;
            $item['time'] = Carbon::parse($sale_entity->created_at)->format('m-d H:i');
            $items[] = $item;
        }
        return $items;
    }


    public function getMobiSaleInfo($id)
    {
        $sale_repository = new SaleRepository();
        /** @var SaleEntity $sale_entity */
        $sale_entity = $sale_repository->fetch($id);
        $data = $sale_entity->toArray();
        $city_repository = new CityRepository();
        $city_entity = $city_repository->fetch($sale_entity->city_id);

        if ($city_entity) {
            $data['city'] = $city_entity->toArray();
        }
        $province_repository = new ProvinceRepository();
        $province_repository->fetch($sale_entity->province_id);
        $province_entity = $province_repository->fetch($sale_entity->province_id);
        if ($province_entity) {
            $data['province'] = $province_entity->toArray();
        }

        $data['sale_user'] = [];
        //得到销售线索的负责人信息
        if ($sale_entity->user_id) {
            $user_repository = new UserRepository();
            $user_entity = $user_repository->fetch($sale_entity->user_id);
            if ($user_entity) {
                $data['sale_user']['id'] = $user_entity->id;
                $data['sale_user']['name'] = $user_entity->name;
            }
        }
        //项目阶段类型
        $project_step_types = ProjectStepType::acceptableEnums();
        if (isset($project_step_types[$sale_entity->project_step_id])) {
            $data['project_step_type_name'] = $project_step_types[$sale_entity->project_step_id];
        }
        $sale_statuses = SaleStatus::acceptableEnums();
        $data['status_name'] = $sale_statuses[$sale_entity->status] ?? '';

        $close_statuses = SaleCloseStatus::acceptableEnums();
        $data['close_status_name'] = $close_statuses[$sale_entity->close_status] ?? '';

        return $data;
    }

    /**
     * 获取分配数据的权限
     * @return array
     */
    public function getSaleAssignUsers()
    {
        $data = [];
        $items = [];
        $user_id = TokenService::$user_id;
        $user_entity = TokenService::getUserEntity();
        $company_id = $user_entity->company_id;
        $user_data_repository = new UserDataRepository();
        $user_data_entities = $user_data_repository->getUserDataByUserIdAndDataType($user_id, DataType::TYPE_DEPART);
        $depart_service = new DepartService($company_id);
        if (!$user_data_entities->isEmpty()) {
            /** @var UserDataEntity $user_data_entity */
            //$user_data_entity = $user_data_entities->first();
            foreach ($user_data_entities as $user_data_entity){
                $items[] = $depart_service->getDepartsAndUsersById($user_data_entity->data_id);
            }
        }
        foreach ($items as $item) {
            foreach ($item as $value) {
                $data[$value['id']] = $value;
            }
        }

        $data = $depart_service->getTree($data);
        return $data;
    }

}
