<?php namespace Huifang\Src\Project\Infra\Repository;

use Huifang\Src\Foundation\Domain\Repository;
use Huifang\Src\Project\Domain\Interfaces\ProjectStructureInterface;
use Huifang\Src\Project\Domain\Model\ProjectAnalyseEntity;
use Huifang\Src\Project\Domain\Model\ProjectStructureEntity;
use Huifang\Src\Project\Infra\Eloquent\ProjectStructureModel;


class ProjectStructureRepository extends Repository implements ProjectStructureInterface
{
    /**
     * Store an entity into persistence.
     *
     * @param ProjectStructureEntity $project_structure_entity
     */
    protected function store($project_structure_entity)
    {
        if ($project_structure_entity->isStored()) {
            $model = ProjectStructureModel::find($project_structure_entity->id);
        } else {
            $model = new ProjectStructureModel();
        }

        $model->fill(
            [
                'parent_id'          => $project_structure_entity->parent_id,
                'project_id'         => $project_structure_entity->project_id,
                'name'               => $project_structure_entity->name,
                'position_name'      => $project_structure_entity->position_name,
                'contact_phone'      => $project_structure_entity->contact_phone,
                'structure_role_id'  => $project_structure_entity->structure_role_id,
                'current_related_id' => $project_structure_entity->current_related_id,
                'character'          => $project_structure_entity->character,
                'interest'           => $project_structure_entity->interest,
                'breakthrough_plan'  => $project_structure_entity->breakthrough_plan,
                'feedback'           => $project_structure_entity->feedback,
                'proof'              => $project_structure_entity->proof,
                'pain_desc'          => $project_structure_entity->pain_desc,
                'support_type'       => $project_structure_entity->support_type,
                'structure_type'     => $project_structure_entity->structure_type,
            ]
        );
        $model->save();
        $project_structure_entity->setIdentity($model->id);
    }


    /**
     * Reconstitute an entity from persistence.
     *
     * @param mixed $id
     * @param array $params Additional params.
     *
     * @return ProjectStructureModel
     */
    protected function reconstitute($id, $params = [])
    {
        $model = ProjectStructureModel::find($id);
        if (!isset($model)) {
            return null;
        }
        return $this->reconstituteFromModel($model);
    }

    /**
     * @param ProjectStructureModel $model
     *
     * @return ProjectStructureEntity
     */
    private function reconstituteFromModel($model)
    {
        $entity = new ProjectStructureEntity();
        $entity->id = $model->id;
        $entity->parent_id = $model->parent_id;
        $entity->project_id = $model->project_id;
        $entity->name = $model->name;
        $entity->position_name = $model->position_name;
        $entity->contact_phone = $model->contact_phone;
        $entity->structure_role_id = $model->structure_role_id;
        $entity->current_related_id = $model->current_related_id;
        $entity->character = $model->character;
        $entity->interest = $model->interest;
        $entity->breakthrough_plan = $model->breakthrough_plan;
        $entity->feedback = $model->feedback;
        $entity->proof = $model->proof;
        $entity->pain_desc = $model->pain_desc;
        $entity->support_type = $model->support_type;
        $entity->structure_type = $model->structure_type;
        $entity->created_at = $model->created_at;
        $entity->updated_at = $model->updated_at;
        $entity->setIdentity($model->id);
        $entity->stored();
        return $entity;
    }

    /**
     * @param int $project_id
     * @param int $type
     * @return array|\Illuminate\Support\Collection
     */
    public function getProjectStructureByProjectId($project_id, $type = 1)
    {
        $collect = collect();
        $builder = ProjectStructureModel::query();
        $builder->where('project_id', $project_id);
        $builder->where('structure_type', $type);
        $models = $builder->get();
        /** @var ProjectStructureModel $model */
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
        $builder = ProjectStructureModel::query();
        $builder->whereIn('id', (array)$ids);
        $models = $builder->get();
        foreach ($models as $model) {
            $model->delete();
        }
    }

    /**
     * @param int $parent_id
     * @return array|\Illuminate\Support\Collection
     */
    public function getProjectStructureByParentId($parent_id)
    {
        $collect = collect();
        $builder = ProjectStructureModel::query();
        $builder->where('parent_id', $parent_id);
        $models = $builder->get();
        foreach ($models as $model) {
            $collect[] = $this->reconstituteFromModel($model);
        }
        return $collect;
    }

}