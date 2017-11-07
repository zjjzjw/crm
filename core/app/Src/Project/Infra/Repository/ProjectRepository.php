<?php namespace Huifang\Src\Project\Infra\Repository;

use Carbon\Carbon;
use Huifang\Src\Foundation\Domain\Repository;
use Huifang\Src\Project\Domain\Model\ProjectEntity;
use Huifang\Src\Project\Domain\Model\ProjectSpecification;
use Huifang\Src\Project\Infra\Eloquent\ProjectCorpUserModel;
use Huifang\Src\Project\Infra\Eloquent\ProjectModel;
use Huifang\Src\Project\Domain\Interfaces\ProjectInterface;
use Huifang\Src\Sale\Infra\Eloquent\SaleModel;


class ProjectRepository extends Repository implements ProjectInterface
{
    /**
     * Store an entity into persistence.
     *
     * @param ProjectEntity $project_entity
     */
    protected function store($project_entity)
    {
        if ($project_entity->isStored()) {
            $model = ProjectModel::find($project_entity->id);
        } else {
            $model = new ProjectModel();
        }

        $model->fill(
            [
                'user_id'         => $project_entity->user_id,
                'company_id'      => $project_entity->company_id,
                'project_name'    => $project_entity->project_name,
                'province_id'     => $project_entity->province_id,
                'city_id'         => $project_entity->city_id,
                'address'         => $project_entity->address,
                'developer_name'  => $project_entity->developer_name,
                'project_volume'  => $project_entity->project_volume,
                'contact_name'    => $project_entity->contact_name,
                'contact_phone'   => $project_entity->contact_phone,
                'created_user_id' => $project_entity->created_user_id,
                'use_brands'      => $project_entity->use_brands,
                'signed_at'       => $project_entity->signed_at,
            ]
        );
        $model->save();
        $this->saveProjectCorpUser($model, $project_entity);
        $project_entity->setIdentity($model->id);
    }

    /**
     * @param ProjectModel  $model
     * @param ProjectEntity $project_entity
     */
    protected function saveProjectCorpUser($model, $project_entity)
    {
        if (isset($project_entity->project_corp_user_ids)) {
            $project_corp_user_models = ProjectCorpUserModel::where('project_id', $model->id)
                ->get();
            foreach ($project_corp_user_models as $project_corp_user_model) {
                $project_corp_user_model->delete();
            }
            foreach ($project_entity->project_corp_user_ids as $user_id) {
                $project_corp_user_model = new ProjectCorpUserModel();
                $project_corp_user_model->user_id = $user_id;
                $project_corp_user_model->project_id = $model->id;
                $project_corp_user_model->save();
            }
        }
    }

    /**
     * Reconstitute an entity from persistence.
     *
     * @param mixed $id
     * @param array $params Additional params.
     *
     * @return ProjectEntity
     */
    protected function reconstitute($id, $params = [])
    {
        $model = ProjectModel::find($id);
        if (!isset($model)) {
            return null;
        }
        return $this->reconstituteFromModel($model);
    }

    /**
     * @param ProjectModel $model
     *
     * @return ProjectEntity
     */
    private function reconstituteFromModel($model)
    {
        $entity = new ProjectEntity();
        $entity->id = $model->id;
        $entity->user_id = $model->user_id;
        $entity->company_id = $model->company_id;
        $entity->project_name = $model->project_name;
        $entity->province_id = $model->province_id;
        $entity->city_id = $model->city_id;
        $entity->address = $model->address;
        $entity->developer_name = $model->developer_name;
        $entity->project_volume = $model->project_volume;
        $entity->contact_name = $model->contact_name;
        $entity->contact_phone = $model->contact_phone;
        $entity->created_user_id = $model->created_user_id;
        $entity->project_corp_user_ids = $model->project_corp_users->pluck('user_id')->toArray();
        $entity->use_brands = $model->use_brands;
        $entity->signed_at = $model->signed_at;
        $entity->created_at = $model->created_at;
        $entity->updated_at = $model->updated_at;
        $entity->setIdentity($model->id);
        $entity->stored();
        return $entity;
    }

