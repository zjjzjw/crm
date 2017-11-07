<?php

namespace Huifang\Admin\Src\Forms\Sale\LargeArea;

use Huifang\Src\Sale\LargeArea\Domain\Model\LargeAreaEntity;
use Huifang\Src\Sale\LargeArea\Infra\Repository\LargeAreaRepository;
use Huifang\Web\Src\Forms\Form;

class LargeAreaStoreForm extends Form
{

    /**
     * @var LargeAreaEntity
     */
    public $largeArea_entity;

    /**
     * Get the validation rules.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'id'   => 'required|integer',
            'name' => 'required|string',


        ];
    }

    protected function messages()
    {
        return [
            'required'    => ':attribute必填。',
            'date_format' => ':attribute格式错误',
            'integer'     => ':attribute必须是数字',
            'max'         => ':attribute最大长度',
        ];
    }

    public function attributes()
    {
        return [
            'name' => '大区名称',

        ];
    }
    public function validation()
    {

        if (array_get($this->data, 'id')) {
            $largeArea_repository = new LargeAreaRepository();
            $this->largeArea_entity = $largeArea_repository->fetch(array_get($this->data, 'id'));
        }else {
            $this->largeArea_entity = new LargeAreaEntity();
            $this->largeArea_entity->company_id = request()->user()->company_id;
        }

        $this->largeArea_entity->name = array_get($this->data, 'name');

    }

}