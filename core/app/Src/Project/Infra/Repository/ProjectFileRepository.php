<?php namespace Huifang\Src\Project\Infra\Repository;

use Huifang\Src\Foundation\Domain\Repository;
use Huifang\Src\Project\Domain\Interfaces\ProjectFileInterface;
use Huifang\Src\Project\Domain\Model\ProjectEntity;
use Huifang\Src\Project\Domain\Model\ProjectFileEntity;
use Huifang\Src\Project\Infra\Eloquent\ProjectCorpUserModel;
use Huifang\Src\Project\Infra\Eloquent\ProjectFileCommentModel;
use Huifang\Src\Project\Infra\Eloquent\ProjectFileInfoModel;
use Huifang\Src\Project\Infra\Eloquent\ProjectFileModel;
use Huifang\Src\Project\Infra\Eloquent\ProjectModel;


class ProjectFileRepository extends Repository implements ProjectFileInterface
{
    /**
     * Store an entity into persistence.
     *
     * @param ProjectFileEntity $project_file_entity
     */
    protected function store($project_file_entity)
    {
        if ($project_file_entity->isStored()) {
            $model = ProjectFileModel::find($project_file_entity->id);
        } else {
            $model = new ProjectFileModel();
        }

        $model->fill(
            [
                'project_id'         => $project_file_entity->project_id,
                'history_brands'     => $project_file_entity->history_brands,
                'cooperation_brands' => $project_file_entity->cooperation_brands,
                'bench_brands'       => $project_file_entity->bench_brands,
                'tender_reason'      => $project_file_entity->tender_reason,
            ]
        );
        $model->save();
        if (!empty($project_file_entity->project_file_info)) {
            $this->saveInfo($model, $project_file_entity->project_file_info);
        }
        if (!empty($project_file_entity->project_file_comment)) {
            $this->saveComment($model, $project_file_entity->project_file_comment);
        }
        $project_file_entity->setIdentity($model->id);
    }


    /**
     * @param ProjectFileModel $model
     * @param                  $project_file_info
     */
    protected function saveInfo($model, $project_file_info)
    {
        $item = [];
        $this->deleteInfo($model->id);
        foreach ($project_file_info as $info) {
            $item[] = new ProjectFileInfoModel([
                'file_model' => $info['file_model'],
                'price'      => $info['price'],
            ]);
        }
        $model->project_file_info()->saveMany($item);
    }

    protected function deleteInfo($id)
    {
        $project_file_info_query = ProjectFileInfoModel::query();
        $project_file_info_query->where('project_file_id', $id);
        $project_file_info_models = $project_file_info_query->get();
        foreach ($project_file_info_models as $project_file_info_model) {
            $project_file_info_model->delete();
        }
    }

    /**
     * @param ProjectFileModel $model
     * @param                  $project_file_comment
     */
    protected function saveComment($model, $project_file_comment)
    {
        $item = [];
        $this->deleteComment($model->id);
        foreach ($project_file_comment as $comment) {
            if (!empty($comment)) {
                $item[] = new ProjectFileCommentModel([
                    'comment' => $comment,
                ]);
            }
        }
        $model->project_file_comment()->saveMany($item);
    }

    protected function deleteComment($id)
    {
        $project_file_comment_query = ProjectFileCommentModel::query();
        $project_file_comment_query->where('project_file_id', $id);
        $project_file_comment_models = $project_file_comment_query->get();
        foreach ($project_file_comment_models as $project_file_comment_model) {
            $project_file_comment_model->delete();
        }
    }

    /**
     * Reconstitute an entity from persistence.
     *
     * @param mixed $id
     * @param array $params Additional params.
     *
     * @return ProjectFileEntity
     */
    protected function reconstitute($id, $params = [])
    {
        $model = ProjectFileModel::find($id);
        if (!isset($model)) {
            return null;
        }
        return $this->reconstituteFromModel($model);
    }

    /**
     * @param ProjectFileModel $model
     *
     * @return ProjectFileEntity
     */
    private function reconstituteFromModel($model)
    {
        $entity = new ProjectFileEntity();
        $entity->id = $model->id;
        $entity->cooperation_brands = $model->cooperation_brands;
        $entity->history_brands = $model->history_brands;
        $entity->project_id = $model->project_id;
        $entity->tender_reason = $model->tender_reason;
        $entity->bench_brands = $model->bench_brands;
        $entity->project_file_info = $model->project_file_info->map(function ($item) {
            return ['file_model' => $item->file_model, 'price' => $item->price];
        })->toArray();
        $entity->project_file_comment = $model->project_file_comment->pluck('comment', 'id')->toArray();

        $entity->created_at = $model->created_at;
        $entity->updated_at = $model->updated_at;
        $entity->setIdentity($model->id);
        $entity->stored();
        return $entity;
    }

    /**
     * @param $project_id
     * @return ProjectFileEntity|null
     */
    public function getProjectFileByProjectId($project_id)
    {
        $builder = ProjectFileModel::query();
        /** @var ProjectFileModel $model */
        $model = $builder->where('project_id', $project_id)->first();
        if (!isset($model)) {
            return null;
        }
        return $this->reconstituteFromModel($model);
    }

    /**
     * @param int|array $ids
     */
    public function delete($ids)
    {
        $builder = ProjectFileModel::query();
        $builder->where('id', (array)$ids);
        $models = $builder->get();
        /** @var ProjectFileModel $model */
        foreach ($models as $model) {
            $project_file_info_ids = $model->project_file_info->pluck('id')->toArray();
            if ($project_file_info_ids) {
                $this->deleteInfo($model->id);
            }

            $project_file_comment_ids = $model->project_file_comment->pluck('id')->toArray();
            if ($project_file_comment_ids) {
                $this->deleteComment($model->id);
            }
            $model->delete();
        }
    }

}