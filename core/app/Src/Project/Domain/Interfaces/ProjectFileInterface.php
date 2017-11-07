<?php namespace Huifang\Src\Project\Domain\Interfaces;


use Huifang\Src\Foundation\Domain\Interfaces\Repository;
use Huifang\Src\Project\Domain\Model\ProjectFileEntity;
use Huifang\Src\Project\Domain\Model\ProjectSpecification;

interface ProjectFileInterface extends Repository
{
    /**
     * @param $project_id
     * @return ProjectFileEntity
     */
    public function getProjectFileByProjectId($project_id);


    /**
     * @param int|array $ids
     */
    public function delete($ids);

}