<?php

namespace Huifang\Crm\Src\Forms\Msg;

use Carbon\Carbon;
use Huifang\Src\Company\Domain\Model\CompanyEntity;
use Huifang\Src\Company\Infra\Repository\CompanyRepository;
use Huifang\Src\Msg\Domain\Model\BroadcastMsgEntity;
use Huifang\Src\Msg\Domain\Model\MsgExtEntity;
use Huifang\Src\Msg\Domain\Model\MsgType;
use Huifang\Src\Msg\Infra\Repository\BroadcastMsgRepository;
use Huifang\Src\Msg\Infra\Repository\MsgExtRepository;
use Huifang\Src\Role\Domain\Model\DepartEntity;
use Huifang\Src\Role\Infra\Repository\DepartRepository;
use Huifang\Src\Sale\Domain\Model\SaleSpecification;
use Huifang\Crm\Src\Forms\Form;

class BroadcastMsgStoreForm extends Form
{

    /**
     * @var BroadcastMsgEntity
     */
    public $broadcast_msg_entity;

    /**
     * @var MsgExtEntity
     */
    public $msg_ext_entity;

    /**
     * Get the validation rules.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'id'    => 'required|integer',
            'title' => 'required|string',
            'info'  => 'required|string',
        ];
    }

    protected function messages()
    {
        return [
            'required'    => ':attribute必填。',
            'date_format' => ':attribute格式错误',
            'integer'     => ':attribute必须是数字',
        ];
    }

    public function attributes()
    {
        return [
            'title' => '标题',
            'name'  => '内容',
        ];
    }

    public function validation()
    {
        $broadcast_msg_repository = new BroadcastMsgRepository();
        $msg_ext_repository = new MsgExtRepository();
        if (array_get($this->data, 'id')) {
            /** @var BroadcastMsgEntity $broadcast_msg_entity */
            $broadcast_msg_entity = $broadcast_msg_repository->fetch(array_get($this->data, 'id'));
            $msg_ext_entity = $msg_ext_repository->fetch($broadcast_msg_entity->msg_id);
        } else {
            $broadcast_msg_entity = new BroadcastMsgEntity();
            $broadcast_msg_entity->from_uid = 0;
            $broadcast_msg_entity->msg_type = MsgType::SYSTEM;

            $msg_ext_entity = new MsgExtEntity();
            $msg_ext_entity->msg_type = MsgType::SYSTEM;
        }

        $title = array_get($this->data, 'title');
        $info = array_get($this->data, 'info');
        $content = ['title' => $title, 'content' => $info];
        $msg_ext_entity->content = \GuzzleHttp\json_encode($content, true);

        $this->broadcast_msg_entity = $broadcast_msg_entity;
        $this->msg_ext_entity = $msg_ext_entity;

    }

}