<?php

namespace app\models;

use app\core\Application;
use app\core\Model;

class Login extends Model
{
    public string $email = "";
    public string $password = "";

    public function tableName(): string
    {
        return 'users';
    }

    public function attributes(): array
    {
        return ["email", "password"];
    }

    public function labels(string $attribute): string
    {
        return [
            "email" => "E-mail address",
            "password" => "Password",
        ][$attribute];
    }

    public function rules(): array
    {
        return [
            "email" => [self::RULE_REQUIRED, self::RULE_EMAIL],
            "password" => [self::RULE_REQUIRED],
        ];
    }

    public function login()
    {
        $user = User::Find($this->email);
        if (!$user) {
            return $this->addErrorMessage('email', "This email isn't submitted, try to register or use an other one");
        }

        if (!password_verify($this->password, $user->password)) {
            return $this->addErrorMessage("password", "The password is incorrect");
        }

        return Application::$app->login($user);
    }
}
