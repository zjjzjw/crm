<?php namespace Huifang\Src\Card\Infra\Repository;

use Carbon\Carbon;
use Huifang\Src\Card\Domain\Interfaces\CardInterface;
use Huifang\Src\Card\Domain\Model\CardEntity;
use Huifang\Src\Card\Infra\Eloquent\CardModel;
use Huifang\Src\Foundation\Domain\Repository;


class CardRepository extends Repository implements CardInterface
{
    /**
     * Store an entity into persistence.
     *
     * @param CardEntity $card_entity
     */
    protected function store($card_entity)
    {
        if ($card_entity->isStored()) {
            $model = CardModel::find($card_entity->id);
        } else {
            $model = new CardModel();
        }
        $model->fill(
            [
                'company_id'    => $card_entity->company_id,
                'user_id'       => $card_entity->user_id,
                'name'          => $card_entity->name,
                'initials'      => $card_entity->initials,
                'full_pinyin'   => $card_entity->full_pinyin,
                'phone'         => $card_entity->phone,
                'tel'           => $card_entity->tel,
                'email'         => $card_entity->email,
                'position_name' => $card_entity->position_name,
                'company_name'  => $card_entity->company_name,
                'address'       => $card_entity->address,
                'zip_code'      => $card_entity->zip_code,
            ]
        );
        $model->save();
        $card_entity->setIdentity($model->id);
    }

    /**
     * Reconstitute an entity from persistence.
     *
     * @param mixed $id
     * @param array $params Additional params.
     *
     * @return CardEntity
     */
    protected function reconstitute($id, $params = [])
    {
        $model = CardModel::find($id);
        if (!isset($model)) {
            return null;
        }
        return $this->reconstituteFromModel($model);
    }

    /**
     * @param CardModel $model
     *
     * @return CardEntity
     */
    private function reconstituteFromModel($model)
    {
        $entity = new CardEntity();
        $entity->id = $model->id;
        $entity->company_id = $model->company_id;
        $entity->user_id = $model->user_id;
        $entity->name = $model->name;
        $entity->initials = $model->initials;
        $entity->full_pinyin = $model->full_pinyin;
        $entity->phone = $model->phone;
        $entity->tel = $model->tel;
        $entity->email = $model->email;
        $entity->position_name = $model->position_name;
        $entity->company_name = $model->company_name;
        $entity->address = $model->address;
        $entity->zip_code = $model->zip_code;

        $entity->created_at = $model->created_at;
        $entity->updated_at = $model->updated_at;
        $entity->setIdentity($model->id);
        $entity->stored();
        return $entity;
    }


    /**
     * @param int    $user_id
     * @param string $keyword
     * @return array|\Illuminate\Support\Collection
     */
    public function getCardsByUserId($user_id, $keyword = '', $limit = null)
    {
        $collect = collect();
        $builder = CardModel::query();
        $builder->where('user_id', $user_id);
        if ($keyword) {
            $builder->where('name', 'like', '%' . $keyword . '%');
        }
        $models = $builder->get();
        /** @var CardModel $model */
        foreach ($models as $model) {
            $collect[] = $this->reconstituteFromModel($model);
        }
        return $collect;
    }


    /**
     * @param int|array $id
     */
    public function delete($id)
    {
        $builder = CardModel::query();
        $builder->where('id', (array)$id);
        $models = $builder->get();
        foreach ($models as $model) {
            $model->delete();
        }
    }

}