<?php namespace Huifang\Web\Http\Controllers;


use Huifang\Service\Msg\MsgService;

class MessageController extends BaseController
{

    public function messageIndex()
    {
        $data = [];
        $this->file_css = 'message.index';
        $this->file_js = 'message.index';
        $this->title = '消息';

        $user = $this->getUser();
        $msg_service = new MsgService();
        $msg_service->processBroadCastMsg($user->id);
        $msg_types = $msg_service->getMsgTypeList($user->id);
        $data['msg_types'] = $msg_types;
        $choose = [
            'title' => $this->title,
        ];
        $data['choose'] = $choose;
        return $this->view('message.index', $data);
    }

    //系统消息
    public function messageList($type)
    {
        $data = [];
        $this->title = '系统消息';
        $this->file_css = 'message.list';
        $this->file_js = 'message.list';
        $user = $this->getUser();
        $msg_service = new MsgService();
        $user_messages = $msg_service->getMsgList($user->id, $type);
        $data['user_messages'] = $user_messages;
        $choose = [
            'title' => $this->title,
        ];
        $data['choose'] = $choose;
        return $this->view('message.list', $data);
    }

    //系统消息
    public function messageDetail($id)
    {
        $data = [];
        $this->title = '系统信息详情';
        $this->file_css = 'message.detail';
        $this->file_js = 'message.detail';
        $msg_service = new MsgService();
        $data = $msg_service->getUserMsgInfo($id);
        $msg_service->setUsgMsgRead($id);
        $choose = [
            'title' => $this->title,
        ];
        $data['choose'] = $choose;
        return $this->view('message.detail', $data);
    }

}
