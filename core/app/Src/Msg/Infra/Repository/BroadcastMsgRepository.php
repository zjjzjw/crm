<?php namespace Huifang\Src\Msg\Infra\Repository;

use Carbon\Carbon;
use Huifang\Src\Foundation\Domain\Repository;
use Huifang\Src\Msg\Domain\Interfaces\BroadcastMsgInterface;
use Huifang\Src\Msg\Domain\Interfaces\UserMsgInterface;
use Huifang\Src\Msg\Domain\Model\BroadcastMsgEntity;
use Huifang\Src\Msg\Domain\Model\BroadcastMsgSpecification;
use Huifang\Src\Msg\Domain\Model\MsgStatus;
use Huifang\Src\Msg\Domain\Model\UserMsgEntity;
use Huifang\Src\Msg\Infra\Eloquent\BroadcastMsgModel;
use Huifang\Src\Msg\Infra\Eloquent\MsgExtModel;
use Huifang\Src\Msg\Infra\Eloquent\UserMsgModel;


class BroadcastMsgRepository extends Repository implements BroadcastMsgInterface
{
    /**
     * Store an entity into persistence.
     *
     * @param BroadcastMsgEntity $broadcast_msg_entity
     */
    protected function store($broadcast_msg_entity)
    {
        if ($broadcast_msg_entity->isStored()) {
            $model = BroadcastMsgModel::find($broadcast_msg_entity->id);
        } else {
            $model = new BroadcastMsgModel();
        }

        $model->fill(
            [
                'from_uid' => $broadcast_msg_entity->from_uid,
                'msg_id'   => $broadcast_msg_entity->msg_id,
                'msg_type' => $broadcast_msg_entity->msg_type,
            ]
        );
        $model->save();
        $broadcast_msg_entity->setIdentity($model->id);
    }

    /**
     * Reconstitute an entity from persistence.
     *
     * @param mixed $id
     * @param array $params Additional params.
     *
     * @return BroadcastMsgModel
     */
    protected function reconstitute($id, $params = [])
    {
        $model = BroadcastMsgModel::find($id);
        if (!isset($model)) {
            return null;
        }
        return $this->reconstituteFromModel($model);
    }

    /**
     * @param BroadcastMsgModel $model
     *
     * @return BroadcastMsgEntity
     */
    private function reconstituteFromModel($model)
    {
        $entity = new BroadcastMsgEntity();
        $entity->id = $model->id;
        $entity->from_uid = $model->from_uid;
        $entity->msg_id = $model->msg_id;
        $entity->msg_type = $model->msg_type;
        $entity->created_at = $model->created_at;
        $entity->updated_at = $model->updated_at;
        $entity->setIdentity($model->id);
        $entity->stored();
        return $entity;
    }


    /**
     * @param BroadcastMsgSpecification $spec
     * @param int                       $per_page
     * @return mixed
     */
    public function search(BroadcastMsgSpecification $spec, $per_page = 10)
    {
        $builder = BroadcastMsgModel::query();
        $builder->orderBy('created_at', 'desc');

        if ($spec->page) {
            $paginator = $builder->paginate($per_page, ['*'], 'page', $spec->page);
        } else {
            $paginator = $builder->paginate($per_page);
        }
        foreach ($paginator as $key => $model) {
            $paginator[$key] = $this->reconstituteFromModel($model)->stored();
        }
        return $paginator;
    }


}