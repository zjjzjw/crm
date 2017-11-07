<?php

namespace Huifang\Admin\Src\Forms\Company\Rival;

use Huifang\Admin\Src\Forms\Form;
use Huifang\Src\Product\Domain\Model\RivalEntity;
use Huifang\Src\Product\Infra\Repository\RivalRepository;

class RivalStoreForm extends Form
{

    /**
     * @var RivalEntity
     */
    public $rival_entity;

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
        ];
    }

    public function attributes()
    {
        return [
            'name' => '竞品公司名称',
        ];
    }


    public function validation()
    {
        if (array_get($this->data, 'id')) {
            $rival_repository = new RivalRepository();
            $this->rival_entity = $rival_repository->fetch(array_get($this->data, 'id'));
        } else {
            $this->rival_entity = new RivalEntity();
            $this->rival_entity->company_id = request()->user()->company->id;
        }
        $this->rival_entity->name = array_get($this->data, 'name');

        $this->validateRivalCount();

    }

    public function validateRivalCount()
    {
        if (!array_get($this->data, 'id')) {
            $company_id = request()->user()->company->id;
            $rival_repository = new RivalRepository();
            $rival_entities = $rival_repository->getRivalsByCompanyId($company_id);
            if ($rival_entities->count() >= 2) {
                $this->addError('count', '最多有两个竞品公司！');
            }
        }
    }

}