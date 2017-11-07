<?php namespace Huifang\Src\Project\Infra\Repository;

use Huifang\Src\Foundation\Domain\Repository;
use Huifang\Src\Project\Domain\Interfaces\ProjectAimHinderInterface;
use Huifang\Src\Project\Domain\Model\ProjectAimHinderEntity;
use Huifang\Src\Project\Domain\Model\ProjectAimHinderSpecification;
use Huifang\Src\Project\Infra\Eloquent\ProjectAimHinderModel;


class ProjectAimHinderRepository extends Repository implements ProjectAimHinderInterface
{
    /**
     * Store an entity into persistence.
     *
     * @param ProjectAimHinderEntity $project_aim_hinder_entity
     */
    protected function store($project_aim_hinder_entity)
    {
        if ($project_aim_hinder_entity->isStored()) {
            $model = ProjectAimHinderModel::find($project_aim_hinder_entity->id);
        } else {
            $model = new ProjectAimHinderModel();
        }

        $model->fill(
            [
                'project_id'           => $project_aim_hinder_entity->project_id,
                'aim_id'               => $project_aim_hinder_entity->aim_id,
                'hinder_name'          => $project_aim_hinder_entity->hinder_name,
                'implementation_plan'  => $project_aim_hinder_entity->implementation_plan,
                'project_purchase_id'  => $project_aim_hinder_entity->project_purchase_id,
                'feedback'             => $project_aim_hinder_entity->feedback,
                'resource_application' => $project_aim_hinder_entity->resource_application,
                'status'               => $project_aim_hinder_entity->status,
                'executed_at'          => $project_aim_hinder_entity->executed_at,

            ]
        );
        $model->save();
        $project_aim_hinder_entity->setIdentity($model->id);
    }


    /**
     * Reconstitute an entity from persistence.
     *
     * @param mixed $id
     * @param array $params Additional params.
     *
     * @return ProjectAimHinderModel
     */
    protected function reconstitute($id, $params = [])
    {
        $model = ProjectAimHinderModel::find($id);
        if (!isset($model)) {
            return null;
        }
        return $this->reconstituteFromModel($model);
    }

    /**
     * @param ProjectAimHinderModel $model
     *
     * @return ProjectAimHinderEntity
     */
    private function reconstituteFromModel($model)
    {
        $entity = new ProjectAimHinderEntity();
        $entity->id = $model->id;

        $entity->project_id = $model->project_id;
        $entity->aim_id = $model->aim_id;
        $entity->feedback = $model->feedback;
        $entity->hinder_name = $model->hinder_name;
        $entity->implementation_plan = $model->implementation_plan;
        $entity->project_purchase_id = $model->project_purchase_id;
        $entity->executed_at = $model->executed_at;
        $entity->status = $model->status;
        $entity->resource_application = $model->resource_application;

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
    public function getProjectAimHindersByProjectIdAndAimId($project_id, $aim_id)
    {
        $collect = collect();
        $builder = ProjectAimHinderModel::query();
        if ($project_id) {
            $builder->where('project_id', $project_id);
        }
        if ($aim_id) {
            $builder->where('aim_id', $aim_id);
        }
        $models = $builder->get();
        foreach ($models as $model) {
            $collect[] = $this->reconstituteFromModel($model);
        }
        return $collect;
    }

    /**
     * @param int    $project_purchase_id 采购ID
     * @param string $column
     * @param string $sort
     * @return array|\Illuminate\Support\Collection
     */
    public function getProjectAimHindersByProjectPurchaseId($project_purchase_id, $column = '', $sort = '')
    {
        $collect = collect();
        $builder = ProjectAimHinderModel::query();
        $builder->where('project_purchase_id', $project_purchase_id);
        if ($column && $sort) {
            $builder->orderBy($column, $sort);
        }
        $models = $builder->get();
        foreach ($models as $model) {
            $collect[] = $this->reconstituteFromModel($model);
        }
        return $collect;
    }

    /**
     * @param  array|int $ids
     */
    public function delete($ids)
    {
        $builder = ProjectAimHinderModel::query();
        $builder->whereIn('id', (array)$ids);
        $models = $builder->get();
        foreach ($models as $model) {
            $model->delete();
        }
    }

    /**
     * @param    ProjectAimHinderSpecification $spec
     * @return array|\Illuminate\Support\Collection
     */
    public function getHindersBySpecification($spec)
    {
        $collect = collect();
        $builder = ProjectAimHinderModel::query();

        if (isset($spec->project_ids)) {
            $builder->whereIn('project_id', (array)$spec->project_ids);
        }
        if ($spec->status) {
            $builder->whereIn('status', (array)$spec->status);
        }

        if ($spec->column && $spec->sort) {
            $builder->orderBy($spec->column, $spec->sort);
        }

        $models = $builder->get();
        /** @var ProjectAimHinderModel $model */
        foreach ($models as $model) {
            $collect[] = $this->reconstituteFromModel($model);
        }
        return $collect;
    }


    /**
     * @param ProjectAimHinderSpecification $spec
     * @param int                           $per_page
     * @return mixed
     */
    public function search($spec, $per_page)
    {
        $builder = ProjectAimHinderModel::query();
        if (isset($spec->project_ids)) {
            $builder->whereIn('project_id', (array)$spec->project_ids);
        }
        if ($spec->status) {
            $builder->whereIn('status', (array)$spec->status);
        }

        if ($spec->column && $spec->sort) {
            $builder->orderBy($spec->column, $spec->sort);
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


}