<?php namespace Huifang\Service\Role;

use Huifang\Src\Role\Domain\Exception\LoginException;
use Huifang\Src\Role\Domain\Model\UserEntity;
use Huifang\Src\Role\Infra\Repository\MobileSessionRepository;
use Huifang\Src\Role\Infra\Repository\UserRepository;
use Illuminate\Http\Request;

class TokenService
{

    const KEY = "~fangquan_m*&";

    public static $m;
    public static $t;
    public static $user_id;
    public static $device_type;
    public static $token;
    public static $appver;


    /** @var UserEntity $user_entity */
    public static $user_entity;

    public static function setHeaders(Request $request)
    {
        self::$m = $request->header('m');
        self::$t = $request->header('t');
        self::$user_id = $request->header('userid');
        self::$token = $request->header('token');
        self::$device_type = $request->header('devicetype');
    }

    public static function getUserId()
    {
        return self::$user_id;
    }

    public static function getToken()
    {
        return self::$token;
    }

    public static function getDeviceType()
    {
        return self::$device_type;
    }

    public static function getT()
    {
        return self::$t;
    }

    public static function getM()
    {
        return self::$m;
    }

    public static function isLogin()
    {
        return (self::$user_id !== null) && !empty(self::$user_id);
    }

    public static function checkToken()
    {
        $token = self::$token;
        $user_id = self::$user_id;
        $mobile_session_repository = new MobileSessionRepository();
        if (!empty($token) && !empty($user_id)) {
            $mobile_session_entity = $mobile_session_repository->getUserByToken($token, $user_id);
            if (empty($mobile_session_entity)) {
                throw new LoginException('', LoginException::ERROR_TOKEN_ILLEGAL);
            }
        }
        return true;
    }

    /**
     * 验证token是否过期，过期需要重新登录
     * @param $token
     * @return bool
     */
    public static function apiTokenIsValid($token)
    {
        $mobile_session_repository = new MobileSessionRepository();
        $mobile_session_entity = $mobile_session_repository->getUserByToken($token);
        $updated_at = strtotime($mobile_session_entity->updated_at);
        $expire = env('API_TOKEN_EXPIRE');
        if (empty($expire)) {
            return true;
        }
        return $updated_at + $expire >= time();
    }


    /**
     * 验证访问令牌的合法性
     * @param $m
     * @param $t
     * @return array|bool
     */
    public function apiMisValid($m, $t)
    {
        $expire = 1000;
        if (time() > $t + $expire) {
            throw new LoginException('', LoginException::ERROR_M_EXPIRE);
        }
        //生成新的M值
        $new_value = md5(self::KEY . $t);
        if ($new_value != $m) {
            throw new LoginException('', LoginException::ERROR_M_ILLEGAL);
        }
        return true;
    }


    /**
     * 得到当前登录用户信息
     * @return UserEntity
     */
    public static function getUserEntity()
    {
        if (isset(self::$user_entity)) {
            return self::$user_entity;
        } else {
            if (self::$user_id) {
                $user_repository = new UserRepository();
                self::$user_entity = $user_repository->fetch(self::$user_id);
            } else {
                throw new LoginException('', LoginException::ERROR_NO_LOGIN);
            }
        }
        return self::$user_entity;
    }
}