<?php namespace Huifang\Src\Project\Domain\Interfaces;


use Huifang\Src\Foundation\Domain\Interfaces\Repository;
use Huifang\Src\Project\Domain\Model\ProjectFileEntity;
use Huifang\Src\Project\Domain\Model\ProjectSpecification;

interface ProjectAimInterface extends Repository
{
    /**
     * @param int $project_id
     * @return mixed
     */
    public function getProjectAimsByProjectId($project_id);

    /**
     * @param array|int $ids
     */
    public function delete($ids);

}