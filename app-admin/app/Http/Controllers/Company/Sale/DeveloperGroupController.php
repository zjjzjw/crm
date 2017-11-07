<?php namespace Huifang\Admin\Http\Controllers\Company\Sale;

use Huifang\Admin\Http\Controllers\BaseController;
use Illuminate\Http\Request;
use Huifang\Service\Sale\DeveloperGroup\DeveloperGroupService;
use Huifang\Admin\Src\Forms\Sale\DeveloperGroup\DeveloperGroupSearchForm;
use Huifang\Src\Sale\DeveloperGroup\Domain\Model\DeveloperGroupSpecification;
use Huifang\Src\Sale\DeveloperGroup\Infra\Repository\DeveloperGroupRepository;


class DeveloperGroupController extends BaseController
{
    public function index(Request $request, DeveloperGroupSearchForm $form)
    {
        $this->title = '所属集团';
        $this->file_css = 'pages.company.sale.developer-group.index';
        $this->file_js = 'pages.company.sale.developer-group.index';
        $data = [];
        //公共部分
        $user = $this->getUser();
        $company_id = $user->company->id;
        $request->merge(['company_id' => $company_id]);
        $form->validate($request->all());
        //公共部分结束
        $developer_group_service = new DeveloperGroupService();//需要先建立service
        $data = $developer_group_service->getDeveloperGroupList($form->developer_group_specification, 20);
        $appends = $this->getPageAppends($form->developer_group_specification);
        $data['appends'] = $appends;
        $data['company_id'] = $company_id;
        $view = $this->view('pages.company.sale.developer-group.index', $data);
        return $view;
    }

    public function edit($id)
    {
        $this->title = '所属集团';
        $this->file_css = 'pages.company.sale.developer-group.edit';
        $this->file_js = 'pages.company.sale.developer-group.edit';
        $data = [];
        if (!empty($id)) {
            $developerGroup_service = new DeveloperGroupService();
            $data = $developerGroup_service->getDeveloperGroupInfo($id);
        }
        $view = $this->view('pages.company.sale.developer-group.edit', $data);
        return $view;
    }


    public function getPageAppends(DeveloperGroupSpecification $spec)
    {
        $appends = [];
        if ($spec->keyword) {
            $appends['keyword'] = $spec->keyword;
        }
        return $appends;
    }
}