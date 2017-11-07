<?php namespace Huifang\Src\Project\Domain\Interfaces;


use Huifang\Src\Foundation\Domain\Interfaces\Repository;
use Huifang\Src\Project\Domain\Model\ProjectAimHinderSpecification;
use Huifang\Src\Project\Domain\Model\ProjectFileEntity;
use Huifang\Src\Project\Domain\Model\ProjectSpecification;

interface ProjectAimHinderInterface extends Repository
{
    /**
     * @param int $project_id
     * @return mixed
     */
    public function getProjectAimHindersByProjectIdAndAimId($project_id, $aim_id);

    /**
     * @param int    $project_purchase_id
     * @param string $column
     * @param string $sort
     * @return array|\Illuminate\Support\Collection
     */
    public function getProjectAimHindersByProjectPurchaseId($project_purchase_id, $column = '', $sort = '');

    /**
     * @param  array|int $ids
     */
    public function delete($ids);


    /**
     * @param    ProjectAimHinderSpecification $spec
     * @return array|\Illuminate\Support\Collection
     */
    public function getHindersBySpecification($spec);


    /**
     * @param ProjectAimHinderSpecification $spec
     * @param int                           $per_page
     * @return mixed
     */
    public function search($spec, $per_page);

}