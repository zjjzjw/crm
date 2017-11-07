<?php

namespace Huifang\Service\Msg;


use Huifang\Src\Msg\Domain\Model\MsgStatus;
use Huifang\Src\Msg\Domain\Model\MsgType;
use Huifang\Src\Msg\Domain\Model\UserMsgEntity;
use Huifang\Src\Msg\Infra\Repository\UserMsgRepository;
use Huifang\Src\Product\Domain\Model\ProductEntity;
use Huifang\Src\Product\Infra\Repository\ProductRepository;

class MsgService
{
    /**
     * 处理未读消息数
     * @param int $user_id
     */
    public function processBroadCastMsg($user_id)
    {
        $user_msg_repository = new UserMsgRepository();
        $user_msg_repository->findBroadcastMsg($user_id);
    }

    /**
     * 得到消息列表
     * @param int $user_id
     * @return array
     */
    public function getMsgTypeList($user_id)
    {
        $data = [];
        $user_msg_repository = new UserMsgRepository();
        $msg_types = MsgType::acceptableEnums();
        foreach ($msg_types as $key => $name) {
            $item['id'] = $key;
            $item['name'] = $name;
            $item['unread_count'] = $user_msg_repository->getMsgCount($user_id, $key, [MsgStatus::NOT_READ]);
            $item['total'] = $user_msg_repository->getMsgCount($user_id, $key, [MsgStatus::NOT_READ, MsgStatus::HAS_READ]);
            $data[] = $item;
        }
        return $data;
    }


    public function getMsgList($to_uid, $type)
    {
        $items = [];
        $user_msg_repository = new UserMsgRepository();
        $user_msg_entities = $user_msg_repository->getMessagesByToUidAndType($to_uid, $type);
        /** @var UserMsgEntity $user_msg_entity */
        foreach ($user_msg_entities as $user_msg_entity) {
            $item = $user_msg_entity->toArray();
            if ($user_msg_entity->msg_type == MsgType::SYSTEM) {
                $content = \GuzzleHttp\json_decode($user_msg_entity->content, true);
                $item['title'] = $content['title'];
                $item['info'] = $content['content'];
                $item['time'] = $user_msg_entity->created_at->format('m-d H:i');
            }
            $items[] = $item;
        }
        return $items;
    }


    /**
     * 得到信息想起
     * @param int $id
     * @return array
     */
    public function getUserMsgInfo($id)
    {
        $data = [];
        $user_msg_repository = new UserMsgRepository();
        /** @var UserMsgEntity $user_msg_entity */
        $user_msg_entity = $user_msg_repository->fetch($id);
        if (isset($user_msg_entity)) {
            $data = $user_msg_entity->toArray();
            if ($user_msg_entity->msg_type == MsgType::SYSTEM) {
                $content = \GuzzleHttp\json_decode($user_msg_entity->content, true);
                $data['title'] = $content['title'];
                $data['info'] = $content['content'];
                $data['time'] = $user_msg_entity->created_at->format('m-d h:i');
            }
        }
        return $data;
    }


    /**
     * @param int $id
     */
    public function setUsgMsgRead($id)
    {
        $user_msg_repository = new UserMsgRepository();
        /** @var UserMsgEntity $user_msg_entity */
        $user_msg_entity = $user_msg_repository->fetch($id);
        if (isset($user_msg_entity)) {
            $user_msg_entity->status = MsgStatus::HAS_READ;
            $user_msg_repository->save($user_msg_entity);
        }
    }


}

