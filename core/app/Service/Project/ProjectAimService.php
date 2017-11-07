<?php

namespace Huifang\Service\Project;

use Carbon\Carbon;
use Huifang\Src\Foundation\Domain\Service;
use Huifang\Src\Product\Domain\Model\ProductEntity;
use Huifang\Src\Product\Infra\Repository\ProductRepository;
use Huifang\Src\Project\Domain\Model\AimHinderStatus;
use Huifang\Src\Project\Domain\Model\AnalyseType;
use Huifang\Src\Project\Domain\Model\ProjectAimEntity;
use Huifang\Src\Project\Domain\Model\ProjectAimHinderEntity;
use Huifang\Src\Project\Domain\Model\ProjectAimHinderSpecification;
use Huifang\Src\Project\Domain\Model\ProjectAnalyseEntity;
use Huifang\Src\Project\Domain\Model\ProjectEntity;
use Huifang\Src\Project\Domain\Model\ProjectPurchaseEntity;
use Huifang\Src\Project\Domain\Model\ProjectSpecification;
use Huifang\Src\Project\Domain\Model\SwotType;
use Huifang\Src\Project\Infra\Repository\ProjectAimHinderRepository;
use Huifang\Src\Project\Infra\Repository\ProjectAimRepository;
use Huifang\Src\Project\Infra\Repository\ProjectAnalyseRepository;
use Huifang\Src\Project\Infra\Repository\ProjectFileRepository;
use Huifang\Src\Project\Infra\Repository\ProjectPurchaseRepository;
use Huifang\Src\Project\Infra\Repository\ProjectRepository;
use Huifang\Src\Role\Infra\Repository\UserRepository;
use Huifang\Src\Surport\Infra\Repository\CityRepository;
use Huifang\Src\Surport\Infra\Repository\ProvinceRepository;
use Huifang\Web\Src\Forms\Project\Aim\AimHinderSearchForm;
use Illuminate\Pagination\LengthAwarePaginator;

class ProjectAimService
{
    /**
     * 得到目标列表
     * @param int $project_id
     * @return array
     */
    public function getProjectAimsByProjectId($project_id)
    {
        $project_aims = [];
        $project_aim_repository = new ProjectAimRepository();
        $project_aim_entities = $project_aim_repository->getProjectAimsByProjectId($project_id);
        /** @var ProjectAimEntity $project_aim_entity */
        foreach ($project_aim_entities as $project_aim_entity) {
            $item = $project_aim_entity->toArray();
            $project_aims[] = $item;
        }
        return $project_aims;
    }

    /**
     * 得到目标详情
     * @param int $id
     * @return array
     */
    public function getProjectAimInfo($id)
    {
        $data = [];
        $project_aim_repository = new ProjectAimRepository();
        /** @var ProjectAimEntity $project_aim_entity */
        $project_aim_entity = $project_aim_repository->fetch($id);

        if (isset($project_aim_entity)) {
            $data = $project_aim_entity->toArray();
            if (!empty($project_aim_entity->products)) {
                //得到产品信息
                $product_repository = new ProductRepository();
                $product_ids = [];
                foreach ($project_aim_entity->products as $product) {
                    $product_ids[] = $product['product_id'];
                }
                $product_items = [];
                $product_entities = $product_repository->getProductsByIds($product_ids);

                foreach ($product_entities as $product_entity) {
                    $product_items[$product_entity->id] = $product_entity->toArray();
                }
                $project_aim_products = [];
                foreach ($project_aim_entity->products as $project_aim_product) {
                    $project_aim_product['name'] = $product_items[$project_aim_product['product_id']]['name'] ?? '';
                    $project_aim_products[] = $project_aim_product;
                }
                $data['project_aim_products'] = $project_aim_products;
            }
        }

        return $data;
    }

    /**
     * 通过项目ID和目标ID得到目标障碍输出
     * @param int $project_id
     * @param int $aim_id
     * @return array
     */
    public function getProjectAimHindersByProjectIdAndAimId($project_id, $aim_id)
    {
        $project_aim_hinders = [];
        $project_aim_hinder_repository = new ProjectAimHinderRepository();
        $project_aim_hinder_entities = $project_aim_hinder_repository->getProjectAimHindersByProjectIdAndAimId(
            $project_id, $aim_id);
        /** @var ProjectAimHinderEntity $project_aim_hinder_entity */
        $project_purchase_repository = new ProjectPurchaseRepository();
        foreach ($project_aim_hinder_entities as $project_aim_hinder_entity) {
            $item = $project_aim_hinder_entity->toArray();
            if (!empty($item['project_purchase_id'])) {
                $project_purchase_entity = $project_purchase_repository->fetch($item['project_purchase_id']);
                if (isset($project_purchase_entity)) {
                    $item['project_purchase'] = $project_purchase_entity->toArray();
                }
            }
            $project_aim_hinders[] = $item;
        }
        return $project_aim_hinders;
    }

