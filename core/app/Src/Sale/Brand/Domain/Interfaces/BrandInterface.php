<?php namespace Huifang\Src\Sale\Brand\Domain\Interfaces;


use Huifang\Src\Foundation\Domain\Interfaces\Repository;
use Huifang\Src\Sale\Brand\Domain\Model\BrandSpecification;


interface BrandInterface extends Repository
{

    /**
     * 品牌搜索
     * @param BrandSpecification $spec
     * @param int                $per_page
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function search(BrandSpecification $spec, $per_page);


    /**
     * @param int|array $ids
     */
    public function delete($ids);


}