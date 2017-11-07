<?php namespace Huifang\Src\Role\Infra\Repository;

use Huifang\Src\Role\Domain\Model\DepartEntity;
use Huifang\Src\Foundation\Domain\Repository;
use Huifang\Src\Role\Domain\Interfaces\DepartInterface;
use Huifang\Src\Role\Domain\Model\DepartSpecification;
use Huifang\Src\Role\Infra\Eloquent\DepartModel;


class DepartRepository extends Repository implements DepartInterface
{
    /**
     * Store an entity into persistence.
     *
     * @param DepartEntity $depart_entity
     */
    protected function store($depart_entity)
    {
        if ($depart_entity->isStored()) {
            $model = DepartModel::find($depart_entity->id);
        } else {
            $model = new DepartModel();
        }
        $model->fill(
            [
                'company_id' => $depart_entity->company_id,
                'parent_id'  => $depart_entity->parent_id,
                'name'       => $depart_entity->name,
                'desc'       => $depart_entity->desc,
            ]
        );
        $model->save();
        $depart_entity->setIdentity($model->id);
    }

    /**
     * Reconstitute an entity from persistence.
     *
     * @param mixed $id
     * @param array $params Additional params.
     *
     * @return DepartEntity
     */
    protected function reconstitute($id, $params = [])
    {
        $model = DepartModel::find($id);
        if (!isset($model)) {
            return null;
        }
        return $this->reconstituteFromModel($model);
    }

    /**
     * @param DepartModel $model
     *
     * @return DepartEntity
     */
    private function reconstituteFromModel($model)
    {
        $entity = new DepartEntity();
        $entity->id = $model->id;
        $entity->company_id = $model->company_id;
        $entity->parent_id = $model->parent_id;
        $entity->name = $model->name;
        $entity->desc = $model->desc;
        $entity->users = $model->users->pluck('id')->toArray();
        $entity->created_at = $model->created_at;
        $entity->updated_at = $model->updated_at;
        $entity->setIdentity($model->id);
        $entity->stored();
        return $entity;
    }

    /**
     * @param DepartSpecification $spec
     * @param int                 $per_page
     * @return mixed
     */
    public function search(DepartSpecification $spec, $per_page = 10)
    {
        $builder = DepartModel::query();
        if ($spec->keyword) {
            $builder->where('name', 'like', '%' . $spec->keyword . '%');
        }
        if ($spec->company_id) {
            $builder->where('company_id', $spec->company_id);
        }

        if (isset($spec->parent_id)) {
            $builder->where('parent_id', $spec->parent_id);
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
     * 获取所有部门
     * @param $company_id
     * @return array|\Illuminate\Support\Collection
     */
    public function getDepartByCompanyId($company_id)
    {
        $collect = collect();
        $query = DepartModel::query();
        $query->where(['company_id' => $company_id]);
        $models = $query->get();
        foreach ($models as $model) {
            $collect[] = $this->reconstituteFromModel($model);
        }
        return $collect;
    }

    public function getDepartByCompanyIdAndParentId($company_id, $parent_id)
    {
        $collect = collect();
        $query = DepartModel::query();
        $query->where('company_id', $company_id);
        $query->where('parent_id', $parent_id);
        $models = $query->get();
        foreach ($models as $model) {
            $collect[] = $this->reconstituteFromModel($model);
        }
        return $collect;
    }

    /**
     * 获取子类
     * @param $parent_id
     * @return array|\Illuminate\Support\Collection
     */
    public function getDepartByParentId($parent_id)
    {
        $collect = collect();
        $query = DepartModel::query();
        $query->where('parent_id', $parent_id);
        $models = $query->get();
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
        $builder = DepartModel::query();
        $builder->whereIn('id', (array)$ids);
        $models = $builder->get();
        foreach ($models as $model) {
            $model->delete();
        }
    }
}