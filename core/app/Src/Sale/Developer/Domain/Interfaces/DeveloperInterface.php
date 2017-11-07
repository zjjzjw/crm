<?php namespace Huifang\Src\Sale\Developer\Domain\Interfaces;

use Huifang\Src\Foundation\Domain\Interfaces\Repository;
use Huifang\Src\Sale\Developer\Domain\Model\DeveloperSpecification;


interface DeveloperInterface extends Repository
{

    /**
     * 分公司搜索
     * @param DeveloperSpecification $spec
     * @param int                $per_page
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function search(DeveloperSpecification $spec, $per_page);


    /**
     * @param int|array $ids
     */
    public function delete($ids);


}