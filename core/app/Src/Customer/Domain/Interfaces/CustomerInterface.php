<?php namespace Huifang\Src\Customer\Domain\Interfaces;


use Huifang\Src\Customer\Domain\Model\CustomerSpecification;
use Huifang\Src\Foundation\Domain\Interfaces\Repository;

interface CustomerInterface extends Repository
{

    /**
     * @param CustomerSpecification $spec
     * @param int                   $per_page
     * @return mixed
     */
    public function search(CustomerSpecification $spec, $per_page);


    /**
     * 通过关键字得到客户
     * @param CustomerSpecification $spec
     * @param int                   $limit
     */
    public function getCustomerListByKeyword(CustomerSpecification $spec, $limit = 10);


    /**
     * @param int|array $ids
     */
    public function delete($ids);
}