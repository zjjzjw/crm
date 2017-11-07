<?php namespace Huifang\Src\Project\Domain\Interfaces;


use Huifang\Src\Foundation\Domain\Interfaces\Repository;
use Huifang\Src\Project\Domain\Model\ProjectSpecification;

interface ProjectStructureInterface extends Repository
{
    /**
     * @param int $project_id
     * @param int $type
     * @return array|\Illuminate\Support\Collection
     */
    public function getProjectStructureByProjectId($project_id, $type = 1);

    /**
     * @param int|array $ids
     */
    public function delete($ids);

    /**
     * @param int $parent_id
     * @return array|\Illuminate\Support\Collection
     */
    public function getProjectStructureByParentId($parent_id);

}