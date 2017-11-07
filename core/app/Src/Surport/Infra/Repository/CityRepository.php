<?php namespace Huifang\Src\Surport\Infra\Repository;

use Huifang\Src\Foundation\Domain\Repository;
use Huifang\Src\Surport\Domain\Model\CityEntity;
use Huifang\Src\Surport\Domain\Interfaces\CityInterface;
use Huifang\Src\Surport\Infra\Eloquent\CityModel;


class CityRepository extends Repository implements CityInterface
{
    /**
     * Store an entity into persistence.
     *
     * @param CityEntity $city_entity
     */
    protected function store($city_entity)
    {
        if ($city_entity->stored()) {
            $model = CityModel::find($city_entity->id);
        } else {
            $model = new CityModel();
        }
        $model->fill(
            [
                'province_id' => $city_entity->province_id,
                'name'        => $city_entity->name,
                'lng'         => $city_entity->lng,
                'lat'         => $city_entity->lat,
            ]
        );
        $model->save();
        $city_entity->setIdentity($model->id);
    }

    /**
     * Reconstitute an entity from persistence.
     *
     * @param mixed $id
     * @param array $params Additional params.
     *
     * @return CityEntity
     */
    protected function reconstitute($id, $params = [])
    {
        $model = CityModel::find($id);
        if (!isset($model)) {
            return null;
        }
        return $this->reconstituteFromModel($model);
    }

    /**
     * @param CityModel $model
     *
     * @return CityEntity
     */
    private function reconstituteFromModel($model)
    {
        $entity = new CityEntity();
        $entity->id = $model->id;
        $entity->province_id = $model->province_id;
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
        $builder = CityModel::query();
        $models = $builder->get();
        foreach ($models as $model) {
            $collection[] = $this->reconstituteFromModel($model);
        }
        return $collection;
    }

}