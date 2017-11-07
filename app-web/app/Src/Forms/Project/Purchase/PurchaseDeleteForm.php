<?php

namespace Huifang\Web\Src\Forms\Project\Purchase;

use Huifang\Src\Project\Domain\Model\ProjectEntity;
use Huifang\Src\Project\Domain\Model\ProjectPurchaseEntity;
use Huifang\Src\Project\Infra\Repository\ProjectPurchaseRepository;
use Huifang\Src\Project\Infra\Repository\ProjectRepository;
use Huifang\Web\Src\Forms\Form;

class PurchaseDeleteForm extends Form
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
            'integer'     => ':attribute是整型',
            'string'      => ':attribute是字符串',
        ];
    }

    public function attributes()
    {
        return [
            'id' => '主键',
        ];
    }

    public function validation()
    {
        $this->validateProjectPurchaseDelete();
    }

    public function validateProjectPurchaseDelete()
    {
        $id = array_get($this->data, 'id');
        $project_purchase_repository = new ProjectPurchaseRepository();
        /** @var ProjectPurchaseEntity $project_purchase_entity */
        $project_purchase_entity = $project_purchase_repository->fetch($id);
        $project_id = $project_purchase_entity->project_id;
        $project_repository = new ProjectRepository();
        /** @var ProjectEntity $project_entity */
        $project_entity = $project_repository->fetch($project_id);
        if (isset($project_entity) && $project_entity->user_id != request()->user()->id) {
            $this->addError('permission', '权限不足！');
        }
    }

}