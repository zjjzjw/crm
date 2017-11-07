<?php namespace Huifang\Web\Http\Controllers\project;

use Huifang\Service\Product\ProductService;
use Huifang\Service\Project\ProjectAimService;
use Huifang\Service\Project\ProjectPurchaseService;
use Huifang\Src\Product\Domain\Model\AscriptionType;
use Huifang\Src\Product\Infra\Repository\ProductRepository;
use Huifang\Src\Project\Domain\Model\ProjectPurchaseEntity;
use Huifang\Src\Project\Infra\Repository\ProjectAimHinderRepository;
use Huifang\Web\Http\Controllers\BaseController;


class AimController extends BaseController
{
    public function aimMain($project_id)
    {
        $data = [];
        $this->file_css = 'project.aim.main';
        $this->file_js = 'project.aim.main';
        $this->title = '目标设置';
        $data['project_id'] = $project_id;
        return $this->view('touch.project.aim.main', $data);
    }

    //销售进度
    public function aimProgress($project_id)
    {
        $data = [];
        $this->file_css = 'project.aim.progress';
        $this->file_js = 'project.aim.progress';
        $this->title = '销售进度';
        $project_aim_service = new ProjectAimService();
        $project_purchases = $project_aim_service->getProjectAimProgress($project_id);
        //得到销售百分比
        $percent = $project_aim_service->getProjectPercentage($project_id);
        $data['percent'] = $percent;

        $data['project_purchases'] = $project_purchases;
        $data['project_id'] = $project_id;

        return $this->view('touch.project.aim.progress', $data);
    }


    public function aimList($project_id)
    {
        $data = [];
        $this->file_css = 'project.aim.list';
        $this->title = '目标列表';
        $data['project_id'] = $project_id;
        $project_aim_service = new ProjectAimService();
        $project_aims = $project_aim_service->getProjectAimsByProjectId($project_id);
        $data['project_aims'] = $project_aims;

        return $this->view('touch.project.aim.list', $data);
    }

    public function aimEdit($project_id, $id)
    {
        $data = [];
        $this->file_css = 'project.aim.edit';
        $this->file_js = 'project.aim.edit';
        $this->title = '目标编辑';

        $user = $this->getUser();

        if (!empty($id)) {
            $project_aim_service = new ProjectAimService();
            $data = $project_aim_service->getProjectAimInfo($id);
        }

        //下拉选择产品
        $product_service = new ProductService();
        $select_products = $product_service->getProductsByCompanyId($user->company->id, AscriptionType::TYPE_OWNER);
        $data['select_products'] = $select_products;

        $data['project_id'] = $project_id;
        $data['id'] = $id;

        return $this->view('touch.project.aim.edit', $data);
    }

    public function aimDetail($project_id, $id)
    {
        $data = [];
        $this->file_css = 'project.aim.detail';
        $this->file_js = 'project.aim.detail';
        $this->title = '目标详情';

        $project_aim_service = new ProjectAimService();
        $data = $project_aim_service->getProjectAimInfo($id);

        $data['project_id'] = $project_id;
        $data['id'] = $id;

        return $this->view('touch.project.aim.detail', $data);
    }

    //目标障碍
    public function hinderList($project_id, $aim_id)
    {
        $data = [];
        $this->file_css = 'project.aim.hinder.list';
        $this->file_js = 'project.aim.hinder.list';
        $this->title = '目标障碍输出';

        $project_aim_service = new ProjectAimService();
        $project_aim_hinders = $project_aim_service->getProjectAimHindersByProjectIdAndAimId(
            $project_id,
            $aim_id
        );

        $data['project_aim_hinders'] = $project_aim_hinders;

        $data['project_id'] = $project_id;
        $data['aim_id'] = $aim_id;

        return $this->view('touch.project.aim.hinder.list', $data);
    }

    public function hinderDetail($project_id, $aim_id, $id)
    {
        $data = [];
        $this->file_css = 'project.aim.hinder.detail';
        $this->file_js = 'project.aim.hinder.detail';
        $this->title = '目标障碍详情';
        $project_aim_service = new ProjectAimService();
        $data = $project_aim_service->getProjectAimHinderInfo($id);

        return $this->view('touch.project.aim.hinder.detail', $data);
    }


    public function hinderEdit($project_id, $aim_id, $id)
    {
        $data = [];
        $this->file_css = 'project.aim.hinder.edit';
        $this->file_js = 'project.aim.hinder.edit';
        $this->title = '目标障碍编辑';

        $project_aim_service = new ProjectAimService();
        if (!empty($id)) {
            $data = $project_aim_service->getProjectAimHinderInfo($id);
        }
        $project_purchase_service = new ProjectPurchaseService();
        $project_purchases = $project_purchase_service->getProjectPurchaseByProjectId($project_id);
        $data['project_purchases'] = $project_purchases;

        $data['project_id'] = $project_id;
        $data['aim_id'] = $aim_id;
        $data['id'] = $id;

        return $this->view('touch.project.aim.hinder.edit', $data);
    }

}