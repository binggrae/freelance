<?php


namespace core\forms;


use yii\base\Model;

/**
 * Class LoginForm
 * @package core\forms\power
 * @property array $postData
 */
class LoginForm extends Model
{

    public $login;
    public $password;

    public $proxy;

    public $remember_me = 1;

    public function rules()
    {
        return [
            [['login', 'password'], 'required'],
        ];
    }

    public function getPostData()
    {
        return [
            'proxy' => $this->proxy,
            'login' => $this->login,
            'password' => $this->password,
            'remember_me' => $this->remember_me,
            '_qf__login_form' => '',
            'save' => '',
        ];
    }
}