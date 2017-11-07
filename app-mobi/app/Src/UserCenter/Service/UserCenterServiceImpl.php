<?php namespace Huifang\Mobi\Src\UserCenter\Service;


class UserCenterServiceImpl implements UserCenterService
{

    const LOGIN_ERROR_MSG_KEY = 'login_error_msg';

    public function __construct()
    {

    }

    /**
     * Retrieve a user by the given credentials.
     *
     * @param array $credentials
     *
     * @return mixed
     */
    public function login(array $credentials)
    {
        $result = $this->userLogin($credentials);
        if (isset($result['msg'])) {
            $this->storeLoginErrorMsg($result['msg']);
            return null;
        }
        if (isset($result['user_id'])) {
            return $result['user_id'];
        }

        return null;
    }

    public function getMd5Password($password)
    {
        return md5(md5($password) . config('auth.salt'));
    }

    public function userLogin($credentials)
    {
        //登录代码
        $data = [];
        $builder = \Huifang\Web\User::query();
        $builder->where('phone', $credentials['phone']);

        $model = $builder->first();
        if (!isset($model)) {
            $data['msg'] = '用户不存在!';
        } else {
            $data['user_id'] = $model->id;
            $password = $model->password;
            if ($password !== $this->getMd5Password($credentials['password'])) {
                $data['msg'] = '密码错误!';
            }
        }
        return $data;
    }

    /**
     * 获取登录失败信息
     *
     * @return string
     */
    public function getFailedLoginMessage()
    {
        return session(self::LOGIN_ERROR_MSG_KEY);
    }

    /**
     * 存储登录错误信息
     *
     * @param $msg
     *
     * @return mixed
     */
    protected function storeLoginErrorMsg($msg)
    {
        return session()->flash(self::LOGIN_ERROR_MSG_KEY, $msg);
    }

}