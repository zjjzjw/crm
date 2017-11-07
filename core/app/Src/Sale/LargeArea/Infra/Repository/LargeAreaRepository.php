<?php namespace Huifang\Src\Sale\LargeArea\Infra\Repository;

use Huifang\Src\Foundation\Domain\Repository;
use Huifang\Src\Sale\LargeArea\Domain\Interfaces\LargeAreaInterface;
use Huifang\Src\Sale\LargeArea\Domain\Model\LargeAreaEntity;
use Huifang\Src\Sale\LargeArea\Domain\Model\LargeAreaSpecification;
use Huifang\Src\Sale\LargeArea\Infra\Eloquent\LargeAreaModel;


class LargeAreaRepository extends Repository implements LargeAreaInterface
{
    /**
     * Store an entity into persistence.
     *
     * @param LargeAreasEntity $largeArea_entity
     */
    protected function store($largeArea_entity)
    {
        if ($largeArea_entity->isStored()) {
            $model = LargeAreaModel::find($largeArea_entity->id);
        } else {
            $model = new LargeAreaModel();
        }
        $model->fill(
            [

                'name'       => $largeArea_entity->name,
                'company_id' => $largeArea_entity->company_id,
            ]
        );
        $model->save();
        $largeArea_entity->setIdentity($model->id);
    }

    /**}
     * Reconstitute an entity from persistence.
     *
     * @param mixed $id
     * @param array $params Additional params.
     *
     * @return LargeAreasModel
     */
    protected function reconstitute($id, $params = [])
    {
        $model = LargeAreaModel::find($id);
        if (!isset($model)) {
            return null;
        }
        return $this->reconstituteFromModel($model);
    }


    /**
     * @param LargeAreasModel $model
     *
     * @return LargeAreasEntity
     */
    private function reconstituteFromModel($model)
    {
        $entity = new LargeAreaEntity();
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
     * @param LargeAreasSpecification $spec
     * @return array|\Illuminate\Support\Collection
     */
    public function getLargeAreasBySpecification($spec)
    {
        $collect = collect();
        $builder = LargeAreaModel::query();

        if ($spec->page) {
            $builder->where('page', $spec->page);
        }
        if ($spec->keyword) {
            $builder->where('name', 'like', '%' . $spec->keyword . '%');
        }
        $models = $builder->get();
        /** @var LargeAreaModel $model */
        foreach ($models as $model) {
            $collect[] = $this->reconstituteFromModel($model);
        }
        return $collect;
    }


    /**
     * 大区搜索
     * @param LargeAreaSpecification $spec
     * @param int                    $per_page
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function search(LargeAreaSpecification $spec, $per_page)
    {
        $builder = LargeAreaModel::query();

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
        $builder = LargeAreaModel::query();
        $builder->whereIn('id', (array)$ids);
        $models = $builder->get();
        foreach ($models as $model) {
            $model->delete();
        }
    }

    public function getLargeAreaByCompanyId($company_id)
    {
        $collection = collect();
        $builder = LargeAreaModel::query();
        $builder->where('company_id', $company_id);
        $models = $builder->get();
        foreach ($models as $model) {
            $collection[] = $this->reconstituteFromModel($model);
        }
        return $collection;
    }
}