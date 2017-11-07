<?php

namespace Huifang\Web\Src\Forms\Contract;

use Carbon\Carbon;
use Huifang\Src\Contract\Domain\Model\ContractEntity;
use Huifang\Src\Contract\Domain\Model\SignTaskEntity;
use Huifang\Src\Contract\Infra\Repository\ContractRepository;
use Huifang\Src\Contract\Infra\Repository\SignTaskRepository;
use Huifang\Src\Project\Domain\Model\ProjectEntity;
use Huifang\Src\Project\Infra\Repository\ProjectRepository;
use Huifang\Web\Src\Forms\Form;

class SignTaskStoreForm extends Form
{
    /**
     * @var SignTaskEntity
     */
    public $sign_task_entity;

    /**
     * Get the validation rules.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'id'      => 'required|integer',
            'user_id' => 'required|integer',
            'month'   => 'required|integer',
            'amount'  => 'required|numeric',
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
            'id'     => '主键',
            'month'  => '月份',
            'amount' => '金额',
        ];
    }

    public function validation()
    {
        if (array_get($this->data, 'id')) {
            $sign_task_repository = new SignTaskRepository();
            /** @var SignTaskEntity $sign_task_entity */
            $sign_task_entity = $sign_task_repository->fetch(array_get($this->data, 'id'));
        } else {
            $sign_task_entity = new SignTaskEntity();
        }
        $sign_task_entity->user_id = array_get($this->data, 'user_id');
        $sign_task_entity->month = array_get($this->data, 'month');
        $sign_task_entity->amount = array_get($this->data, 'amount');

        $this->validateSignTaskStore();

        $this->sign_task_entity = $sign_task_entity;
    }


    public function validateSignTaskStore()
    {
        $user_id = array_get($this->data, 'user_id');
        $month = array_get($this->data, 'month');
        $sign_task_repository = new SignTaskRepository();
        $sign_task_entities = $sign_task_repository->getSignTasksByUserIdAndMonth($user_id, $month);

        if (!$sign_task_entities->isEmpty()) {
            if (array_get($this->data, 'id')) {
                foreach ($sign_task_entities as $sign_task_entity) {
                    if ($sign_task_entity->id != array_get($this->data, 'id')) {
                        $this->addError('sign_task', '一月只能设置一次签约任务！');
                    }
                }
            } else {
                $this->addError('sign_task', '一月只能设置一次签约任务！');
            }
        }
    }

}