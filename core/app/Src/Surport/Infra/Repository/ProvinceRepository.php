<?php namespace Huifang\Src\Surport\Infra\Repository;

use Huifang\Src\Foundation\Domain\Repository;
use Huifang\Src\Surport\Domain\Model\ProvinceEntity;
use Huifang\Src\Surport\Domain\Interfaces\ProvinceInterface;
use Huifang\Src\Surport\Infra\Eloquent\ProvinceModel;


class ProvinceRepository extends Repository implements ProvinceInterface
{
    /**
     * Store an entity into persistence.
     *
     * @param ProvinceEntity $province_entity
     */
    protected function store($province_entity)
    {
        if ($province_entity->stored()) {
            $model = ProvinceModel::find($province_entity->id);
        } else {
            $model = new ProvinceModel();
        }
        $model->fill(
            [
                'name'    => $province_entity->name,
                'area_id' => $province_entity->province_id,
            ]
        );
        $model->save();
        $province_entity->setIdentity($model->id);
    }

    /**
     * Reconstitute an entity from persistence.
     *
     * @param mixed $id
     * @param array $params Additional params.
     *
     * @return ProvinceEntity
     */
    protected function reconstitute($id, $params = [])
    {
        $model = ProvinceModel::find($id);
        if (!isset($model)) {
            return null;
        }
        return $this->reconstituteFromModel($model);
    }

    /**
     * @param ProvinceModel $model
     *
     * @return ProvinceEntity
     */
    private function reconstituteFromModel($model)
    {
        $entity = new ProvinceEntity();
        $entity->id = $model->id;
        $entity->area_id = $model->area_id;
        $entity->name = $model->name;

        $entity->setIdentity($model->id);
        $entity->stored();
        return $entity;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function all()
    {
        $collection = collect();
        $builder = ProvinceModel::query();
        $models = $builder->get();
        foreach ($models as $model) {
            $collection[] = $this->reconstituteFromModel($model);
        }
        return $collection;
    }

}