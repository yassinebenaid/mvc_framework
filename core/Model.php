<?php

namespace app\core;

use app\core\database\DatabaseHandler;

abstract class Model
{
    public const RULE_REQUIRED = 111;
    public const RULE_EMAIL    = 112;
    public const RULE_MAX      = 113;
    public const RULE_MIN      = 114;
    public const RULE_MATCH    = 115;
    public const RULE_CONTAIN_SPECIAL_CHARS    = 116;
    public const RULE_UNIQUE    = 117;
    public const RULE_ACCOUNT_EXISTS    = 118;
    public const RULE_CORRECT_PASSWORD    = 118;

    public array $errors = [];
    public \PDO $db;

    public function __construct()
    {
        $this->db = Application::$app->db->pdo;
    }

    abstract protected function rules(): array;

    abstract protected function labels(string $attribute): string;

    public function LoadData(array $data)
    {
        foreach ($data as $key => $value) {
            if (property_exists($this, $key)) {
                $this->{$key} = $value;
            }
        }
    }

    public function Validate()
    {
        foreach ($this->rules() as $attribute => $rules) {
            $value = $this->{$attribute};

            foreach ($rules as $rule) {
                $ruleID = (is_int($rule)) ? $rule : $rule[0];

                if ($ruleID === self::RULE_REQUIRED && !Validator::isNotEmpty($value)) {
                    $this->addError($attribute, self::RULE_REQUIRED);
                }
                if ($ruleID === self::RULE_EMAIL && !Validator::isValidEmail($value)) {
                    $this->addError($attribute, self::RULE_EMAIL);
                }
                if ($ruleID === self::RULE_MAX && !Validator::isLessThan($value, $rule["max"])) {
                    $this->addError($attribute, self::RULE_MAX,  $rule["max"]);
                }
                if ($ruleID === self::RULE_MIN && !Validator::isMoreThan($value, $rule['min'])) {
                    $this->addError($attribute, self::RULE_MIN, $rule["min"]);
                }
                if ($ruleID === self::RULE_MATCH && !Validator::isMatching($value, $this->{$rule["match"]})) {
                    $this->addError($attribute, self::RULE_MATCH,  $rule["match"]);
                }
                if ($ruleID === self::RULE_CONTAIN_SPECIAL_CHARS && !Validator::ContainsSpecials($value)) {
                    $this->addError($attribute, self::RULE_CONTAIN_SPECIAL_CHARS);
                }
            }
        }

        return empty($this->errors);
    }

    private function addError(string $attr, string|int $rule, string|int $replacedValue = '')
    {
        $this->errors[$attr][] = $this->errorMessages($rule, $replacedValue);
        return false;
    }

    protected function addErrorMessage(string $attr, string $message)
    {
        $this->errors[$attr][] = $message;
        return false;
    }

    private function errorMessages(int|string $rule, string|int $replaced = "unknown")
    {
        $message = match ($rule) {
            self::RULE_REQUIRED     => "This field is required !",
            self::RULE_EMAIL        => "This field must be a valid email adress !",
            self::RULE_MAX          => "maximum length for this field is $replaced at most !",
            self::RULE_MIN          => "minimum length for this field is $replaced at least !",
            self::RULE_MATCH        => "This field must match $replaced !",
            self::RULE_CONTAIN_SPECIAL_CHARS => "This field must contains special characters beside capital letters and numbers !",
            self::RULE_UNIQUE => "This $replaced is alredy submitted , try to login or use an other one",
        };

        return $message;
    }
}