    /**
     * @param ProjectSpecification $spec
     * @param int                  $per_page
     * @return mixed
     */
    public function search(ProjectSpecification $spec, $per_page = 10)
    {
        $builder = ProjectModel::query();

        if ($spec->company_id) {
            $builder->where('company_id', $spec->company_id);
        }

        if ($spec->user_ids) {
            $builder->whereIn('user_id', (array)$spec->user_ids);
        }
        if ($spec->user_id) {
            $builder->where('user_id', $spec->user_id);
        }
        if ($spec->province_id) {
            $builder->where('province_id', $spec->province_id);
        }
        if ($spec->city_id) {
            $builder->where('city_id', $spec->city_id);
        }
        if ($spec->select_user_id) {
            $builder->where('user_id', $spec->select_user_id);
        }
        //体量
        if ($spec->project_volume_min) {
            $builder->where('project_volume', '>=', $spec->project_volume_min);
        }
        if ($spec->project_volume_max) {
            $builder->where('project_volume', '<=', $spec->project_volume_max);
        }

        if (isset($spec->project_ids)) {
            $builder->whereIn('id', $spec->project_ids);
        }

        //时间
        if ($spec->start_time) {
            $builder->where('signed_at', '>=', $spec->start_time->startOfDay());
        }
        if ($spec->end_time) {
            $builder->where('signed_at', '<=', $spec->end_time->endOfDay());
        }

        if ($spec->keyword) {
            $builder->where('project_name', 'like', '%' . $spec->keyword . '%');
        }

        $builder->orderBy('created_at', 'desc');

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
     * @param ProjectSpecification $spec
     * @param int                  $limit
     * @return array|\Illuminate\Support\Collection
     */
    public function getProjectListByKeyword(ProjectSpecification $spec, $limit = 20)
    {
        $collect = collect();
        $builder = ProjectModel::query();

        if ($spec->user_ids) {
            $builder->whereIn('user_id', (array)$spec->user_ids);
        }
        if ($spec->user_id) {
            $builder->where('user_id', $spec->user_id);
        }
        if ($spec->province_id) {
            $builder->where('province_id', $spec->province_id);
        }
        if ($spec->city_id) {
            $builder->where('city_id', $spec->city_id);
        }
        if ($spec->select_user_id) {
            $builder->where('user_id', $spec->select_user_id);
        }

        if ($spec->start_time) {
            $builder->where('signed_at', '>=', $spec->start_time);
        }

        if ($spec->end_time) {
            $builder->where('signed_at', '<=', $spec->end_time);
        }

        if (isset($spec->project_ids)) {
            $builder->whereIn('id', $spec->project_ids);
        }

        $builder->where('project_name', 'like', '%' . $spec->keyword . '%');

        $builder->limit($limit);

        $models = $builder->get();
        /** @var SaleModel $model */
        foreach ($models as $model) {
            $collect[] = $this->reconstituteFromModel($model);
        }
        return $collect;
    }

    public function getProjectListByKeywords($keyword, $user_ids, $company_id)
    {
        $collect = collect();
        $builder = ProjectModel::query();
        if ($keyword){
            $builder->where('project_name', 'like', '%' . $keyword . '%');
        }

        if ($user_ids){
            $builder->whereIn('user_id', (array)$user_ids);
        }
        $builder->where('company_id', $company_id);
        $models = $builder->get();

        /** @var SaleModel $model */
        foreach ($models as $model) {
            $collect[] = $this->reconstituteFromModel($model);
        }
        return $collect;
    }

    public function getProjectListByIds($ids)
    {
        $collect = collect();
        $builder = ProjectModel::query();

        $builder->whereIn('id', (array)$ids);
        $models = $builder->get();
        /** @var SaleModel $model */
        foreach ($models as $model) {
            $collect[] = $this->reconstituteFromModel($model);
        }
        return $collect;
    }

    /**
     * @param int|array $user_id
     * @return array|\Illuminate\Support\Collection
     */
    public function getProjectsByUserId($user_id)
    {
        $collect = collect();
        $builder = ProjectModel::query();
        $builder->whereIn('user_id', (array)$user_id);
        $models = $builder->get();
        /** @var ProjectModel $model */
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
        $builder = ProjectModel::query();
        $builder->where('id', (array)$ids);
        $models = $builder->get();
        foreach ($models as $model) {
            $model->delete();
        }
    }

}