<?php

namespace app\models;

use app\core\Application;
use app\core\database\DBModel;


class User extends DBModel
{
    public string $firstname = "";
    public string $lastname = "";
    public string $email = "";
    public string $password = "";
    public string $confirmPassword = "";

    protected function rules(): array
    {
        return [
            'firstname' => [self::RULE_REQUIRED],
            'lastname' => [self::RULE_REQUIRED],
            'email' => [self::RULE_REQUIRED, self::RULE_EMAIL],
            'password' => [self::RULE_REQUIRED, [self::RULE_MAX, "max" => 26], [self::RULE_MIN, "min" => 8], self::RULE_CONTAIN_SPECIAL_CHARS],
            'confirmPassword' => [self::RULE_REQUIRED, [self::RULE_MATCH, "match" => 'password']],
        ];
    }

    public function primaryKey(): string
    {
        return "id";
    }

    public function tableName(): string
    {
        return "users";
    }

    public function labels(string $attribute): string
    {
        $labels =  [
            "firstname" => "First Name",
            "lastname" => "Last Name",
            "email" => "E-Mail Address",
            "password" => "Password",
            "confirmPassword" => "Confirmed Password",
        ];
        return $labels[$attribute];
    }

    public function attributes(): array
    {
        return [
            "firstname",
            "lastname",
            "email",
            "password",
        ];
    }

    public function register()
    {
        if ($this->Exists($this->email)) {
            $this->addErrorMessage("email", "this email is already submitted, try to login or use an other one");
            return false;
        }
        $this->hash("password");
        return $this->save();
    }

    public  function Exists(string $email = '', int|string $id = '')
    {
        $sql = "CALL users_get_user_email(:email,:id)";
        $statment = $this->db->prepare($sql);
        $statment->execute([":email" => $email, ":id" => '']);
        return $statment->fetch();
    }


    public static function Find(string $email = '', string|int $id = ""): object
    {
        $user = new self;
        $table = $user->tableName();
        $sql = "CALL users_get_user_info(:email,:id)";
        $statmant = $user->db->prepare($sql);
        $statmant->execute([':email' => $email, ":id" => $id]);
        return $statmant->fetchObject(static::class);
    }

    public function GetUserInfo(string ...$attributes): string
    {
        $data = "";
        if (!Application::$app->IsGest()) {
            foreach ($attributes as $attr) {
                $data .= $this->{$attr} . " ";
            }
            return $data;
        }
        return "unknown";
    }
}
