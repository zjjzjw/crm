<?php namespace Huifang\Admin\Http\Controllers\Company;

use Huifang\Admin\Http\Controllers\BaseController;
use Huifang\Admin\Src\Forms\Company\Rival\RivalDeleteForm;
use Huifang\Admin\Src\Forms\Company\Rival\RivalSearchForm;
use Huifang\Admin\Src\Forms\Company\Rival\RivalStoreForm;
use Huifang\Service\Product\RivalService;
use Huifang\Src\Product\Domain\Model\RivalSpecification;
use Huifang\Src\Product\Infra\Repository\RivalRepository;
use Illuminate\Http\Request;

class RivalController extends BaseController
{
    public function index(Request $request, RivalSearchForm $form)
    {
        $this->title = '竞品公司';
        $this->file_css = 'pages.company.rival.index';
        $this->file_js = 'pages.company.rival.index';
        $data = [];

        $user = $this->getUser();
        $company_id = $user->company->id;
        $request->merge(['company_id' => $company_id]);
        $form->validate($request->all());


        $rival_service = new RivalService();
        $data = $rival_service->getRivalList($form->rival_specification, 20);

        $appends = $this->getPageAppends($form->rival_specification);
        $data['appends'] = $appends;

        $company_id = $user->company->id;
        $data['company_id'] = $company_id;

        return $this->view('pages.company.rival.index', $data);
    }

    public function edit(Request $request, $id)
    {
        $this->title = '竞品公司-编辑';
        $this->file_css = 'pages.company.rival.edit';
        $this->file_js = 'pages.company.rival.edit';
        $data = [];
        $user = $this->getUser();
        $company_id = $user->company->id;
        if (!empty($id)) {
            $rival_service = new RivalService();
            $data = $rival_service->getRivalInfo($id);
        }
        $data['company_id'] = $company_id;
        return $this->view('pages.company.rival.edit', $data);
    }

    public function store(Request $request, RivalStoreForm $form)
    {
        $form->validate($request->all());
        $rival_repository = new RivalRepository();
        $rival_repository->save($form->rival_entity);

        return redirect()->to(route('company.rival.index'));
    }

    /**
     * @param int             $id
     * @param Request         $request
     * @param RivalDeleteForm $form
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete($id, Request $request, RivalDeleteForm $form)
    {
        $request->merge(['id' => $id]);
        $form->validate($request->all());
        $rival_repository = new RivalRepository();
        $rival_repository->delete($id);
        return redirect()->to(route('company.rival.index'));
    }

    /**
     * @param RivalSpecification $spec
     * @return array
     */
    public function getPageAppends(RivalSpecification $spec)
    {
        $appends = [];
        if ($spec->keyword) {
            $appends['keyword'] = $spec->keyword;
        }
        return $appends;
    }

}