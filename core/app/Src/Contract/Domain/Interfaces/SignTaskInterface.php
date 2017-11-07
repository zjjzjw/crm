<?php namespace Huifang\Src\Contract\Domain\Interfaces;


use Carbon\Carbon;
use Huifang\Src\Contract\Domain\Model\ContractSpecification;
use Huifang\Src\Contract\Domain\Model\SignTaskEntity;
use Huifang\Src\Customer\Domain\Model\CustomerSpecification;
use Huifang\Src\Foundation\Domain\Interfaces\Repository;

interface SignTaskInterface extends Repository
{

    /*
     * @param array $ids
     */
    public function delete($ids);


    /**
     * @param $user_id
     * @return array|\Illuminate\Support\Collection
     */
    public function getSignTasksByUserId($user_id);

    /**
     * @param int $user_id
     * @param int $month
     * @return SignTaskEntity|null
     */
    public function getSignTasksByUserIdAndMonth($user_id, $month);
}