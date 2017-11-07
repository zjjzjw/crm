<?php

namespace Huifang\Crm\Src\Forms\Company\Depart;

use Carbon\Carbon;
use Huifang\Src\Company\Domain\Model\CompanyEntity;
use Huifang\Src\Company\Infra\Repository\CompanyRepository;
use Huifang\Src\Role\Domain\Model\DepartEntity;
use Huifang\Src\Role\Infra\Repository\DepartRepository;
use Huifang\Src\Sale\Domain\Model\SaleSpecification;
use Huifang\Crm\Src\Forms\Form;

class DepartStoreForm extends Form
{

    /**
     * @var DepartEntity
     */
    public $depart_entity;

    /**
     * Get the validation rules.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'id'         => 'required|integer',
            'company_id' => 'required|integer',
            'name'       => 'required|string',
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
            'company_id' => '公司ID',
            'name'       => '部门名称',
        ];
    }


    public function validation()
    {
        if (array_get($this->data, 'id')) {
            $depart_repository = new DepartRepository();
            $this->depart_entity = $depart_repository->fetch(array_get($this->data, 'id'));
        } else {
            $this->depart_entity = new DepartEntity();
            $this->depart_entity->parent_id = 0;
        }
        $this->depart_entity->company_id = array_get($this->data, 'company_id');
        $this->depart_entity->name = array_get($this->data, 'name');
        $this->depart_entity->desc = '';

    }

}