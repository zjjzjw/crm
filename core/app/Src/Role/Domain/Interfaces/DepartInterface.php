<?php namespace Huifang\Src\Role\Domain\Interfaces;

use Huifang\Src\Company\Domain\Model\CompanySpecification;
use Huifang\Src\Foundation\Domain\Interfaces\Repository;
use Huifang\Src\Role\Domain\Model\DepartSpecification;
use Huifang\Src\Sale\Domain\Model\SaleSpecification;

interface DepartInterface extends Repository
{
    /**
     * @param DepartSpecification $spec
     * @param int                 $per_page
     * @return mixed
     */
    public function search(DepartSpecification $spec, $per_page = 10);

    /**
     * 获取所有部门
     * @param $company_id
     * @return array|\Illuminate\Support\Collection
     */
    public function getDepartByCompanyId($company_id);

    /**
     * @param int|array $ids
     */
    public function delete($ids);

    /**
     * 获取子类
     * @param $parent_id
     * @return array|\Illuminate\Support\Collection
     */
    public function getDepartByParentId($parent_id);
}