<?php namespace Huifang\Src\Msg\Domain\Interfaces;


use Huifang\Src\Foundation\Domain\Interfaces\Repository;
use Huifang\Src\Project\Domain\Model\ProjectAimHinderSpecification;
use Huifang\Src\Project\Domain\Model\ProjectFileEntity;
use Huifang\Src\Project\Domain\Model\ProjectSpecification;

interface UserMsgInterface extends Repository
{

    /**
     * 查找系统消息
     * @param int $user_id
     */
    public function findBroadcastMsg($user_id);

    /**
     * 得到唯独消息数量
     * @param int       $user_id
     * @param int|array $msg_type
     * @param int|array $status
     * @return mixed
     */
    public function getMsgCount($user_id, $msg_type, $status);

}