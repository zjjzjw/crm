<?php namespace Huifang\Src\Product\Domain\Interfaces;


use Huifang\Src\Foundation\Domain\Interfaces\Repository;
use Huifang\Src\Product\Domain\Model\ProductSpecification;
use Huifang\Src\Project\Domain\Model\ProjectFileEntity;
use Huifang\Src\Project\Domain\Model\ProjectSpecification;

interface ProductInterface extends Repository
{

    /**
     * @param $company_id
     * @return array|\Illuminate\Support\Collection
     */
    public function getProductsByCompanyId($company_id);

    /**
     * @param ProductSpecification $spec
     * @return array|\Illuminate\Support\Collection
     */
    public function getProductsBySpecification($spec);

    /**
     * @param  array $ids
     * @return  mixed
     */
    public function getProductsByIds($ids);

    /**
     * @param int|array $ids
     */
    public function delete($ids);

}