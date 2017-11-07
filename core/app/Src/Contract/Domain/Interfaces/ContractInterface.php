<?php namespace Huifang\Src\Contract\Domain\Interfaces;


use Carbon\Carbon;
use Huifang\Src\Contract\Domain\Model\ContractSpecification;
use Huifang\Src\Customer\Domain\Model\CustomerSpecification;
use Huifang\Src\Foundation\Domain\Interfaces\Repository;

interface ContractInterface extends Repository
{


    /**
     * 通过关键字得到客户
     * @param ContractSpecification $spec
     * @param int                   $limit
     */
    public function getContractListByKeyword(ContractSpecification $spec, $limit = 10);


    /**
     * @param int|array $ids
     */
    public function delete($ids);

    /**
     * @param int       $company_id
     * @param int|array $user_id
     * @param Carbon    $start_time
     * @param Carbon    $end_time
     * @return array|\Illuminate\Support\Collection
     */
    public function getContractsByDate($company_id, $user_id, $start_time, $end_time);

}