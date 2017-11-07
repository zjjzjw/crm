<?php namespace Huifang\Src\Product\Domain\Interfaces;


use Huifang\Src\Foundation\Domain\Interfaces\Repository;
use Huifang\Src\Product\Domain\Model\ProductCategorySpecification;

interface ProductCategoryInterface extends Repository
{
    /**
     * 产品搜索
     * @param ProductCategorySpecification $spec
     * @param                              $per_page
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function search(ProductCategorySpecification $spec, $per_page);

    /**
     * @param $company_id
     * @return array|\Illuminate\Support\Collection
     */
    public function getProductCategoriesByCompanyId($company_id);


    /**
     * @param int|array $ids
     */
    public function delete($ids);
}