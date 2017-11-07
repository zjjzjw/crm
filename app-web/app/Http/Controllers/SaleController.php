<?php namespace Huifang\Web\Http\Controllers;

use Huifang\Service\Role\UserService;
use Huifang\Service\Sale\SaleService;
use Huifang\Src\Project\Domain\Model\ProjectStepType;
use Huifang\Src\Project\Domain\Model\ProjectVolumeType;
use Huifang\Src\Sale\Domain\Model\SaleCloseStatus;
use Huifang\Src\Sale\Domain\Model\SaleSpecification;
use Huifang\Service\Surport\ProvinceService;
use Huifang\Web\Src\Forms\Sale\SaleSearchForm;
use Illuminate\Http\Request;


class SaleController extends BaseController
{
    /**
     * @param Request        $request
     * @param SaleSearchForm $form
     * @return \View
     */
    public function saleList(Request $request, SaleSearchForm $form)
    {
        $this->file_css = 'sale.list';
        $this->file_js = 'sale.list';
        $this->title = '全部销售线索';
        $user = $this->getUser();

        $user_service = new UserService();
        $search_users = $user_service->getSearchUsers($user->company->id, $user->id);

        $user_ids = [];
        $user_ids[] = 0; //加入公客
        foreach ($search_users as $search_user) {
            $user_ids[] = $search_user['id'];
        }
        $user_ids[] = $user->id;
        $request->merge(['user_ids' => $user_ids]);

        $data = $this->getListData($request, $form);


        $data['search_users'] = $search_users;

        return $this->view('touch.sale.list', $data);
    }


    /**
     * @param Request        $request
     * @param SaleSearchForm $form
     * @return \View
     */
    public function saleIndividualList(Request $request, SaleSearchForm $form)
    {
        $this->file_css = 'sale.list';
        $this->file_js = 'sale.list';
        $this->title = '我的销售线索';
        $user = $this->getUser();
        $request->merge(['user_id' => $user->id]);

        $data = $this->getListData($request, $form);
        return $this->view('touch.sale.list', $data);
    }


    public function saleDetail(Request $request, $id)
    {
        $data = [];
        $user = $this->getUser();
        $this->file_css = 'sale.detail';
        $this->file_js = 'sale.detail';
        $this->title = '销售管理详情';
        $sale_service = new SaleService();
        $data = $sale_service->getSaleInfo($id);

        $user_service = new UserService();
        $assign_departs = $user_service->getAssignUsers($user->company->id, $user->id);
        $search_users = $user_service->getSearchUsers($user->company->id, $user->id);
        $search_user_ids = [];
        foreach ($search_users as $search_user) {
            $search_user_ids[] = $search_user['id'];
        }
        $search_user_ids[] = $user->id;

        $data['search_user_ids'] = $search_user_ids;
        $data['assign_departs'] = $assign_departs;

        return $this->view('touch.sale.detail', $data);
    }


    public function saleEdit(Request $request, $id)
    {
        $data = [];
        $this->file_css = 'sale.edit';
        $this->file_js = 'sale.edit';
        $this->title = '销售管理编辑';
        if (!empty($id)) {
            $sale_service = new SaleService();
            $data = $sale_service->getSaleInfo($id);
        }

        //阶段类型
        $project_step_types = ProjectStepType::acceptableEnums();
        $data['project_step_types'] = $project_step_types;

        $sale_close_statuses = SaleCloseStatus::acceptableEnums();
        $data['sale_close_statuses'] = $sale_close_statuses;

        //得到区域
        $province_service = new ProvinceService();
        $areas = $province_service->getProvinceForSale();
        $data['areas'] = $areas;

        return $this->view('touch.sale.edit', $data);
    }


    protected function getListData(Request $request, SaleSearchForm $form)
    {
        $data = [];
        $user = $this->getUser();

        $request->merge(['company_id' => $user->company->id]);

        $form->validate($request->all());

        $per_page = $request->get('per_page', 10);
        $sale_service = new SaleService();
        $data = $sale_service->getTouchSaleList($form->sale_specification, $per_page);

        $appends = $this->getPageAppends($form->sale_specification);
        //ajax 分页需要
        $appends['per_page'] = $per_page;
        $appends['page'] = $data['page']['current_page'] ?? 1;


        $data['appends'] = $appends;
        //城市
        $province_service = new ProvinceService();
        $provinces = $province_service->getProvinceForSale();
        $data['provinces'] = $provinces;

        //体量搜索
        $project_volume_types = ProjectVolumeType::acceptableEnums();
        $data['project_volume_types'] = $project_volume_types;

        //阶段
        $project_step_types = ProjectStepType::acceptableEnums();
        $data['project_step_types'] = $project_step_types;

        $sale_close_statuses = SaleCloseStatus::acceptableEnums();
        $data['sale_close_statuses'] = $sale_close_statuses;

        $data['route_name'] = $request->route()->getName();
        $choose = [
            'title'        => $this->title,
            'url'          => route('sale.edit', ['id' => 0]),
            'choose_items' => [
                [
                    'url'  => route('sale.list'),
                    'name' => '全部销售线索',
                ],
                [
                    'url'  => route('sale.individual.list'),
                    'name' => '我的销售线索',
                ],
            ],
        ];
        $data['choose'] = $choose;
        return $data;
    }


    /**
     * @param SaleSpecification $spec
     * @return array
     */
    protected function getPageAppends(SaleSpecification $spec)
    {
        $appends = [];
        if ($spec->project_volume_type) {
            $appends['project_volume_type'] = $spec->project_volume_type;
        }
        if ($spec->city_id) {
            $appends['city_id'] = $spec->city_id;
        }
        if ($spec->province_id) {
            $appends['province_id'] = $spec->province_id;
        }
        if ($spec->project_step_type) {
            $appends['project_step_type'] = $spec->project_step_type;
        }
        if ($spec->select_user_id) {
            $appends['select_user_id'] = $spec->select_user_id;
        }
        if ($spec->close_status) {
            $appends['close_status'] = $spec->close_status;
        }
        if ($spec->keyword) {
            $appends['keyword'] = $spec->keyword;
        }
        return $appends;
    }

}