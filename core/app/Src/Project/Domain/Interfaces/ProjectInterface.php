<?php namespace Huifang\Src\Project\Domain\Interfaces;


use Huifang\Src\Foundation\Domain\Interfaces\Repository;
use Huifang\Src\Project\Domain\Model\ProjectSpecification;

interface ProjectInterface extends Repository
{
    /**
     * @param ProjectSpecification $spec
     * @param int                  $per_page
     * @return mixed
     */
    public function search(ProjectSpecification $spec, $per_page = 10);

    /**
     * @param ProjectSpecification $spec
     * @param int                  $limit
     * @return array|\Illuminate\Support\Collection
     */
    public function getProjectListByKeyword(ProjectSpecification $spec, $limit = 20);

    /**
     * @param int|array $user_id
     * @return array|\Illuminate\Support\Collection
     */
    public function getProjectsByUserId($user_id);

    /**
     * @param int|array $ids
     */
    public function delete($ids);

}