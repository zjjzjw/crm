<?php namespace Huifang\Src\Project\Infra\Repository;

use Huifang\Src\Foundation\Domain\Repository;
use Huifang\Src\Project\Domain\Interfaces\ProjectCorpUserInterface;
use Huifang\Src\Project\Domain\Model\ProjectCorpUserEntity;
use Huifang\Src\Project\Domain\Model\ProjectStructureEntity;
use Huifang\Src\Project\Infra\Eloquent\ProjectCorpUserModel;
use Huifang\Src\Project\Infra\Eloquent\ProjectStructureModel;


class ProjectCorpUserRepository extends Repository implements ProjectCorpUserInterface
{
    /**
     * Store an entity into persistence.
     *
     * @param ProjectCorpUserEntity $project_structure_entity
     */
    protected function store($project_structure_entity)
    {

    }


    /**
     * Reconstitute an entity from persistence.
     *
     * @param mixed $id
     * @param array $params Additional params.
     *
     * @return ProjectCorpUserEntity
     */
    protected function reconstitute($id, $params = [])
    {
        $model = ProjectCorpUserModel::find($id);
        if (!isset($model)) {
            return null;
        }
        return $this->reconstituteFromModel($model);
    }

    /**
     * @param ProjectCorpUserModel $model
     *
     * @return ProjectCorpUserEntity
     */
    private function reconstituteFromModel($model)
    {
        $entity = new ProjectCorpUserEntity();
        $entity->id = $model->id;
        $entity->user_id = $model->user_id;
        $entity->project_id = $model->project_id;

        $entity->created_at = $model->created_at;
        $entity->updated_at = $model->updated_at;
        $entity->setIdentity($model->id);
        $entity->stored();
        return $entity;
    }


    /**
     * @param int $user_id
     * @return mixed
     */
    public function getProjectCorpUsersByUserId($user_id)
    {
        $collect = collect();
        $builder = ProjectCorpUserModel::query();
        $builder->where('user_id', $user_id);
        $models = $builder->get();
        foreach ($models as $model) {
            $collect[] = $this->reconstituteFromModel($model);
        }
        return $collect;

    }


}