<?php namespace Huifang\Src\Msg\Infra\Repository;

use Carbon\Carbon;
use Huifang\Src\Foundation\Domain\Repository;
use Huifang\Src\Msg\Domain\Interfaces\UserMsgInterface;
use Huifang\Src\Msg\Domain\Model\MsgStatus;
use Huifang\Src\Msg\Domain\Model\UserMsgEntity;
use Huifang\Src\Msg\Infra\Eloquent\BroadcastMsgModel;
use Huifang\Src\Msg\Infra\Eloquent\MsgExtModel;
use Huifang\Src\Msg\Infra\Eloquent\UserMsgModel;
use Huifang\Src\Role\Infra\Eloquent\UserModel;


class UserMsgRepository extends Repository implements UserMsgInterface
{
    /**
     * Store an entity into persistence.
     *
     * @param UserMsgEntity $user_msg_entity
     */
    protected function store($user_msg_entity)
    {
        if ($user_msg_entity->isStored()) {
            $model = UserMsgModel::find($user_msg_entity->id);
        } else {
            $model = new UserMsgModel();
        }

        $model->fill(
            [
                'msg_id'   => $user_msg_entity->msg_id,
                'from_uid' => $user_msg_entity->from_uid,
                'to_uid'   => $user_msg_entity->to_uid,
                'msg_type' => $user_msg_entity->msg_type,
                'status'   => $user_msg_entity->status,
                'read_at'  => $user_msg_entity->read_at,
            ]
        );
        $model->save();
        $user_msg_entity->setIdentity($model->id);
    }

    /**
     * Reconstitute an entity from persistence.
     *
     * @param mixed $id
     * @param array $params Additional params.
     *
     * @return UserMsgModel
     */
    protected function reconstitute($id, $params = [])
    {
        $model = UserMsgModel::find($id);
        if (!isset($model)) {
            return null;
        }
        return $this->reconstituteFromModel($model);
    }

    /**
     * @param UserMsgModel $model
     *
     * @return UserMsgEntity
     */
    private function reconstituteFromModel($model)
    {
        $entity = new UserMsgEntity();
        $entity->id = $model->id;

        $entity->msg_id = $model->msg_id;
        $entity->from_uid = $model->from_uid;
        $entity->to_uid = $model->to_uid;
        $entity->msg_type = $model->msg_type;
        $entity->read_at = $model->read_at;
        $entity->status = $model->status;
        $msg_ext_model = $model->msg_ext;
        if (isset($msg_ext_model)) {
            $entity->content = $msg_ext_model->content;
        }
        $entity->created_at = $model->created_at;
        $entity->updated_at = $model->updated_at;
        $entity->setIdentity($model->id);
        $entity->stored();
        return $entity;
    }

    /**
     * 查找系统消息
     * @param int $user_id
     */
    public function findBroadcastMsg($user_id)
    {
        //得到最大的一条消息
        $max_msg_id = 0;
        $user_msg_builder = UserMsgModel::query();
        $user_msg_builder->where('to_uid', $user_id);
        $user_msg_builder->orderBy('id', 'desc');
        $user_msg_model = $user_msg_builder->first();
        if (isset($user_msg_model)) {
            $max_msg_id = $user_msg_model->msg_id;
        }

        $user_model = UserModel::find($user_id);
        $broadcast_msg_builder = BroadcastMsgModel::query();
        $broadcast_msg_builder->where('msg_id', '>', $max_msg_id);

        //必须是账号创建之后的消息
        if (isset($user_model)) {
            $broadcast_msg_builder->where('created_at', '>', $user_model->created_at);
        }
        $broadcast_msg_models = $broadcast_msg_builder->get();

        foreach ($broadcast_msg_models as $broadcast_msg_model) {
            $user_msg_model = new UserMsgModel();
            $user_msg_model->msg_id = $broadcast_msg_model->msg_id;

            $user_msg_model->from_uid = $broadcast_msg_model->from_uid;
            $user_msg_model->to_uid = $user_id;
            $user_msg_model->msg_type = $broadcast_msg_model->msg_type;
            $user_msg_model->read_at = Carbon::now();
            $user_msg_model->status = MsgStatus::NOT_READ;
            $user_msg_model->save();
        }
    }


    /**
     * 得到唯独消息数量
     * @param int       $user_id
     * @param int|array $msg_type
     * @param int|array $status
     * @return mixed
     */
    public function getMsgCount($user_id, $msg_type, $status)
    {
        $builder = UserMsgModel::query();
        $builder->where('to_uid', $user_id);
        if ($msg_type) {
            $builder->whereIn('msg_type', (array)$msg_type);
        }
        if ($status) {
            $builder->whereIn('status', (array)$status);
        }
        return $builder->count();
    }


    /**
     * @param  int $to_uid
     * @param  int $type
     * @return mixed
     */
    public function getMessagesByToUidAndType($to_uid, $type)
    {
        $collect = collect();
        $builder = UserMsgModel::query();
        $builder->where('to_uid', $to_uid);
        $builder->where('msg_type', $type);
        $builder->orderBy('id', 'desc');
        $models = $builder->get();
        /** @var UserMsgModel $model */
        foreach ($models as $model) {
            $collect[] = $this->reconstituteFromModel($model);
        }
        return $collect;
    }

}