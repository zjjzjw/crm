<?php

namespace Huifang\Admin\Src\Forms\Sale\LargeArea;

use Huifang\Src\Sale\LargeArea\Domain\Model\LargeAreaSpecification;
use Huifang\Src\Sale\LargeArea\Infra\Repository\LargeAreaRepository;
use Huifang\Web\Src\Forms\Form;

class LargeAreaDeleteForm extends Form
{
    /**
     * Get the validation rules.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'id' => 'required|integer',
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
            'id' => '主键ID',
        ];
    }


    public function validation()
    {
        $id = array_get($this->data, 'id');

        $this->validateCategory($id);

    }

    public function validateCategory($id)
    {
        $largeArea_repository = new LargeAreaRepository();

        $spec = new LargeAreaSpecification();

        $spec->id = $id;

        $largeArea_entities = $largeArea_repository->getLargeAreasBySpecification($spec);


    }


}