<?php namespace Huifang\Admin\Src\UserCenter\Service;


interface UserCenterService
{
    /**
     * Retrieve a user by the given credentials.
     *
     * @param array $credentials
     * @return mixed
     */
    public function login(array $credentials);

    /**
     * 获取登录失败信息
     *
     * @return string
     */
    public function getFailedLoginMessage();


}