<?php namespace Huifang\Src\Project\Infra\Repository;

use Huifang\Src\Foundation\Domain\Repository;
use Huifang\Src\Project\Domain\Interfaces\ProjectAnalyseInterface;
use Huifang\Src\Project\Domain\Model\ProjectAnalyseEntity;
use Huifang\Src\Project\Domain\Model\ProjectFileEntity;
use Huifang\Src\Project\Infra\Eloquent\ProjectAnalyseModel;
use Huifang\Src\Project\Infra\Eloquent\ProjectFileModel;


class ProjectAnalyseRepository extends Repository implements ProjectAnalyseInterface
{
    /**
     * Store an entity into persistence.
     *
     * @param ProjectAnalyseEntity $project_analyse_entity
     */
    protected function store($project_analyse_entity)
    {
        if ($project_analyse_entity->isStored()) {
            $model = ProjectAnalyseModel::find($project_analyse_entity->id);
        } else {
            $model = new ProjectAnalyseModel();
        }

        $model->fill(
            [
                'project_id'   => $project_analyse_entity->project_id,
                'event_desc'   => $project_analyse_entity->event_desc,
                'analyse_type' => $project_analyse_entity->analyse_type,
                'swot_type'    => $project_analyse_entity->swot_type,
            ]
        );
        $model->save();
        $project_analyse_entity->setIdentity($model->id);
    }


    /**
     * Reconstitute an entity from persistence.
     *
     * @param mixed $id
     * @param array $params Additional params.
     *
     * @return ProjectAnalyseModel
     */
    protected function reconstitute($id, $params = [])
    {
        $model = ProjectAnalyseModel::find($id);
        if (!isset($model)) {
            return null;
        }
        return $this->reconstituteFromModel($model);
    }

    /**
     * @param ProjectAnalyseModel $model
     *
     * @return ProjectAnalyseEntity
     */
    private function reconstituteFromModel($model)
    {
        $entity = new ProjectAnalyseEntity();
        $entity->id = $model->id;
        $entity->project_id = $model->project_id;
        $entity->event_desc = $model->event_desc;
        $entity->analyse_type = $model->analyse_type;
        $entity->swot_type = $model->swot_type;
        $entity->created_at = $model->created_at;
        $entity->updated_at = $model->updated_at;
        $entity->setIdentity($model->id);
        $entity->stored();
        return $entity;
    }

    /**
     * @param int $project_id
     * @param int $analyse_type
     * @return array|\Illuminate\Support\Collection
     */
    public function getProjectAnalyseByProjectIdAndType($project_id, $analyse_type)
    {
        $collect = collect();
        $builder = ProjectAnalyseModel::query();
        if ($project_id) {
            $builder->where('project_id', $project_id);
        }
        if ($analyse_type) {
            $builder->where('analyse_type', $analyse_type);
        }
        $models = $builder->get();
        /** @var ProjectAnalyseModel $model */
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
        $builder = ProjectAnalyseModel::query();
        $builder->whereIn('id', (array)$ids);
        $models = $builder->get();
        foreach ($models as $model) {
            $model->delete();
        }
    }

}