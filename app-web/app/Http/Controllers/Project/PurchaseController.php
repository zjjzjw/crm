<?php namespace Huifang\Web\Http\Controllers\project;

use Huifang\Service\Project\ProjectPurchaseService;
use Huifang\Src\Project\Infra\Repository\ProjectPurchaseRepository;
use Huifang\Web\Http\Controllers\BaseController;


class PurchaseController extends BaseController
{
    public function flowEdit($project_id, $id)
    {
        $data = [];
        $this->file_css = 'project.purchase.edit';
        $this->file_js = 'project.purchase.edit';
        $this->title = '采购流程';

        $project_purchase_service = new ProjectPurchaseService();
        $data = $project_purchase_service->getPurchaseInfo($id);

        $data['project_id'] = $project_id;
        $data['id'] = $id;

        return $this->view('touch.project.purchase.edit', $data);
    }

    public function flowDetail($project_id, $id)
    {
        $this->file_css = 'project.purchase.detail';
        $this->file_js = 'project.purchase.detail';
        $this->title = '采购流程';

        $project_purchase_service = new ProjectPurchaseService();
        $data = $project_purchase_service->getPurchaseInfo($id);

        $data['project_id'] = $project_id;
        $data['id'] = $id;

        return $this->view('touch.project.purchase.detail', $data);
    }

    public function flowList($project_id)
    {
        $data = [];
        $this->file_css = 'project.purchase.list';
        $this->file_js = 'project.purchase.list';
        $this->title = '采购流程';
        $data['project_id'] = $project_id;
        $project_purchase_service = new ProjectPurchaseService();
        $project_purchases = $project_purchase_service->getProjectPurchaseByProjectId($project_id);
        $data['project_purchases'] = $project_purchase_service->formatPurchaseForList($project_purchases);

        return $this->view('touch.project.purchase.list', $data);
    }

}