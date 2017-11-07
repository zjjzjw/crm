<?php

namespace Huifang\Web\Src\Forms\User;

use Huifang\Src\Role\Domain\Model\UserEntity;
use Huifang\Src\Role\Domain\Model\UserFeedbackEntity;
use Huifang\Src\Role\Infra\Repository\UserRepository;
use Huifang\Src\Sale\Domain\Model\SaleEntity;
use Huifang\Web\Src\Forms\Form;

class UserFeedbackStoreForm extends Form
{

    /**
     * @var UserFeedbackEntity
     */
    public $user_feedback_entity;

    /**
     * Get the validation rules.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'content' => 'required|string',
        ];
    }


    protected function messages()
    {
        return [
            'required'    => ':attribute必填。',
            'date_format' => ':attribute格式错误',
            'integer'     => ':attribute整型',
            'string'      => ':attribute字符串',
        ];
    }

    public function attributes()
    {
        return [
            'content' => '反馈内容',
        ];
    }

    public function validation()
    {
        $this->user_feedback_entity = new UserFeedbackEntity();
        $this->user_feedback_entity->content = array_get($this->data, 'content');
        $user = request()->user();
        $this->user_feedback_entity->user_id = $user->id;
        $user_repository = new UserRepository();
        /** @var UserEntity $user_entity */
        $user_entity = $user_repository->fetch($user->id);
        $this->user_feedback_entity->contact = $user_entity->phone;

    }


}