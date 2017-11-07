<?php namespace Huifang\Src\Sale\Developer\Infra\Repository;

use Huifang\Src\Foundation\Domain\Repository;
use Huifang\Src\Sale\Developer\Domain\Interfaces\DeveloperInterface;
use Huifang\Src\Sale\Developer\Domain\Model\DeveloperEntity;
use Huifang\Src\Sale\Developer\Domain\Model\DeveloperSpecification;
use Huifang\Src\Sale\Developer\Infra\Eloquent\DeveloperModel;


class DeveloperRepository extends Repository implements DeveloperInterface
{
    /**
     * Store an entity into persistence.
     *
     * @param DeveloperEntity $brand_entity
     */
    protected function store($developer_entity)
    {
        if ($developer_entity->isStored()) {
            $model = DeveloperModel::find($developer_entity->id);
        } else {
            $model = new DeveloperModel();
        }
        $model->fill(
            [
                'company_id'  => $developer_entity->company_id,
                'province_id' => $developer_entity->province_id,
                'city_id'     => $developer_entity->city_id,
                'name'        => $developer_entity->name,
            ]
        );
        $model->save();
        $developer_entity->setIdentity($model->id);
    }

    /**}
     * Reconstitute an entity from persistence.
     *
     * @param mixed $id
     * @param array $params Additional params.
     *
     * @return DeveloperModel
     */
    protected function reconstitute($id, $params = [])
    {
        $model = DeveloperModel::find($id);
        if (!isset($model)) {
            return null;
        }
        return $this->reconstituteFromModel($model);
    }


    /**
     * @param DeveloperModel $model
     *
     * @return DeveloperEntity
     */
    private function reconstituteFromModel($model)
    {
        $entity = new DeveloperEntity();
        $entity->id = $model->id;
        $entity->company_id = $model->company_id;
        $entity->province_id = $model->province_id;
        $entity->city_id = $model->city_id;
        $entity->name = $model->name;
        $entity->created_at = $model->created_at;
        $entity->updated_at = $model->updated_at;
        $entity->setIdentity($model->id);
        $entity->stored();
        return $entity;
    }

    /**
     * @param DeveloperSpecification $spec
     * @return array|\Illuminate\Support\Collection
     */
    public function getDevelopersBySpecification($spec)
    {
        $collect = collect();
        $builder = DeveloperModel::query();
        if ($spec->company_id) {
            $builder->where('company_id', $spec->company_id);
        }
        if ($spec->keyword) {
            $builder->where('name', 'like', '%' . $spec->keyword . '%');
        }
        $models = $builder->get();
        /** @var DeveloperModel $model */
        foreach ($models as $model) {
            $collect[] = $this->reconstituteFromModel($model);
        }
        return $collect;
    }

    public function getDeveloperByKeyword($keyword)
    {
        $collect = collect();
        $builder = DeveloperModel::query();
        $builder->whereRaw("LOCATE('$keyword',`name`)>0");
        $builder->limit(10);
        $models = $builder->get();
        /** @var DeveloperModel $model */
        foreach ($models as $model) {
            $collect[] = $this->reconstituteFromModel($model);
        }

        return $collect;
    }


    /**
     * 集团搜索
     * @param DeveloperSpecification $spec
     * @param int                    $per_page
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function search(DeveloperSpecification $spec, $per_page)
    {
        $builder = DeveloperModel::query();

        if ($spec->keyword) {
            $builder->where('name', 'like', '%' . $spec->keyword . '%');
        }
        if ($spec->company_id) {
            $builder->where('company_id', $spec->company_id);
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
        $builder = DeveloperModel::query();
        $builder->whereIn('id', (array)$ids);
        $models = $builder->get();
        foreach ($models as $model) {
            $model->delete();
        }
    }

}