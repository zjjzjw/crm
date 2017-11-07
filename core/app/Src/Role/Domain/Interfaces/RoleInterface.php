<?php namespace Huifang\Src\Role\Domain\Interfaces;

use Huifang\Crm\Src\Forms\Company\Role\RoleStoreForm;
use Huifang\Src\Foundation\Domain\Interfaces\Repository;
use Huifang\Src\Role\Domain\Model\DepartSpecification;
use Huifang\Src\Role\Domain\Model\RoleSpecification;

interface RoleInterface extends Repository
{
    /**
     * @param RoleSpecification $spec
     * @param int               $per_page
     * @return mixed
     */
    public function search(RoleSpecification $spec, $per_page = 10);

    /**
     * @param $company_id
     * @return array|\Illuminate\Support\Collection
     */
    public function getRoleByCompanyId($company_id);

    /**
     * @param int|array $ids
     */
    public function delete($ids);

}