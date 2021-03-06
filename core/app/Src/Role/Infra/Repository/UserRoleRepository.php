<?php namespace Huifang\Src\Role\Infra\Repository;

use Huifang\Src\Foundation\Domain\Repository;
use Huifang\Src\Role\Domain\Interfaces\UserRoleInterface;
use Huifang\Src\Role\Domain\Model\UserRoleEntity;
use Huifang\Src\Role\Infra\Eloquent\UserRoleModel;


class UserRoleRepository extends Repository implements UserRoleInterface
{
    /**
     * Store an entity into persistence.
     *
     * @param UserRoleEntity $user_role_entity
     */
    protected function store($user_role_entity)
    {
        if ($user_role_entity->isStored()) {
            $model = UserRoleModel::find($user_role_entity->id);
        } else {
            $model = new UserRoleModel();
        }
        $model->fill(
            [
                'user_id' => $user_role_entity->user_id,
                'role_id' => $user_role_entity->role_id,
            ]
        );
        $model->save();
        $user_role_entity->setIdentity($model->id);
    }

    /**
     * Reconstitute an entity from persistence.
     *
     * @param mixed $id
     * @param array $params Additional params.
     *
     * @return \Huifang\Src\Role\Domain\Model\UserRoleEntity
     */
    protected function reconstitute($id, $params = [])
    {
        $model = UserRoleModel::find($id);
        if (!isset($model)) {
            return null;
        }
        return $this->reconstituteFromModel($model);
    }

    /**
     * @param $model
     * @return \Huifang\Src\Role\Domain\Model\UserRoleEntity
     */
    private function reconstituteFromModel($model)
    {
        $entity = new UserRoleEntity();
        $entity->id = $model->id;
        $entity->user_id = $model->user_id;
        $entity->role_id = $model->role_id;
        $entity->setIdentity($model->id);
        $entity->stored();
        return $entity;
    }


    /**
     * @param int $role_id
     * @return array|\Illuminate\Support\Collection
     */
    public function getUserRoleByRoleId($role_id)
    {
        $collect = collect();
        $builder = UserRoleModel::query();
        $builder->where('role_id', $role_id);
        $models = $builder->get();
        foreach ($models as $model) {
            $collect[] = $this->reconstituteFromModel($model);
        }
        return $collect;
    }


}