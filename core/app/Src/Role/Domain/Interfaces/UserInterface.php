<?php namespace Huifang\Src\Role\Domain\Interfaces;

use Huifang\Src\Foundation\Domain\Interfaces\Repository;
use Huifang\Src\Role\Domain\Model\UserSpecification;

interface UserInterface extends Repository
{

    /**
     * @param UserSpecification $spec
     * @param int               $per_page
     * @return mixed
     */
    public function search(UserSpecification $spec, $per_page);

    /**
     * @param  array $ids
     * @return array|\Illuminate\Support\Collection
     */
    public function getUserByIds($ids);

    /**
     * @param int|array $company_id
     * @return array|\Illuminate\Support\Collection
     */
    public function getUsersByCompanyId($company_id);

    /**
     * @var string|array $phone
     * @return array|\Illuminate\Support\Collection
     */
    public function getUserByPhone($phone);

    /**
     * @param int|array $ids
     */
    public function delete($ids);
}