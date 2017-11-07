<?php namespace Huifang\Src\Sale\Brand\Infra\Repository;

use Huifang\Src\Foundation\Domain\Repository;
use Huifang\Src\Sale\Brand\Domain\Interfaces\BrandInterface;
use Huifang\Src\Sale\Brand\Domain\Model\BrandEntity;
use Huifang\Src\Sale\Brand\Domain\Model\BrandSpecification;
use Huifang\Src\Sale\Brand\Infra\Eloquent\BrandModel;


class BrandRepository extends Repository implements BrandInterface
{
    /**
     * Store an entity into persistence.
     *
     * @param BrandEntity $brand_entity
     */
    protected function store($brand_entity)
    {
        if ($brand_entity->isStored()) {
            $model = BrandModel::find($brand_entity->id);
        } else {
            $model = new BrandModel();
        }
        $model->fill(
            [
                'company_id'   => $brand_entity->company_id,
                'company_name' => $brand_entity->company_name,
                'brand_name'   => $brand_entity->brand_name,
            ]
        );
        $model->save();
        $brand_entity->setIdentity($model->id);
    }

    /**}
     * Reconstitute an entity from persistence.
     *
     * @param mixed $id
     * @param array $params Additional params.
     *
     * @return BrandModel
     */
    protected function reconstitute($id, $params = [])
    {
        $model = BrandModel::find($id);
        if (!isset($model)) {
            return null;
        }
        return $this->reconstituteFromModel($model);
    }


    public function getBrandListByBrandName($brand_name)
    {
        $collection = collect();
        $builder = BrandModel::query();
        $builder->whereRaw("LOCATE('$brand_name',`brand_name`)>0");
        $models = $builder->get();
        foreach ($models as $model) {
            $collection[] = $this->reconstituteFromModel($model);
        }
        return $collection;
    }


    /**
     * @param BrandModel $model
     *
     * @return BrandEntity
     */
    private function reconstituteFromModel($model)
    {
        $entity = new BrandEntity();
        $entity->id = $model->id;
        $entity->company_name = $model->company_name;
        $entity->brand_name = $model->brand_name;
        $entity->company_id = $model->company_id;
        $entity->created_at = $model->created_at;
        $entity->updated_at = $model->updated_at;
        $entity->setIdentity($model->id);
        $entity->stored();
        return $entity;
    }

    /**
     * @param BrandSpecification $spec
     * @return array|\Illuminate\Support\Collection
     */
    public function getBrandsBySpecification($spec)
    {
        $collect = collect();
        $builder = BrandModel::query();

        if ($spec->company_id) {
            $builder->where('company_id', $spec->company_id);
        }
        if ($spec->page) {
            $builder->where('page', $spec->page);
        }

        if ($spec->keyword) {
            $builder->where('name', 'like', '%' . $spec->keyword . '%');
        }
        $models = $builder->get();

        /** @var BrandModel $model */
        foreach ($models as $model) {
            $collect[] = $this->reconstituteFromModel($model);
        }
        return $collect;
    }


    /**
     * 品牌搜索
     * @param BrandSpecification $spec
     * @param int                $per_page
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function search(BrandSpecification $spec, $per_page)
    {
        $builder = BrandModel::query();
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
        $builder = BrandModel::query();
        $builder->whereIn('id', (array)$ids);
        $models = $builder->get();
        foreach ($models as $model) {
            $model->delete();
        }
    }

}