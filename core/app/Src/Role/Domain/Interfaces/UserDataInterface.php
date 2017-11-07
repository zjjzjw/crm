<?php namespace Huifang\Src\Role\Domain\Interfaces;

use Huifang\Src\Foundation\Domain\Interfaces\Repository;
use Huifang\Src\Role\Domain\Model\UserSpecification;

interface UserDataInterface extends Repository
{
    /**
     * @param int $user_id
     * @return array|\Illuminate\Support\Collection
     */
    public function getUserDataByUserId($user_id);

    /**
     * @param int $user_id
     * @param int $data_type
     * @return array|\Illuminate\Support\Collection
     */
    public function getUserDataByUserIdAndDataType($user_id, $data_type);
}