    /**
     * 目标障碍详情
     * @param int $id
     * @return array
     */
    public function getProjectAimHinderInfo($id)
    {
        $data = [];
        $project_aim_hinder_repository = new ProjectAimHinderRepository();
        $project_purchase_repository = new ProjectPurchaseRepository();
        /** @var ProjectAimHinderEntity $project_aim_hinder_entity */
        $project_aim_hinder_entity = $project_aim_hinder_repository->fetch($id);

        $aim_hinder_statuses = AimHinderStatus::acceptableEnums();

        if (isset($project_aim_hinder_entity)) {
            $data = $project_aim_hinder_entity->toArray();
            $data['executed_at'] = Carbon::parse($project_aim_hinder_entity->executed_at)->format('Y-m-d');
            if (!empty($project_aim_hinder_entity->project_purchase_id)) {
                $project_purchase_entity = $project_purchase_repository->fetch($project_aim_hinder_entity->project_purchase_id);
                if (isset($project_purchase_entity)) {
                    $data['project_purchase'] = $project_purchase_entity->toArray();
                }
            }
            $data['status_name'] = $aim_hinder_statuses[$project_aim_hinder_entity->status] ?? '';
        }
        return $data;
    }

    /**
     * 销售进度数据
     * @param int $project_id
     * @return array
     */
    public function getProjectAimProgress($project_id)
    {
        $project_purchases = [];
        $project_purchase_repository = new ProjectPurchaseRepository();
        $project_purchase_entities = $project_purchase_repository->getProjectPurchaseByProjectId(
            $project_id, 'timed_at', 'asc');

        $project_aim_hinder_repository = new ProjectAimHinderRepository();
        /** @var ProjectPurchaseEntity $project_purchase_entity */
        foreach ($project_purchase_entities as $project_purchase_entity) {
            $item = $project_purchase_entity->toArray();
            $item['timed_at'] = Carbon::parse($project_purchase_entity->timed_at)->format('Y-m-d');
            $project_aim_hider_entities = $project_aim_hinder_repository->getProjectAimHindersByProjectPurchaseId(
                $project_purchase_entity->id
            );
            /** @var ProjectAimHinderEntity $project_aim_hider_entity */
            foreach ($project_aim_hider_entities as $project_aim_hider_entity) {
                $aim_hinder = $project_aim_hider_entity->toArray();
                $aim_hinder['executed_at'] = Carbon::parse($project_aim_hider_entity->executed_at)
                    ->format('Y-m-d');
                $item['aim_hinders'][] = $aim_hinder;
            }
            $project_purchases[] = $item;
        }
        return $project_purchases;
    }

    /**
     * 得到销售进度百分比
     * @param int $project_id
     */
    public function getProjectPercentage($project_id)
    {
        $percent = 0;
        $project_aim_hinder_repository = new ProjectAimHinderRepository();
        $project_aim_hider_entities = $project_aim_hinder_repository->getProjectAimHindersByProjectIdAndAimId(
            $project_id, 0
        );
        $total = $project_aim_hider_entities->count();
        $num = 0;
        /** @var ProjectAimHinderEntity $project_aim_hider_entity */
        foreach ($project_aim_hider_entities as $project_aim_hider_entity) {
            if ($project_aim_hider_entity->status == AimHinderStatus::STATUS_PASS) {
                $num++;
            }
        }
        if ($total > 0) {
            $percent = intval(($num / $total) * 100);
        }
        return $percent;
    }


    /**
     * 得到待审核的目标障碍
     * @param AimHinderSearchForm $form
     * @return array
     */
    public function getApprovalAimHinders(AimHinderSearchForm $form, $per_page = 10)
    {
        $project_aim_hinders = [];
        $project_ids = [];
        $project_repository = new ProjectRepository();
        if ($form->aim_hinder_specification->select_user_id) {
            $project_entities = $project_repository->getProjectsByUserId($form->aim_hinder_specification->select_user_id);
        } else {
            $project_entities = $project_repository->getProjectsByUserId($form->aim_hinder_specification->user_ids);
        }


        foreach ($project_entities as $project_entity) {
            $project_ids[] = $project_entity->id;
        }
        $form->aim_hinder_specification->project_ids = $project_ids;


        $project_aim_hinder_repository = new ProjectAimHinderRepository();
        $paginate = $project_aim_hinder_repository->search($form->aim_hinder_specification, $per_page);


        $items = [];
        /**
         * @var int                    $key
         * @var ProjectAimHinderEntity $project_aim_hinder_entity
         * @var LengthAwarePaginator   $paginate
         */
        foreach ($paginate as $key => $project_aim_hinder_entity) {
            $item = $project_aim_hinder_entity->toArray();
            $item['text'] = $project_aim_hinder_entity->hinder_name;
            $item['time'] = Carbon::parse($project_aim_hinder_entity->created_at)->format('m-d H:i');
            $item['url'] = route('user.approval.hinder.detail', ['id' => $project_aim_hinder_entity->id]);
            $items[] = $item;
        }

        $data['items'] = $items;
        $data['pager']['total'] = $paginate->total();
        $data['pager']['last_page'] = $paginate->lastPage();
        $data['pager']['current_page'] = $paginate->currentPage();

        return $data;
    }


}

