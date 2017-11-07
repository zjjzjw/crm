<?php

namespace Huifang\Service\Project;

use Carbon\Carbon;
use Huifang\Src\Project\Domain\Model\AnalyseType;
use Huifang\Src\Project\Domain\Model\ProjectAnalyseEntity;
use Huifang\Src\Project\Domain\Model\ProjectEntity;
use Huifang\Src\Project\Domain\Model\ProjectSpecification;
use Huifang\Src\Project\Domain\Model\SwotType;
use Huifang\Src\Project\Infra\Repository\ProjectAnalyseRepository;
use Huifang\Src\Project\Infra\Repository\ProjectFileRepository;
use Huifang\Src\Project\Infra\Repository\ProjectRepository;
use Huifang\Src\Role\Infra\Repository\UserRepository;
use Huifang\Src\Surport\Infra\Repository\CityRepository;
use Huifang\Src\Surport\Infra\Repository\ProvinceRepository;
use Illuminate\Pagination\LengthAwarePaginator;

class ProjectAnalyseService
{
    public function getProjectAnalyseByProjectIdAndType($project_id, $analyse_type)
    {
        $project_analyses = [];
        $project_analyse_repository = new ProjectAnalyseRepository();
        $project_analyse_entities = $project_analyse_repository->getProjectAnalyseByProjectIdAndType(
            $project_id, $analyse_type);
        /** @var ProjectAnalyseEntity $project_analyse_entity */
        foreach ($project_analyse_entities as $project_analyse_entity) {
            $project_analyses[] = $project_analyse_entity->toArray();
        }
        return $project_analyses;
    }

    public function getProjectAnalyseInfo($id)
    {
        $data = [];
        $project_analyse_repository = new ProjectAnalyseRepository();
        /** @var ProjectAnalyseEntity $project_analyse_entity */
        $project_analyse_entity = $project_analyse_repository->fetch($id);
        $swot_types = SwotType::acceptableEnums();
        $analyse_types = AnalyseType::acceptableEnums();
        if (isset($project_analyse_entity)) {
            $data = $project_analyse_entity->toArray();
            $data['swot_type_name'] = $swot_types[$project_analyse_entity->swot_type] ?? '';
            $data['analyse_type_name'] = $analyse_types[$project_analyse_entity->analyse_type] ?? '';
        }
        return $data;
    }


    public function getAnalyseTile($analyse_type)
    {
        $analyse_types = AnalyseType::acceptableEnums();
        $analyse_title_name = $analyse_types[$analyse_type] ?? '';
        return $analyse_title_name;
    }


    public function getProjectAnalyse($project_id)
    {
        $project_analyse_repository = new ProjectAnalyseRepository();
        $project_analyse_entities = $project_analyse_repository->getProjectAnalyseByProjectIdAndType($project_id, 0);

        $advantage_types = [SwotType::TYPE_ADVANTAGE_1, SwotType::TYPE_ADVANTAGE_2, SwotType::TYPE_ADVANTAGE_3];

        $advantage_relation = 0;//客户的关系
        $advantage_product = 0;//产品
        $advantage_price = 0;//价格
        $advantage_compete = 0;//服务
        $advantage_brand = 0;//品牌
        $advantage_other = 0;//其他

        $inferiority_relation = 0;//客户的关系
        $inferiority_product = 0;//产品
        $inferiority_price = 0;//价格
        $inferiority_compete = 0;//服务
        $inferiority_brand = 0;//品牌
        $inferiority_other = 0;//其他


        /** @var ProjectAnalyseEntity $project_analyse_entity */
        foreach ($project_analyse_entities as $project_analyse_entity) {
            if ($project_analyse_entity->analyse_type == AnalyseType::TYPE_RELATION) {
                if (in_array($project_analyse_entity->swot_type, $advantage_types)) {
                    $advantage_relation = $this->getScore($project_analyse_entity, $advantage_relation);
                } else {
                    $inferiority_relation = $this->getScore($project_analyse_entity, $inferiority_relation);
                }
            } else if ($project_analyse_entity->analyse_type == AnalyseType::TYPE_PRODUCT) {
                if (in_array($project_analyse_entity->swot_type, $advantage_types)) {
                    $advantage_product = $this->getScore($project_analyse_entity, $advantage_product);
                } else {
                    $inferiority_product = $this->getScore($project_analyse_entity, $inferiority_product);
                }
            } else if ($project_analyse_entity->analyse_type == AnalyseType::TYPE_PRICE) {
                if (in_array($project_analyse_entity->swot_type, $advantage_types)) {
                    $advantage_price = $this->getScore($project_analyse_entity, $advantage_price);
                } else {
                    $inferiority_price = $this->getScore($project_analyse_entity, $inferiority_price);
                }
            } else if ($project_analyse_entity->analyse_type == AnalyseType::TYPE_COMPETE) {
                if (in_array($project_analyse_entity->swot_type, $advantage_types)) {
                    $advantage_compete = $this->getScore($project_analyse_entity, $advantage_compete);
                } else {
                    $inferiority_compete = $this->getScore($project_analyse_entity, $inferiority_compete);
                }
            } else if ($project_analyse_entity->analyse_type == AnalyseType::TYPE_BRAND) {
                if (in_array($project_analyse_entity->swot_type, $advantage_types)) {
                    $advantage_brand = $this->getScore($project_analyse_entity, $advantage_brand);
                } else {
                    $inferiority_brand = $this->getScore($project_analyse_entity, $inferiority_brand);
                }
            } else if ($project_analyse_entity->analyse_type == AnalyseType::TYPE_OTHER) {
                if (in_array($project_analyse_entity->swot_type, $advantage_types)) {
                    $advantage_other = $this->getScore($project_analyse_entity, $advantage_other);
                } else {
                    $inferiority_other = $this->getScore($project_analyse_entity, $inferiority_other);
                }
            }
        }
        $data['labels'] = [
            '客户关系',
            '产品',
            '价格',
            '服务',
            '品牌',
            '其他'];
        $data['advantage'] = [$advantage_relation, $advantage_product, $advantage_price,
            $advantage_compete, $advantage_brand, $advantage_other];
        $data['inferiority'] = [$inferiority_relation, $inferiority_product, $inferiority_price,
            $inferiority_compete, $inferiority_brand, $inferiority_other];

        return $data;
    }

    /**
     * @param ProjectAnalyseEntity $project_analyse_entity
     * @param                      $score
     */
    public function getScore($project_analyse_entity, $score)
    {
        switch ($project_analyse_entity->swot_type) {
            case SwotType::TYPE_ADVANTAGE_1:
                $score += 10;
                break;
            case SwotType::TYPE_ADVANTAGE_2:
                $score += 20;
                break;
            case SwotType::TYPE_ADVANTAGE_3:
                $score += 30;
                break;
            case SwotType::TYPE_INFERIORITY_1:
                $score += 10;
                break;
            case SwotType::TYPE_INFERIORITY_2:
                $score += 20;
                break;
            case SwotType::TYPE_INFERIORITY_3:
                $score += 30;
                break;
        }
        return $score;
    }

}

