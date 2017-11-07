<?php namespace Huifang\Src\Project\Domain\Interfaces;


use Huifang\Src\Foundation\Domain\Interfaces\Repository;
use Huifang\Src\Project\Domain\Model\ProjectSpecification;

interface ProjectPurchaseInterface extends Repository
{
    /**
     * @param int    $project_id
     * @param string $column
     * @param string $sort
     * @return array
     */
    public function getProjectPurchaseByProjectId($project_id, $column = '', $sort = '');


    /**
     * @param  int|array $ids
     */
    public function delete($ids);
}