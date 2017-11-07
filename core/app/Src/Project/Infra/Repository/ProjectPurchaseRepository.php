<?php namespace Huifang\Src\Project\Infra\Repository;

use Huifang\Src\Foundation\Domain\Repository;
use Huifang\Src\Project\Domain\Interfaces\ProjectPurchaseInterface;
use Huifang\Src\Project\Domain\Model\ProjectPurchaseEntity;
use Huifang\Src\Project\Domain\Model\ProjectStructureEntity;
use Huifang\Src\Project\Infra\Eloquent\ProjectPurchaseModel;
use Huifang\Src\Project\Infra\Eloquent\ProjectStructureModel;


class ProjectPurchaseRepository extends Repository implements ProjectPurchaseInterface
{
    /**
     * Store an entity into persistence.
     *
     * @param ProjectPurchaseEntity $project_purchase_entity
     */
    protected function store($project_purchase_entity)
    {
        if ($project_purchase_entity->isStored()) {
            $model = ProjectPurchaseModel::find($project_purchase_entity->id);
        } else {
            $model = new ProjectPurchaseModel();
        }

        $model->fill(
            [
                'name'       => $project_purchase_entity->name,
                'project_id' => $project_purchase_entity->project_id,
                'personnel'  => $project_purchase_entity->personnel,
                'timed_at'   => $project_purchase_entity->timed_at,
                'event_desc' => $project_purchase_entity->event_desc,
            ]
        );
        $model->save();
        $project_purchase_entity->setIdentity($model->id);
    }


    /**
     * Reconstitute an entity from persistence.
     *
     * @param mixed $id
     * @param array $params Additional params.
     *
     * @return ProjectPurchaseModel
     */
    protected function reconstitute($id, $params = [])
    {
        $model = ProjectPurchaseModel::find($id);
        if (!isset($model)) {
            return null;
        }
        return $this->reconstituteFromModel($model);
    }

    /**
     * @param ProjectPurchaseModel $model
     *
     * @return ProjectPurchaseEntity
     */
    private function reconstituteFromModel($model)
    {
        $entity = new ProjectPurchaseEntity();
        $entity->id = $model->id;

        $entity->project_id = $model->project_id;
        $entity->event_desc = $model->event_desc;
        $entity->name = $model->name;
        $entity->personnel = $model->personnel;
        $entity->timed_at = $model->timed_at;

        $entity->created_at = $model->created_at;
        $entity->updated_at = $model->updated_at;
        $entity->setIdentity($model->id);
        $entity->stored();
        return $entity;
    }

    /**
     * @param int    $project_id
     * @param string $column
     * @param string $sort
     * @return array
     */
    public function getProjectPurchaseByProjectId($project_id, $column = '', $sort = '')
    {
        $collect = collect();
        $builder = ProjectPurchaseModel::query();
        if ($project_id) {
            $builder->where('project_id', $project_id);
        }
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
     * @param  int|array $ids
     */
    public function delete($ids)
    {
        $builder = ProjectPurchaseModel::query();
        $builder->whereIn('id', (array)$ids);
        $models = $builder->get();
        foreach ($models as $model) {
            $model->delete();
        }
    }

}