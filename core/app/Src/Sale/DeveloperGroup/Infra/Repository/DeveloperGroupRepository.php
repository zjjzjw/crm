<?php namespace Huifang\Src\Sale\DeveloperGroup\Infra\Repository;

use Huifang\Src\Foundation\Domain\Repository;
use Huifang\Src\Sale\DeveloperGroup\Domain\Interfaces\DeveloperGroupInterface;
use Huifang\Src\Sale\DeveloperGroup\Domain\Model\DeveloperGroupEntity;
use Huifang\Src\Sale\DeveloperGroup\Domain\Model\DeveloperGroupSpecification;
use Huifang\Src\Sale\DeveloperGroup\Infra\Eloquent\DeveloperGroupModel;


class DeveloperGroupRepository extends Repository implements DeveloperGroupInterface
{
    /**
     * Store an entity into persistence.
     *
     * @param DeveloperGroupEntity $developer_group_entity
     */
    protected function store($developer_group_entity)
    {
        if ($developer_group_entity->isStored()) {
            $model = DeveloperGroupModel::find($developer_group_entity->id);
        } else {
            $model = new DeveloperGroupModel();
        }
        $model->fill(
            [
                'company_id'         => $developer_group_entity->company_id,
                'company_id' => $developer_group_entity->company_id,
                'name'       => $developer_group_entity->name,

            ]
        );
        $model->save();
        $developer_group_entity->setIdentity($model->id);
    }

    /**}
     * Reconstitute an entity from persistence.
     *
     * @param mixed $id
     * @param array $params Additional params.
     *
     * @return DeveloperGroupModel
     */
    protected function reconstitute($id, $params = [])
    {
        /** @var DeveloperGroupModel $model */
        $model = DeveloperGroupModel::find($id);
        if (!isset($model)) {
            return null;
        }
        return $this->reconstituteFromModel($model);
    }

    public function getDeveloperGroupByKeyword($keyword)
    {
        $collect = collect();
        $builder = DeveloperGroupModel::query();
        $builder->whereRaw("LOCATE('$keyword',`name`)>0");
        $builder->limit(10);
        $models = $builder->get();
        /** @var DeveloperGroupModel $model */
        foreach ($models as $model) {
            $collect[] = $this->reconstituteFromModel($model);
        }

        return $collect;
    }

    /**
     * @param DeveloperGroupModel $model
     *
     * @return DeveloperGroupEntity
     */
    private function reconstituteFromModel($model)
    {
        $entity = new DeveloperGroupEntity();

        $entity->id = $model->id;
        $entity->name = $model->name;
        $entity->company_id = $model->company_id;
        $entity->created_at = $model->created_at;
        $entity->updated_at = $model->updated_at;
        $entity->setIdentity($model->id);
        $entity->stored();
        return $entity;
    }

    /**
     * @param DeveloperGroupSpecification $spec
     * @return array|\Illuminate\Support\Collection
     */
    public function getDeveloperGroupsBySpecification($spec)
    {
        $collect = collect();
        $builder = DeveloperGroupModel::query();
        if ($spec->company_id) {
            $builder->where('company_id', $spec->company_id);
        }
        if ($spec->keyword) {
            $builder->where('name', 'like', '%' . $spec->keyword . '%');
        }
        $models = $builder->get();
        /** @var DeveloperGroupModel $model */
        foreach ($models as $model) {
            $collect[] = $this->reconstituteFromModel($model);
        }
        return $collect;
    }


    /**
     * 集团搜索
     * @param DeveloperGroupSpecification $spec
     * @param int                         $per_page
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function search(DeveloperGroupSpecification $spec, $per_page)
    {
        $builder = DeveloperGroupModel::query();

        if ($spec->company_id) {
            $builder->where('company_id', $spec->company_id);
        }

        if ($spec->keyword) {
            $builder->where('name', 'like', '%' . $spec->keyword . '%');
        }

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
     * @param int|array $ids
     */
    public function delete($ids)
    {
        $builder = DeveloperGroupModel::query();
        $builder->where('id',$ids);
        $models = $builder->delete();

    }

}