<?php namespace Huifang\Mobi\Src\Service\Auth;

use Huifang\Src\Role\Domain\Model\MobileRegStatus;
use Huifang\Src\Role\Domain\Exception\LoginException;
use Huifang\Src\Role\Domain\Model\MobileLoginSpecification;
use Huifang\Src\Role\Domain\Model\MobileSessionEntity;
use Huifang\Src\Role\Domain\Model\UserEntity;
use Huifang\Src\Role\Domain\Model\UserPlatformType;
use Huifang\Src\Role\Infra\Repository\MobileSessionRepository;
use Huifang\Src\Role\Infra\Repository\UserRepository;

class MobileSessionService
{
    /**
     * @param MobileLoginSpecification $mobile_login_specification
     * @return array
     */
    public function login($mobile_login_specification)
    {
        $account = $mobile_login_specification->account;
        $password = $mobile_login_specification->password;
        $reg_id = $mobile_login_specification->reg_id;
        $ip = $mobile_login_specification->ip;

        $user_repository = new UserRepository();
        //account 为手机号

        $user_entities = $user_repository->getUserByPhone($account);
        /** @var UserEntity $user_entity */
        $user_entity = $user_entities->first();
        if (!isset($user_entity)) {
            throw new LoginException('', LoginException::ERROR_USER_NOT_EXPIRE);
        }
        if ($user_entity->password != $this->getMd5Password($password)) {
            throw new LoginException('', LoginException::ERROR_PASSWORD);
        } else {
            $data = $this->saveLoginRecord($user_entity->id, $reg_id, $ip);
        }
        return $data;
    }

    /**
     * 生成登录信息
     * @param $user_id
     * @param $reg_id
     * @param $client_ip
     * @return array
     */
    public function saveLoginRecord($user_id, $reg_id, $client_ip)
    {
        //生成登录信息
        $token = $this->generateAccessToken();
        $mobile_session_repository = new MobileSessionRepository();
        /** @var MobileSessionEntity $mobile_session_entity */
        $mobile_session_entity = $mobile_session_repository->getMobileSessionByUserId($user_id);
        if (empty($mobile_session_entity)) {
            $mobile_session_entity = new MobileSessionEntity();
            $mobile_session_entity->user_id = $user_id;
        }
        $mobile_session_entity->token = $token;
        $mobile_session_entity->reg_id = $reg_id ?? '';
        $mobile_session_entity->type = UserPlatformType::TYPE_OTHER; //先默认为其他
        $mobile_session_entity->enable_notify = MobileRegStatus::YES_REG;
        $mobile_session_repository->save($mobile_session_entity);

        if (!empty($reg_id)) {
            $mobile_session_repository->deleteRedId($reg_id, $user_id);
        }

        return $data = [
            "success" => true,
            "code"    => 200,
            "user_id" => $user_id,
            "token"   => $token,
        ];
    }


    /**
     * 生成访问口令
     *
     * @return string
     */
    public function generateAccessToken()
    {
        return md5(uniqid("fq_mobile", true));
    }

    /**
     * 生成加密密码
     * @param string $password
     * @return string
     */
    public function getMd5Password($password)
    {
        return md5(md5($password) . config('auth.salt'));
    }
}

