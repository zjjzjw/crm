<?php

namespace Huifang\Service\Project;

use Carbon\Carbon;
use Huifang\Src\Project\Domain\Model\AnalyseType;
use Huifang\Src\Project\Domain\Model\ProjectAnalyseEntity;
use Huifang\Src\Project\Domain\Model\ProjectEntity;
use Huifang\Src\Project\Domain\Model\ProjectPurchaseEntity;
use Huifang\Src\Project\Domain\Model\ProjectSpecification;
use Huifang\Src\Project\Domain\Model\SwotType;
use Huifang\Src\Project\Infra\Repository\ProjectAnalyseRepository;
use Huifang\Src\Project\Infra\Repository\ProjectFileRepository;
use Huifang\Src\Project\Infra\Repository\ProjectPurchaseRepository;
use Huifang\Src\Project\Infra\Repository\ProjectRepository;
use Huifang\Src\Role\Infra\Repository\UserRepository;
use Huifang\Src\Surport\Infra\Repository\CityRepository;
use Huifang\Src\Surport\Infra\Repository\ProvinceRepository;
use Illuminate\Pagination\LengthAwarePaginator;

class ProjectPurchaseService
{

    /**
     * @param int $project_id
     * @return array
     */
    public function getProjectPurchaseByProjectId($project_id)
    {
        $project_purchases = [];
        $project_purchase_repository = new ProjectPurchaseRepository();
        $project_purchase_entities = $project_purchase_repository->getProjectPurchaseByProjectId($project_id);

        /** @var ProjectPurchaseEntity $project_purchase_entity */
        foreach ($project_purchase_entities as $project_purchase_entity) {
            $project_purchases[] = $project_purchase_entity->toArray();
        }
        return $project_purchases;

    }


    /**
     * @param array $project_purchases
     * @return mixed
     */
    public function formatPurchaseForList($project_purchases)
    {
        $data = [];
        foreach ($project_purchases as $project_purchase) {
            $key = Carbon::parse($project_purchase['timed_at'])->format('Y-m-d');
            $data[$key][] = $project_purchase;
        }
        //对数据按时间进行排序
        ksort($data);
        return $data;
    }

    /**
     * @param int $id
     * @return array
     */
    public function getPurchaseInfo($id)
    {
        $data = [];
        $project_purchase_repository = new ProjectPurchaseRepository();
        /** @var ProjectPurchaseEntity $project_purchase_entity */
        $project_purchase_entity = $project_purchase_repository->fetch($id);
        if (isset($project_purchase_entity)) {
            $data = $project_purchase_entity->toArray();
            $data['timed_at'] = Carbon::parse($project_purchase_entity->timed_at)->format('Y-m-d');
        }
        return $data;
    }

}

