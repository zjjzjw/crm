<?php namespace Huifang\Src\Product\Infra\Repository;

use Huifang\Src\Foundation\Domain\Repository;
use Huifang\Src\Product\Domain\Interfaces\ProductInterface;
use Huifang\Src\Product\Domain\Model\ProductEntity;
use Huifang\Src\Product\Infra\Eloquent\ProductImageModel;
use Huifang\Src\Product\Infra\Eloquent\ProductModel;
use Huifang\Src\Project\Domain\Interfaces\ProjectAimInterface;
use Huifang\Src\Project\Domain\Model\ProjectAimEntity;
use Huifang\Src\Project\Infra\Eloquent\ProjectAimModel;
use Huifang\Src\Product\Domain\Model\ProductSpecification;


class ProductRepository extends Repository implements ProductInterface
{
    /**
     * Store an entity into persistence.
     *
     * @param ProductEntity $product_entity
     */
    protected function store($product_entity)
    {
        if ($product_entity->isStored()) {
            $model = ProductModel::find($product_entity->id);
        } else {
            $model = new ProductModel();
        }
        $model->fill(
            [
                'company_id'    => $product_entity->company_id,
                'category_id'   => $product_entity->category_id,
                'name'          => $product_entity->name,
                'ascription'    => $product_entity->ascription,
                'ascription_id' => $product_entity->ascription_id,
                'price'         => $product_entity->price,
                'attribfield'   => $product_entity->attribfield,
            ]
        );
        $model->save();
        $this->saveProductImages($product_entity, $model);
        $product_entity->setIdentity($model->id);
    }

    /**
     * @param ProductEntity $product_entity
     * @param ProductModel  $model
     */
    public function saveProductImages($product_entity, $model)
    {

        if (isset($product_entity->product_images)) {
            foreach ($model->product_images as $product_image_model) {
                $product_image_model->delete();
            }
            foreach ($product_entity->product_images as $image_id) {
                $product_image_model = new ProductImageModel();
                $product_image_model->product_id = $model->id;
                $product_image_model->image_id = $image_id;
                $product_image_model->save();
            }
        }
    }


    /**
     * Reconstitute an entity from persistence.
     *
     * @param mixed $id
     * @param array $params Additional params.
     *
     * @return ProductModel
     */
    protected function reconstitute($id, $params = [])
    {
        $model = ProductModel::find($id);
        if (!isset($model)) {
            return null;
        }
        return $this->reconstituteFromModel($model);
    }

    /**
     * @param ProductModel $model
     *
     * @return ProductEntity
     */
    private function reconstituteFromModel($model)
    {
        $entity = new ProductEntity();
        $entity->id = $model->id;

        $entity->company_id = $model->company_id;
        $entity->category_id = $model->category_id;
        $entity->name = $model->name;
        $entity->ascription = $model->ascription;
        $entity->ascription_id = $model->ascription_id;
        $entity->price = $model->price;
        $entity->attribfield = $model->attribfield;
        $entity->product_images = $model->product_images->pluck('image_id')->toArray();

        $entity->created_at = $model->created_at;
        $entity->updated_at = $model->updated_at;
        $entity->setIdentity($model->id);
        $entity->stored();

        return $entity;
    }


    /**
     * @param $company_id
     * @return array|\Illuminate\Support\Collection
     */
    public function getProductsByCompanyId($company_id, $ascription = null)
    {
        $collect = collect();
        $builder = ProductModel::query();
        $builder->where('company_id', $company_id);
        if ($ascription) {
            $builder->where('ascription', $ascription);
        }
        $models = $builder->get();
        foreach ($models as $model) {
            $collect[] = $this->reconstituteFromModel($model);
        }
        return $collect;

    }


    /**
     * 产品搜索
     * @param ProductSpecification $spec
     * @param                      $per_page
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function search(ProductSpecification $spec, $per_page)
    {
        $builder = ProductModel::query();
        if ($spec->keyword) {
            $builder->where('name', 'like', '%' . $spec->keyword . '%');
        }
        if ($spec->company_id) {
            $builder->where('company_id', $spec->company_id);
        }
        if ($spec->category_id) {
            $builder->where('category_id', $spec->category_id);
        }
        if ($spec->ascription) {
            $builder->where('ascription', $spec->ascription);
        }
        if ($spec->ascription_id) {
            $builder->where('ascription_id', $spec->ascription_id);
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
     * @param ProductSpecification $spec
     * @return array|\Illuminate\Support\Collection
     */
    public function getProductsBySpecification($spec)
    {
        $collect = collect();
        $builder = ProductModel::query();

        if ($spec->company_id) {
            $builder->where('company_id', $spec->company_id);
        }
        if ($spec->category_id) {
            $builder->where('category_id', $spec->category_id);
        }
        if ($spec->ascription) {
            $builder->where('ascription', $spec->ascription);
        }
        if ($spec->ascription_id) {
            $builder->where('ascription_id', $spec->ascription_id);
        }
        if ($spec->keyword) {
            $builder->where('name', 'like', '%' . $spec->keyword . '%');
        }

        $models = $builder->get();
        /** @var ProductModel $model */
        foreach ($models as $model) {
            $collect[] = $this->reconstituteFromModel($model);
        }
        return $collect;
    }

    /**
     * @param  array $ids
     * @return  mixed
     */
    public function getProductsByIds($ids)
    {
        $collect = collect();
        $builder = ProductModel::query();
        $builder->whereIn('id', (array)$ids);
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
        $builder = ProductModel::query();
        $builder->whereIn('id', (array)$ids);
        $models = $builder->get();
        foreach ($models as $model) {
            $model->delete();
        }
    }

}