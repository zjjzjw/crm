<?php

namespace Huifang\Service\Msg;


use Huifang\Src\Msg\Domain\Model\BroadcastMsgEntity;
use Huifang\Src\Msg\Domain\Model\BroadcastMsgSpecification;
use Huifang\Src\Msg\Infra\Repository\BroadcastMsgRepository;
use Huifang\Src\Msg\Infra\Repository\MsgExtRepository;

class BroadcastMsgService
{
    /**
     * @param BroadcastMsgSpecification $spec
     * @param int                       $per_page
     * @return array
     */
    public function getBroadcastMsgList(BroadcastMsgSpecification $spec, $per_page)
    {
        $data = [];
        $broadcast_msg_repository = new BroadcastMsgRepository();
        $paginate = $broadcast_msg_repository->search($spec, $per_page);
        $items = [];
        $msg_ext_repository = new MsgExtRepository();
        /**
         * @var mixed              $key
         * @var BroadcastMsgEntity $broadcast_msg_entity
         */
        foreach ($paginate as $key => $broadcast_msg_entity) {
            $item = $broadcast_msg_entity->toArray();
            $item['created_at'] = $broadcast_msg_entity->created_at->format('Y-m-d H:i');
            $msg_ext_entity = $msg_ext_repository->fetch($broadcast_msg_entity->msg_id);
            if (isset($msg_ext_entity)) {
                $content = \GuzzleHttp\json_decode($msg_ext_entity->content, true);
                $item['title'] = $content['title'];
                $item['info'] = $content['content'];
            }
            $paginate[$key] = $item;
            $items[] = $item;
        }
        $data['paginate'] = $paginate;
        $data['items'] = $items;
        $data['pager']['total'] = $paginate->total();
        $data['pager']['last_page'] = $paginate->lastPage();
        $data['pager']['current_page'] = $paginate->currentPage();
        return $data;
    }

    /**
     * @param int $id
     * @return array
     */
    public function getBroadcastMsgInfo($id)
    {
        $data = [];
        $broadcast_msg_repository = new BroadcastMsgRepository();
        /** @var BroadcastMsgEntity $broadcast_msg_entity */
        $broadcast_msg_entity = $broadcast_msg_repository->fetch($id);
        $msg_ext_repository = new MsgExtRepository();
        if ($broadcast_msg_entity) {
            $data = $broadcast_msg_entity->toArray();
            $msg_ext_entity = $msg_ext_repository->fetch($broadcast_msg_entity->msg_id);
            if (isset($msg_ext_entity)) {
                $content = \GuzzleHttp\json_decode($msg_ext_entity->content, true);
                $data['title'] = $content['title'];
                $data['info'] = $content['content'];
            }
        }
        return $data;
    }


}

