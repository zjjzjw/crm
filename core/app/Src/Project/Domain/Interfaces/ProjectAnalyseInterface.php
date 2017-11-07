<?php namespace Huifang\Src\Project\Domain\Interfaces;


use Huifang\Src\Foundation\Domain\Interfaces\Repository;
use Huifang\Src\Project\Domain\Model\ProjectFileEntity;
use Huifang\Src\Project\Domain\Model\ProjectSpecification;

interface ProjectAnalyseInterface extends Repository
{

    /**
     * @param int $project_id
     * @param int $analyse_type
     * @return array|\Illuminate\Support\Collection
     */
    public function getProjectAnalyseByProjectIdAndType($project_id, $analyse_type);

    /**
     * @param int|array $ids
     */
    public function delete($ids);


}