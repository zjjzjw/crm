<?php namespace Huifang\Src\Role\Domain\Interfaces;

use Huifang\Src\Foundation\Domain\Interfaces\Repository;
use Huifang\Src\Role\Domain\Model\MobileSessionSpecification;

interface MobileSessionInterface extends Repository
{
    /**
     * @param MobileSessionSpecification          $spec
     * @param                                     $per_page
     * @return mixed
     */
    public function search(MobileSessionSpecification $spec, $per_page);

    /**
     * @param $id
     * @return mixed
     */
    public function delete($id);


    /**
     * @param $user_id
     * @return mixed
     */
    public function getMobileSessionByUserId($user_id);


    /**
     * @param string   $token
     * @param null|int $user_id
     * @return mixed
     */
    public function getUserByToken($token, $user_id = null);

}