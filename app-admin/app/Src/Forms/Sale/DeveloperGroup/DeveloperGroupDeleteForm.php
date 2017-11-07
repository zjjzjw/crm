<?php

namespace Huifang\Admin\Src\Forms\Sale\DeveloperGroup;

use Huifang\Src\Sale\DeveloperGroup\Domain\Model\DeveloperGroupSpecification;
use Huifang\Src\Sale\DeveloperGroup\Infra\Repository\DeveloperGroupRepository;
use Huifang\Web\Src\Forms\Form;

class DeveloperGroupDeleteForm extends Form
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
        $developerGroup_repository = new DeveloperGroupRepository();

        $spec = new DeveloperGroupSpecification();

        $spec->id = $id;

        $developerGroup_entities = $developerGroup_repository->getDeveloperGroupsBySpecification($spec);


    }


}