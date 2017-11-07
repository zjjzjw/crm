<?php namespace Huifang\Src\Contract\Infra\Repository;

use Huifang\Src\Contract\Domain\Interfaces\SignTaskInterface;
use Huifang\Src\Contract\Domain\Model\SignTaskEntity;
use Huifang\Src\Contract\Infra\Eloquent\SignTaskModel;
use Huifang\Src\Foundation\Domain\Repository;


class SignTaskRepository extends Repository implements SignTaskInterface
{
    /**
     * Store an entity into persistence.
     *
     * @param SignTaskEntity $sign_task_entity
     */
    protected function store($sign_task_entity)
    {
        if ($sign_task_entity->isStored()) {
            $model = SignTaskModel::find($sign_task_entity->id);
        } else {
            $model = new SignTaskModel();
        }
        $model->fill(
            [
                'user_id' => $sign_task_entity->user_id,
                'month'   => $sign_task_entity->month,
                'amount'  => $sign_task_entity->amount,
            ]
        );
        $model->save();
        $sign_task_entity->setIdentity($model->id);
    }

    /**
     * @param SignTaskModel $model
     *
     * @return SignTaskEntity
     */
    private function reconstituteFromModel($model)
    {
        $entity = new SignTaskEntity();
        $entity->id = $model->id;

        $entity->user_id = $model->user_id;
        $entity->month = $model->month;
        $entity->amount = $model->amount;

        $entity->created_at = $model->created_at;
        $entity->updated_at = $model->updated_at;
        $entity->setIdentity($model->id);
        $entity->stored();

        return $entity;
    }

    /**
     * Reconstitute an entity from persistence.
     *
     * @param mixed $id
     * @param array $params Additional params.
     *
     * @return SignTaskEntity
     */
    protected function reconstitute($id, $params = [])
    {
        $model = SignTaskModel::find($id);
        if (!isset($model)) {
            return null;
        }
        return $this->reconstituteFromModel($model);
    }

    /**
     * @param int|array $ids
     */
    public function delete($ids)
    {
        $builder = SignTaskModel::query();
        $builder->whereIn('id', (array)$ids);
        $models = $builder->get();
        foreach ($models as $model) {
            $model->delete();
        }
    }

    /**
     * @param $user_id
     * @return array|\Illuminate\Support\Collection
     */
    public function getSignTasksByUserId($user_id)
    {
        $collect = collect();
        $builder = SignTaskModel::query();
        $builder->where('user_id', $user_id);
        $builder->orderBy('month', 'asc');
        $models = $builder->get();
        /** @var SignTaskModel $model */
        foreach ($models as $model) {
            $collect[] = $this->reconstituteFromModel($model);
        }
        return $collect;
    }


    /**
     * @param int|array $user_id
     * @param int       $month
     * @return SignTaskEntity|null
     */
    public function getSignTasksByUserIdAndMonth($user_id, $month)
    {
        $collect = collect();
        $builder = SignTaskModel::query();
        $builder->whereIn('user_id', (array)$user_id);
        $builder->where('month', $month);
        $builder->orderBy('month', 'asc');
        $models = $builder->get();
        /** @var SignTaskModel $model */
        foreach ($models as $model) {
            $collect[] = $this->reconstituteFromModel($model);
        }
        return $collect;
    }


}