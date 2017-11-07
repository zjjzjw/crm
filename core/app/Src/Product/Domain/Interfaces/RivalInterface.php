<?php namespace Huifang\Src\Product\Domain\Interfaces;


use Huifang\Src\Foundation\Domain\Interfaces\Repository;
use Huifang\Src\Product\Domain\Model\RivalSpecification;
use Huifang\Src\Project\Domain\Model\ProjectFileEntity;
use Huifang\Src\Project\Domain\Model\ProjectSpecification;

interface RivalInterface extends Repository
{

    /**
     * 竞品公司搜索
     * @param RivalSpecification $spec
     * @param int                $per_page
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function search(RivalSpecification $spec, $per_page);

    /**
     * @param int $company_id
     * @return array|\Illuminate\Support\Collection
     */
    public function getRivalsByCompanyId($company_id);

    /**
     * @param int|array $ids
     */
    public function delete($ids);


}