<?php namespace Huifang\Crm\Http\Controllers;


use Huifang\Crm\Src\Forms\Msg\BroadcastMsgStoreForm;
use Huifang\Service\Msg\BroadcastMsgService;
use Huifang\Src\Msg\Domain\Model\BroadcastMsgEntity;
use Huifang\Src\Msg\Domain\Model\BroadcastMsgSpecification;
use Huifang\Src\Msg\Infra\Repository\BroadcastMsgRepository;
use Huifang\Src\Msg\Infra\Repository\MsgExtRepository;
use Illuminate\Http\Request;

class PublicityController extends BaseController
{
    public function index()
    {
        $data = [];
        $this->file_css = 'pages.publicity.index';
        $this->file_js = 'pages.publicity.index';
        $broadcast_msg_service = new BroadcastMsgService();
        $broadcast_msg_specification = new BroadcastMsgSpecification();
        $data = $broadcast_msg_service->getBroadcastMsgList($broadcast_msg_specification, 20);

        return $this->view('pages.publicity.index', $data);
    }

    public function edit($id)
    {
        $this->file_css = 'pages.publicity.edit';
        $this->file_js = 'pages.publicity.edit';
        $data = [];
        $broadcast_msg_service = new BroadcastMsgService();
        $data = $broadcast_msg_service->getBroadcastMsgInfo($id);
        return $this->view('pages.publicity.edit', $data);
    }

    public function store(Request $request, BroadcastMsgStoreForm $form)
    {
        $form->validate($request->all());

        $msg_ext_repository = new MsgExtRepository();
        $broadcast_msg_repository = new BroadcastMsgRepository();
        $msg_ext_repository->save($form->msg_ext_entity);
        $form->broadcast_msg_entity->msg_id = $form->msg_ext_entity->id;
        $broadcast_msg_repository->save($form->broadcast_msg_entity);

        return redirect()->to(route('publicity.index'));

    }


}