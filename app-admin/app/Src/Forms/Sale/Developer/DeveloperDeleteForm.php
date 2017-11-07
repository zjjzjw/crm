<?php

namespace Huifang\Admin\Src\Forms\Sale\Developer;

use Huifang\Src\Sale\Developer\Domain\Model\DeveloperSpecification;
use Huifang\Src\Sale\Developer\Infra\Repository\DeveloperRepository;
use Huifang\Web\Src\Forms\Form;

class DeveloperDeleteForm extends Form
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
        $developer_repository = new DeveloperRepository();

        $spec = new DeveloperSpecification();

        $spec->id = $id;

        $developer_entities = $developer_repository->getDevelopersBySpecification($spec);


    }


}