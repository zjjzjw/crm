<?php namespace Huifang\Src\Sale\Domain\Interfaces;

use Huifang\Src\Foundation\Domain\Interfaces\Repository;
use Huifang\Src\Sale\Domain\Model\SalePropertySpecification;

interface SalePropertyInterface extends Repository
{
    /**
     * @param SalePropertySpecification $spec
     * @param int                       $per_page
     * @return mixed
     */
    public function search(SalePropertySpecification $spec, $per_page = 10);

    /**
     * @param int|array $ids
     */
    public function delete($ids);

}