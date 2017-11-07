<?php namespace Huifang\Src\Sale\LargeArea\Domain\Interfaces;

use Huifang\Src\Foundation\Domain\Interfaces\Repository;
use Huifang\Src\Sale\LargeArea\Domain\Model\LargeAreaSpecification;


interface LargeAreaInterface extends Repository
{

    /**
     * 大区搜索
     * @param LargeAreaSpecification $spec
     * @param int                $per_page
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function search(LargeAreaSpecification $spec, $per_page);


    /**
     * @param int|array $ids
     */
    public function delete($ids);


}