<?php

namespace Huifang\Mobi\Src\Forms\Auth;

use Huifang\Mobi\Src\Forms\Form;
use Huifang\Service\Role\TokenService;
use Huifang\Src\Role\Domain\Exception\LoginException;
use Huifang\Src\Role\Domain\Model\MobileLoginSpecification;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\MessageBag;

class LoginForm extends Form
{
    /**
     * @var MobileLoginSpecification
     */
    public $mobile_login_specification;

    /**
     * Get the validation rules.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'account'  => 'required|string',
            'password' => 'required|string',
            'reg_id'   => 'string',
        ];
    }

    protected function messages()
    {
        return [
            'required'    => ':attribute必填。',
            'date_format' => ':attribute格式错误',
            'integer'     => ':attribute必须是数字',
            'string'      => ':attribute必须是字符串',
        ];
    }

    public function attributes()
    {
        return [
            'provider_id' => '唯一标识',
            'account'     => '账号',
            'password'    => '密码',
        ];
    }

    public function validation()
    {
        $this->mobile_login_specification = new MobileLoginSpecification();
        $this->mobile_login_specification->account = array_get($this->data, 'account');
        $this->mobile_login_specification->password = array_get($this->data, 'password');
        $reg_id = array_get($this->data, 'reg_id');
        if (empty($reg_id) && strcasecmp(trim(TokenService::getDeviceType()), "android") == 0) {
            throw new LoginException(":reg_id必填", LoginException::ERROR_MISS_PARAM);
        }
        $this->mobile_login_specification->reg_id = $reg_id;
        $this->mobile_login_specification->ip = Request::ip();
    }

    /**
     * Handle a failed validation attempt.
     *
     * @param \Illuminate\Support\MessageBag $message
     */
    public function failedValidation(MessageBag $message)
    {
        $msg = '';
        $messages = $this->formatErrors($message);
        if (!empty($messages)) {
            $msg = current(current($messages));
        }
        throw new LoginException(":" . $msg, LoginException::ERROR_MISS_PARAM);
    }

}