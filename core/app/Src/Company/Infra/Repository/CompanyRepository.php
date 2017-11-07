<?php namespace Huifang\Src\Company\Infra\Repository;

use Carbon\Carbon;
use Huifang\Src\Company\Domain\Interfaces\CompanyInterface;
use Huifang\Src\Company\Domain\Model\CompanyEntity;
use Huifang\Src\Company\Domain\Model\CompanySpecification;
use Huifang\Src\Company\Infra\Eloquent\CompanyModel;
use Huifang\Src\Foundation\Domain\Repository;
use Huifang\Src\Sale\Domain\Model\SaleEntity;


class CompanyRepository extends Repository implements CompanyInterface
{
    /**
     * Store an entity into persistence.
     *
     * @param CompanyEntity $company_entity
     */
    protected function store($company_entity)
    {
        if ($company_entity->isStored()) {
            $model = CompanyModel::find($company_entity->id);
        } else {
            $model = new CompanyModel();
        }
        $model->fill(
            [
                'name'            => $company_entity->name,
                'start_time'      => $company_entity->start_time->toDateTimeString(),
                'end_time'        => $company_entity->end_time->toDateTimeString(),
                'user_number'     => $company_entity->user_number,
                'is_free'         => $company_entity->is_free,
                'created_user_id' => $company_entity->created_user_id,
            ]
        );
        $model->save();
        $company_entity->setIdentity($model->id);
    }

    /**
     * Reconstitute an entity from persistence.
     *
     * @param mixed $id
     * @param array $params Additional params.
     *
     * @return CompanyEntity
     */
    protected function reconstitute($id, $params = [])
    {
        $model = CompanyModel::find($id);
        if (!isset($model)) {
            return null;
        }
        return $this->reconstituteFromModel($model);
    }

    /**
     * @param CompanyModel $model
     *
     * @return CompanyEntity
     */
    private function reconstituteFromModel($model)
    {
        $entity = new CompanyEntity();
        $entity->id = $model->id;
        $entity->name = $model->name;
        $entity->start_time = $model->start_time;
        $entity->end_time = $model->end_time;
        $entity->is_free = $model->is_free;
        $entity->user_number = $model->user_number;
        $entity->created_at = $model->created_at;
        $entity->updated_at = $model->updated_at;
        $entity->setIdentity($model->id);
        $entity->stored();
        return $entity;
    }

    /**
     * @param CompanySpecification $spec
     * @param int                  $per_page
     * @return mixed
     */
    public function search(CompanySpecification $spec, $per_page = 10)
    {
        $builder = CompanyModel::query();

        if ($spec->keyword) {
            $builder->where('name', 'like', '%' . $spec->keyword . '%');
        }
        $builder->orderBy('created_at', 'desc');
        if ($spec->start_time) {
            $builder->where('end_time', '>=', $spec->start_time->startOfDay());
        }
        if ($spec->end_time) {
            $builder->where('start_time', '<=', $spec->end_time->endOfDay());
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