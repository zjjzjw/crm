<?php namespace Huifang\Src\Sale\DeveloperGroup\Domain\Interfaces;

use Huifang\Src\Foundation\Domain\Interfaces\Repository;
use Huifang\Src\Sale\DeveloperGroup\Domain\Model\DeveloperGroupSpecification;


interface DeveloperGroupInterface extends Repository
{

    /**
     * 集团搜索
     * @param DeveloperGroupSpecification $spec
     * @param int                $per_page
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function search(DeveloperGroupSpecification $spec, $per_page);


    /**
     * @param int|array $ids
     */
    public function delete($ids);


}