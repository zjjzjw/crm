<?php

namespace Huifang\Web\Src\Forms\Project\Purchase;

use Carbon\Carbon;
use Huifang\Src\Project\Domain\Model\ProjectEntity;
use Huifang\Src\Project\Domain\Model\ProjectPurchaseEntity;
use Huifang\Src\Project\Infra\Repository\ProjectPurchaseRepository;
use Huifang\Src\Project\Infra\Repository\ProjectRepository;
use Huifang\Web\Src\Forms\Form;

class PurchaseStoreForm extends Form
{

    /**
     * @var ProjectPurchaseEntity
     */
    public $project_purchase_entity;

    /**
     * Get the validation rules.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'id'         => 'required|integer',
            'project_id' => 'required|integer',
            'name'       => 'required|string',
            'personnel'  => 'required|string',
            'timed_at'   => 'required|string|date_format:Y-m-d',
            'event_desc' => 'required|string',
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
            'id'         => '主键',
            'project_id' => '项目ID',
            'personnel'  => '人员',
            'timed_at'   => '时间',
            'event_desc' => '事件',

        ];
    }

    public function validation()
    {
        if (!empty(array_get($this->data, 'id'))) {
            $project_purchase_repository = new ProjectPurchaseRepository();
            $project_purchase_entity = $project_purchase_repository->fetch(array_get($this->data, 'id'));
        } else {
            $project_purchase_entity = new ProjectPurchaseEntity();
        }

        $project_purchase_entity->name = array_get($this->data, 'name');
        $project_purchase_entity->timed_at = Carbon::parse(array_get($this->data, 'timed_at'));
        $project_purchase_entity->event_desc = array_get($this->data, 'event_desc');
        $project_purchase_entity->personnel = array_get($this->data, 'personnel');
        $project_purchase_entity->project_id = array_get($this->data, 'project_id');

        $this->validateProjectPurchaseEdit();

        $this->project_purchase_entity = $project_purchase_entity;

    }

    public function validateProjectPurchaseEdit()
    {
        $project_id = array_get($this->data, 'project_id');
        $project_repository = new ProjectRepository();
        /** @var ProjectEntity $project_entity */
        $project_entity = $project_repository->fetch($project_id);
        if (isset($project_entity) && $project_entity->user_id != request()->user()->id) {
            $this->addError('permission', '权限不足！');
        }
    }

}