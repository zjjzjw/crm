<?php

namespace Huifang\Crm\Src\Forms\Company\Role;

use Carbon\Carbon;
use Huifang\Src\Role\Domain\Model\RoleEntity;
use Huifang\Src\Role\Domain\Model\UserFeedbackSpecification;
use Huifang\Src\Role\Infra\Repository\RoleRepository;
use Huifang\Crm\Src\Forms\Form;

class UserFeedbackSearchForm extends Form
{

    /**
     * @var UserFeedbackSpecification
     */
    public $user_feedback_specification;

    /**
     * Get the validation rules.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'start_time' => 'string|date_format:Y-m-d',
            'end_time'   => 'string|date_format:Y-m-d',
            'keyword'    => 'string',
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
            'start_time' => '开始时间',
            'name'       => '结束时间',
            'keyword'    => '关键字',
        ];
    }


    public function validation()
    {
        $this->user_feedback_specification = new UserFeedbackSpecification();
        if (array_get($this->data, 'start_time')) {
            $this->user_feedback_specification->start_time = Carbon::parse(array_get($this->data, 'start_time'));
        }
        if (array_get($this->data, 'end_time')) {
            $this->user_feedback_specification->end_time = Carbon::parse(array_get($this->data, 'end_time'));
        }
        $this->user_feedback_specification->keyword = array_get($this->data, 'keyword');
    }

}