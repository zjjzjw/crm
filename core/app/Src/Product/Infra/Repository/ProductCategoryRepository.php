<?php namespace Huifang\Src\Product\Infra\Repository;

use Huifang\Src\Foundation\Domain\Repository;
use Huifang\Src\Product\Domain\Interfaces\ProductCategoryInterface;
use Huifang\Src\Product\Domain\Model\ProductCategoryEntity;
use Huifang\Src\Product\Domain\Model\ProductCategorySpecification;
use Huifang\Src\Product\Infra\Eloquent\ProductCategoryModel;
use Huifang\Src\Product\Infra\Eloquent\ProductModel;


class ProductCategoryRepository extends Repository implements ProductCategoryInterface
{
    /**
     * Store an entity into persistence.
     *
     * @param ProductCategoryEntity $product_category_entity
     */
    protected function store($product_category_entity)
    {
        if ($product_category_entity->isStored()) {
            $model = ProductCategoryModel::find($product_category_entity->id);
        } else {
            $model = new ProductCategoryModel();
        }
        $model->fill(
            [
                'company_id' => $product_category_entity->company_id,
                'name'       => $product_category_entity->name,
            ]
        );
        $model->save();
        $product_category_entity->setIdentity($model->id);
    }


    /**
     * Reconstitute an entity from persistence.
     *
     * @param mixed $id
     * @param array $params Additional params.
     *
     * @return ProductCategoryModel
     */
    protected function reconstitute($id, $params = [])
    {
        $model = ProductCategoryModel::find($id);
        if (!isset($model)) {
            return null;
        }
        return $this->reconstituteFromModel($model);
    }

    /**
     * @param ProductCategoryModel $model
     *
     * @return ProductCategoryEntity
     */
    private function reconstituteFromModel($model)
    {
        $entity = new ProductCategoryEntity();
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
     * 产品搜索
     * @param ProductCategorySpecification $spec
     * @param                              $per_page
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function search(ProductCategorySpecification $spec, $per_page)
    {
        $query = ProductCategoryModel::query();
        if ($spec->company_id) {
            $query->where('company_id', $spec->company_id);
        }
        if ($spec->keyword) {
            $query->where('name', 'like', '%' . $spec->keyword . '%');
        }
        if ($spec->page) {
            $paginator = $query->paginate($per_page, ['*'], 'page', $spec->page);
        } else {
            $paginator = $query->paginate($per_page);
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
    public function getProductCategoriesByCompanyId($company_id)
    {
        $collect = collect();
        $builder = ProductCategoryModel::query();
        $builder->where('company_id', $company_id);
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
        $builder = ProductCategoryModel::query();
        $builder->whereIn('id', (array)$ids);
        $models = $builder->get();
        foreach ($models as $model) {
            $model->delete();
        }
    }

}