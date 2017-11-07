<?php namespace Huifang\Src\Surport\Infra\Repository;

use Huifang\Src\Foundation\Domain\Repository;
use Huifang\Src\Surport\Domain\Model\CountyEntity;
use Huifang\Src\Surport\Domain\Interfaces\CountyInterface;
use Huifang\Src\Surport\Infra\Eloquent\CountyModel;


class CountyRepository extends Repository implements CountyInterface
{
    /**
     * Store an entity into persistence.
     *
     * @param CountyEntity $county_entity
     */
    protected function store($county_entity)
    {
        if ($county_entity->stored()) {
            $model = CountyModel::find($county_entity->id);
        } else {
            $model = new CountyModel();
        }
        $model->fill(
            [
                'city_id' => $county_entity->city_id,
                'name'    => $county_entity->name,
                'lng'     => $county_entity->lng,
                'lat'     => $county_entity->lat,
            ]
        );
        $model->save();
        $county_entity->setIdentity($model->id);
    }

    /**
     * Reconstitute an entity from persistence.
     *
     * @param mixed $id
     * @param array $params Additional params.
     *
     * @return CountyEntity
     */
    protected function reconstitute($id, $params = [])
    {
        $model = CountyModel::find($id);
        if (!isset($model)) {
            return null;
        }
        return $this->reconstituteFromModel($model);
    }

    /**
     * @param CountyModel $model
     *
     * @return CountyEntity
     */
    private function reconstituteFromModel($model)
    {
        $entity = new CountyEntity();
        $entity->id = $model->id;
        $entity->city_id = $model->city_id;
        $entity->name = $model->name;
        $entity->lng = $model->lng;
        $entity->lat = $model->lat;

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
        $builder = CountyModel::query();
        $models = $builder->get();
        foreach ($models as $model) {
            $collection[] = $this->reconstituteFromModel($model);
        }
        return $collection;
    }

}