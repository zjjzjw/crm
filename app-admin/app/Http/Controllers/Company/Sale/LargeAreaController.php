<?php namespace Huifang\Admin\Http\Controllers\Company\Sale;


use Huifang\Service\Sale\LargeArea\LargeAreaService;
use Huifang\Admin\Src\Forms\Sale\LargeArea\LargeAreaSearchForm;
use Huifang\Src\Sale\LargeArea\Domain\Model\LargeAreaSpecification;
use Huifang\Src\Sale\LargeArea\Infra\Repository\LargeAreaRepository;
use Huifang\Admin\Http\Controllers\BaseController;
use Illuminate\Http\Request;

class LargeAreaController extends BaseController
{
     public function index(Request $request, LargeAreaSearchForm $form)
     {
         $this->title = '大区管理';
         $this->file_css = 'pages.company.sale.large-area.index';
         $this->file_js = 'pages.company.sale.large-area.index';
         $data = [];
         //公共部分
         $user = $this->getUser();
         $company_id = $user->company->id;
         $request->merge(['company_id' => $company_id]);
         $form->validate($request->all());
         //公共部分结束



         $largeArea_service =new LargeAreaService();//需要先建立service
         $data = $largeArea_service->getLargeAreaList($form->largeArea_specification, 20);
         $appends = $this->getPageAppends($form->largeArea_specification);
         $data['appends'] = $appends;
         $data['company_id'] = $company_id;
         $view = $this->view('pages.company.sale.large-area.index', $data);
         return $view;
     }

     public function edit($id)
     {
         $this->title = '大区管理';
         $this->file_css = 'pages.company.sale.large-area.edit';
         $this->file_js = 'pages.company.sale.large-area.edit';
         $data = [];
         if (!empty($id)) {
             $largeArea_service = new LargeAreaService();
             $data = $largeArea_service->getLargeAreaInfo($id);
         }
         $view = $this->view('pages.company.sale.large-area.edit', $data);
         return $view;
     }
    public function getPageAppends(LargeAreaSpecification $spec)
    {
        $appends = [];
        if ($spec->keyword) {
            $appends['keyword'] = $spec->keyword;
        }
        return $appends;
    }

}