<?php namespace Huifang\Src\Project\Infra\Repository;

use Huifang\Src\Foundation\Domain\Repository;
use Huifang\Src\Project\Domain\Interfaces\ProjectAimInterface;
use Huifang\Src\Project\Domain\Model\ProjectAimEntity;
use Huifang\Src\Project\Infra\Eloquent\ProjectAimModel;
use Huifang\Src\Project\Infra\Eloquent\ProjectAimProductModel;
use Huifang\Src\Project\Infra\Eloquent\ProjectModel;


class ProjectAimRepository extends Repository implements ProjectAimInterface
{
    /**
     * Store an entity into persistence.
     *
     * @param ProjectAimEntity $project_aim_entity
     */
    protected function store($project_aim_entity)
    {
        if ($project_aim_entity->isStored()) {
            $model = ProjectAimModel::find($project_aim_entity->id);
        } else {
            $model = new ProjectAimModel();
        }

        $model->fill(
            [
                'project_id'    => $project_aim_entity->project_id,
                'name'          => $project_aim_entity->name,
                'product_ids'   => $project_aim_entity->product_ids,
                'price'         => $project_aim_entity->price,
                'volume'        => $project_aim_entity->volume,
                'pain_analysis' => $project_aim_entity->pain_analysis,
                'other'         => $project_aim_entity->other,
            ]
        );
        $model->save();
        $this->saveProjectAimProduct($model, $project_aim_entity);
        $project_aim_entity->setIdentity($model->id);
    }


    /**
     * @param ProjectAimModel  $model
     * @param ProjectAimEntity $project_aim_entity
     */
    public function saveProjectAimProduct($model, $project_aim_entity)
    {
        if (isset($project_aim_entity->products)) {
            $project_aim_product_models = $model->project_aim_products;
            foreach ($project_aim_product_models as $project_aim_product_model) {
                $project_aim_product_model->delete();
            }
            foreach ($project_aim_entity->products as $product) {
                $project_aim_product_model = new ProjectAimProductModel();

                $project_aim_product_model->project_aim_id = $model->id;
                $project_aim_product_model->product_id = $product['product_id'];
                $project_aim_product_model->volume = $product['volume'];
                $project_aim_product_model->price = $product['price'];
                $project_aim_product_model->save();
            }
        }
    }

    /**
     * Reconstitute an entity from persistence.
     *
     * @param mixed $id
     * @param array $params Additional params.
     *
     * @return ProjectAimModel
     */
    protected function reconstitute($id, $params = [])
    {
        $model = ProjectAimModel::find($id);
        if (!isset($model)) {
            return null;
        }
        return $this->reconstituteFromModel($model);
    }

    /**
     * @param ProjectAimModel $model
     *
     * @return ProjectAimEntity
     */
    private function reconstituteFromModel($model)
    {
        $entity = new ProjectAimEntity();
        $entity->id = $model->id;

        $entity->project_id = $model->project_id;
        $entity->name = $model->name;
        $entity->product_ids = $model->product_ids;
        $entity->price = $model->price;
        $entity->volume = $model->volume;
        $entity->pain_analysis = $model->pain_analysis;
        $entity->other = $model->other;
        $entity->products = $model->project_aim_products->toArray();

        $entity->created_at = $model->created_at;
        $entity->updated_at = $model->updated_at;
        $entity->setIdentity($model->id);
        $entity->stored();
        return $entity;
    }

    /**
     * @param int $project_id
     * @return mixed
     */
    public function getProjectAimsByProjectId($project_id)
    {
        $collect = collect();
        $builder = ProjectAimModel::query();
        $builder->where('project_id', $project_id);
        $models = $builder->get();
        foreach ($models as $model) {
            $collect[] = $this->reconstituteFromModel($model);
        }
        return $collect;
    }


    public function getProjectAimsByProductId($product_id)
    {
        $collect = collect();
        $builder = ProjectAimModel::query();
        $builder->where('product_id', $product_id);
        $models = $builder->get();
        foreach ($models as $model) {
            $collect[] = $this->reconstituteFromModel($model);
        }
        return $collect;
    }

    /**
     * @param array|int $ids
     */
    public function delete($ids)
    {
        $query = ProjectAimModel::query();
        $query->whereIn('id', (array)$ids);
        $models = $query->get();
        foreach ($models as $model) {
            $model->delete();
        }
    }

}