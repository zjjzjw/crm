<?php namespace Huifang\Web\Http\Controllers;


use Carbon\Carbon;
use Huifang\Service\Contract\ContractService;
use Huifang\Service\Project\ProjectService;
use Huifang\Web\Src\Forms\Contract\ContractSearchForm;

class HomeController extends BaseController
{

    public function home()
    {
        $data = [];

        $this->file_css = 'home.index';
        $this->file_js = 'home.index';
        $this->title = '首页';
        $user = $this->getUser();

        //合同信息
        $contract_service = new ContractService();
        $start_time = Carbon::now()->startOfMonth();
        $end_time = Carbon::now()->endOfMonth();
        $contract_data = $contract_service->getManagerContractPaymentSchedule($user, $start_time, $end_time);
        $data['contract_data'] = $contract_data;
        //项目信息

        $month = Carbon::now()->format('Ym');
        $contract_sign_data = $contract_service->getManagerProgressByUserIdAndMonth($user->id, $month);
        $data['contract_sign_data'] = $contract_sign_data;

        $project_service = new ProjectService();

        $project_list = $project_service->getManagerProjectTaskManifestByDate($user,
            Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth());

        $data['project_list'] = $project_list;
        $view = $this->view('home.index', $data);
        return $view;
    }

}
