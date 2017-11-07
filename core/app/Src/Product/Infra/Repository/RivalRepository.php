<?php namespace Huifang\Src\Product\Infra\Repository;

use Huifang\Src\Foundation\Domain\Repository;
use Huifang\Src\Product\Domain\Interfaces\RivalInterface;
use Huifang\Src\Product\Domain\Model\RivalEntity;
use Huifang\Src\Product\Domain\Model\RivalSpecification;
use Huifang\Src\Product\Infra\Eloquent\RivalModel;


class RivalRepository extends Repository implements RivalInterface
{
    /**
     * Store an entity into persistence.
     *
     * @param RivalEntity $rival_entity
     */
    protected function store($rival_entity)
    {
        if ($rival_entity->isStored()) {
            $model = RivalModel::find($rival_entity->id);
        } else {
            $model = new RivalModel();
        }

        $model->fill(
            [
                'company_id' => $rival_entity->company_id,
                'name'       => $rival_entity->name,
            ]
        );
        $model->save();
        $rival_entity->setIdentity($model->id);
    }

    /**}
     * Reconstitute an entity from persistence.
     *
     * @param mixed $id
     * @param array $params Additional params.
     *
     * @return RivalModel
     */
    protected function reconstitute($id, $params = [])
    {
        $model = RivalModel::find($id);
        if (!isset($model)) {
            return null;
        }
        return $this->reconstituteFromModel($model);
    }

    /**
     * @param RivalModel $model
     *
     * @return RivalEntity
     */
    private function reconstituteFromModel($model)
    {
        $entity = new RivalEntity();
        $entity->id = $model->id;

        $entity->company_id = $model->company_id;
        $entity->name = $model->name;

        $entity->created_at = $model->created_at;
        $entity->updated_at = $model->updated_at;
        $entity->setIdentity($model->id);
        $entity->stored();
        return $entity;
    }

    /**
     * @param int $company_id
     * @return array|\Illuminate\Support\Collection
     */
    public function getRivalsByCompanyId($company_id)
    {
        $collect = collect();
        $builder = RivalModel::query();
        $builder->where('company_id', $company_id);
        $models = $builder->get();
        foreach ($models as $model) {
            $collect[] = $this->reconstituteFromModel($model);
        }
        return $collect;
    }


    /**
     * 竞品公司搜索
     * @param RivalSpecification $spec
     * @param int                $per_page
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function search(RivalSpecification $spec, $per_page)
    {
        $builder = RivalModel::query();
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
        $builder = RivalModel::query();
        $builder->whereIn('id', (array)$ids);
        $models = $builder->get();
        foreach ($models as $model) {
            $model->delete();
        }
    }

}