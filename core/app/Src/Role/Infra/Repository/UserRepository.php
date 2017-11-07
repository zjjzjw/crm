<?php namespace Huifang\Src\Role\Infra\Repository;

use Huifang\Src\Foundation\Domain\Repository;
use Huifang\Src\Role\Domain\Interfaces\UserInterface;
use Huifang\Src\Role\Domain\Model\UserEntity;
use Huifang\Src\Role\Domain\Model\UserSpecification;
use Huifang\Src\Role\Infra\Eloquent\UserModel;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;


class UserRepository extends Repository implements UserInterface
{
    /**
     * Store an entity into persistence.
     *
     * @param UserEntity $user_entity
     */
    protected function store($user_entity)
    {
        if ($user_entity->isStored()) {
            $model = UserModel::find($user_entity->id);
        } else {
            $model = new UserModel();
        }
        //密码单独处理
        //'password'  => $model->getMd5Password($user_entity->password),
        $model->fill(
            [
                'company_id'      => $user_entity->company_id,
                'name'            => $user_entity->name,
                'email'           => $user_entity->email,
                'phone'           => $user_entity->phone,
                'start_time'      => $user_entity->start_time,
                'end_time'        => $user_entity->end_time,
                'created_user_id' => $user_entity->created_user_id,
                'image_id'        => $user_entity->image_id,
            ]
        );
        $model->save();
        $model->roles()->sync($user_entity->role_ids);
        $model->departs()->sync($user_entity->depart_ids);
        $user_entity->setIdentity($model->id);
    }

    /**
     * Reconstitute an entity from persistence.
     *
     * @param mixed $id
     * @param array $params Additional params.
     *
     * @return \Huifang\Src\Role\Domain\Model\UserEntity
     */
    protected function reconstitute($id, $params = [])
    {
        $model = UserModel::find($id);
        if (!isset($model)) {
            return null;
        }
        return $this->reconstituteFromModel($model);
    }

    /**
     * @param $model
     * @return \Huifang\Src\Role\Domain\Model\UserEntity
     */
    private function reconstituteFromModel($model)
    {
        $entity = new UserEntity();
        $entity->id = $model->id;
        $entity->company_id = $model->company_id;
        $entity->name = $model->name;
        $entity->email = $model->email;
        $entity->phone = $model->phone;
        $entity->password = $model->password;
        $entity->created_user_id = $model->created_user_id;
        $entity->start_time = $model->start_time;
        $entity->end_time = $model->end_time;
        $entity->image_id = $model->image_id;
        $entity->created_at = $model->created_at;
        $entity->updated_at = $model->updated_at;
        $entity->role_ids = $model->roles->pluck('id')->toArray();
        $entity->depart_ids = $model->departs->pluck('id')->toArray();
        $entity->roles = $model->roles->toArray();
        $entity->departs = $model->departs->toArray();
        $entity->setIdentity($model->id);
        $entity->stored();
        return $entity;
    }

    /**
     * @param UserSpecification $spec
     * @param int               $per_page
     * @return LengthAwarePaginator
     */
    public function search(UserSpecification $spec, $per_page = 10)
    {
        $query = UserModel::query();
        if ($spec->keyword) {
            $query->where('name', 'like', '%' . $spec->keyword . '%');
        }
        if ($spec->company_id) {
            $query->where('company_id', $spec->company_id);
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

    public function getUsersByDepartIds($depart_ids)
    {
        $collect = collect();
        $builder = UserModel::query();
        $builder->leftJoin('user_depart', function ($join) {
            $join->on('user_depart.user_id', '=', 'user.id');
        });
        $builder->whereIn('user_depart.depart_id', $depart_ids);
        $builder->select('user.*');
        $models = $builder->get();
        foreach ($models as $model) {
            $collect[] = $this->reconstituteFromModel($model);
        }
        return $collect;
    }

    /**
     * @param  array $ids
     * @return array|\Illuminate\Support\Collection
     */
    public function getUserByIds($ids)
    {
        $collect = collect();
        $builder = UserModel::query();
        $builder->whereIn('id', $ids);
        $models = $builder->get();
        foreach ($models as $model) {
            $collect[] = $this->reconstituteFromModel($model);
        }
        return $collect;
    }


    /**
     * @param int|array $company_id
     * @return array|\Illuminate\Support\Collection
     */
    public function getUsersByCompanyId($company_id)
    {
        $collect = collect();
        $builder = UserModel::query();
        $builder->whereIn('company_id', (array)$company_id);
        $models = $builder->get();
        foreach ($models as $model) {
            $collect[] = $this->reconstituteFromModel($model);
        }
        return $collect;
    }

    /**
     * @var string|array $phone
     * @return array|\Illuminate\Support\Collection
     */
    public function getUserByPhone($phone)
    {
        $collect = collect();
        $builder = UserModel::query();
        if ($phone) {
            $builder->whereIn('phone', (array)$phone);
        }
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
        $builder = UserModel::query();
        $builder->whereIn('id', (array)$ids);
        $models = $builder->get();
        foreach ($models as $model) {
            $model->delete();
        }
    }
    public function getUserByKeyword($keyword)
    {
        $collect = collect();
        $builder = UserModel::query();
        $builder->whereRaw("LOCATE('$keyword',`name`)>0");
        $builder->limit(10);
        $models = $builder->get();
        /** @var UserModel $model */
        foreach ($models as $model) {
            $collect[] = $this->reconstituteFromModel($model);
        }

        return $collect;
    }



}