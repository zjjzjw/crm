<?php namespace Huifang\Src\Sale\Domain\Interfaces;

use Huifang\Src\Foundation\Domain\Interfaces\Repository;
use Huifang\Src\Sale\Domain\Model\SaleSpecification;

interface SaleInterface extends Repository
{
    /**
     * @param SaleSpecification $spec
     * @param int               $per_page
     * @return mixed
     */
    public function search(SaleSpecification $spec, $per_page = 10);

    /**
     * @param SaleSpecification $spec
     * @param int               $limit
     * @return array|\Illuminate\Support\Collection
     */
    public function getSaleListByKeyword($keyword, $limit = 20);

    /**
     * @param int|array $ids
     */
    public function delete($ids);
    
}