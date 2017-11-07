<?php

namespace Huifang\Web\Src\Forms\Card;

use Huifang\Src\Card\Domain\Model\CardEntity;
use Huifang\Src\Card\Infra\Repository\CardRepository;
use Huifang\Web\Src\Forms\Form;

class CardStoreForm extends Form
{

    /**
     * @var CardEntity
     */
    public $card_entity;

    /**
     * Get the validation rules.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'id'            => 'required|integer',
            'name'          => 'required|string',
            'phone'         => 'required|string',
            'tel'           => 'string',
            'email'         => 'string',
            'position_name' => 'required|string',
            'company_name'  => 'required|string',
            'address'       => 'required|string',
            'zip_code'      => 'string',
        ];
    }


    protected function messages()
    {
        return [
            'required'    => ':attribute必填。',
            'date_format' => ':attribute格式错误',
            'integer'     => ':attribute是整型',
            'string'      => ':attribute是字符串',
        ];
    }

    public function attributes()
    {
        return [
            'id'            => '主键',
            'company_id'    => '公司ID',
            'user_id'       => '用户ID',
            'name'          => '名称',
            'initials'      => '首字母',
            'full_pinyin'   => '全拼',
            'phone'         => '手机',
            'tel'           => '电话',
            'email'         => '邮箱',
            'position_name' => '职位',
            'company_name'  => '公司名称',
            'address'       => '地址',
            'zip_code'      => '邮编',
        ];
    }

    public function validation()
    {
        if (!empty(array_get($this->data, 'id'))) {
            $card_repository = new CardRepository();
            $card_entity = $card_repository->fetch(array_get($this->data, 'id'));
        } else {
            $card_entity = new CardEntity();
            $card_entity->user_id = request()->user()->id;
            $card_entity->company_id = request()->user()->company->id;;
        }
        $card_entity->name = array_get($this->data, 'name');
        $card_entity->phone = array_get($this->data, 'phone');
        $card_entity->tel = array_get($this->data, 'tel', '');
        $card_entity->email = array_get($this->data, 'email', '');
        $card_entity->position_name = array_get($this->data, 'position_name');
        $card_entity->company_name = array_get($this->data, 'company_name');
        $card_entity->address = array_get($this->data, 'address');
        $card_entity->zip_code = array_get($this->data, 'zip_code');
        $card_entity->full_pinyin = pinyin_sentence($card_entity->name);
        if (!empty($card_entity->full_pinyin)) {
            $card_entity->initials = strtoupper(substr($card_entity->full_pinyin, 0, 1));
        }
        $this->card_entity = $card_entity;
    }

}