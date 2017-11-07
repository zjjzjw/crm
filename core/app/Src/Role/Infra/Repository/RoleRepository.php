<?php namespace Huifang\Src\Role\Infra\Repository;

use Huifang\Src\Role\Domain\Interfaces\RoleInterface;
use Huifang\Src\Foundation\Domain\Repository;
use Huifang\Src\Role\Domain\Model\RoleEntity;
use Huifang\Src\Role\Domain\Model\RoleSpecification;
use Huifang\Src\Role\Infra\Eloquent\RoleModel;


class RoleRepository extends Repository implements RoleInterface
{
    /**
     * Store an entity into persistence.
     *
     * @param RoleEntity $role_entity
     */
    protected function store($role_entity)
    {
        if ($role_entity->isStored()) {
            $model = RoleModel::find($role_entity->id);
        } else {
            $model = new RoleModel();
        }
        $model->fill(
            [
                'company_id' => $role_entity->company_id,
                'name'       => $role_entity->name,
                'desc'       => $role_entity->desc,
            ]
        );
        $model->save();
        if (isset($role_entity->permissions)) {
            $model->permissions()->sync($role_entity->permissions);
        }
        $role_entity->setIdentity($model->id);
    }

    /**
     * Reconstitute an entity from persistence.
     *
     * @param mixed $id
     * @param array $params Additional params.
     *
     * @return RoleEntity
     */
    protected function reconstitute($id, $params = [])
    {
        $model = RoleModel::find($id);
        if (!isset($model)) {
            return null;
        }
        return $this->reconstituteFromModel($model);
    }

    /**
     * @param RoleModel $model
     *
     * @return RoleEntity
     */
    private function reconstituteFromModel($model)
    {
        $entity = new RoleEntity();
        $entity->id = $model->id;
        $entity->company_id = $model->company_id;
        $entity->name = $model->name;
        $entity->desc = $model->desc;
        $entity->permissions = $model->permissions->pluck('id')->toArray();
        $entity->created_at = $model->created_at;
        $entity->updated_at = $model->updated_at;
        $entity->setIdentity($model->id);
        $entity->stored();
        return $entity;
    }

    /**
     * @param RoleSpecification $spec
     * @param int               $per_page
     * @return mixed
     */
    public function search(RoleSpecification $spec, $per_page = 10)
    {
        $builder = RoleModel::query();
        if ($spec->keyword) {
            $builder->where('name', 'like', '%' . $spec->keyword . '%');
        }

        if ($spec->company_id) {
            $builder->where('company_id', $spec->company_id);
        }

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

    /**
     * @param $company_id
     * @return array|\Illuminate\Support\Collection
     */
    public function getRoleByCompanyId($company_id)
    {
        $collect = collect();
        $builder = RoleModel::query();
        $builder->where(['company_id' => $company_id]);
        $models = $builder->get();
        foreach ($models as $model) {
            $collect[] = $this->reconstituteFromModel($model);
        }
        return $collect;
    }

    /**
     * @param int|array $ids
     */
    public function delete($ids)
    {
        $builder = RoleModel::query();
        $builder->whereIn('id', (array)$ids);
        $models = $builder->get();
        foreach ($models as $model) {
            $model->delete();
        }
    }


}