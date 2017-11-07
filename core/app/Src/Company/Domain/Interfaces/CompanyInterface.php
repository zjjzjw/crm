<?php namespace Huifang\Src\Company\Domain\Interfaces;

use Huifang\Src\Company\Domain\Model\CompanySpecification;
use Huifang\Src\Foundation\Domain\Interfaces\Repository;
use Huifang\Src\Sale\Domain\Model\SaleSpecification;

interface CompanyInterface extends Repository
{
    /**
     * @param SaleSpecification $spec
     * @param int               $per_page
     * @return mixed
     */
    public function search(CompanySpecification $spec, $per_page = 10);


}