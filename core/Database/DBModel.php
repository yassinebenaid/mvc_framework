<?php

namespace app\core\database;

use app\core\Model;

abstract class DBModel extends Model
{

    abstract public function tableName(): string;
    abstract public function attributes(): array;
    abstract public function primaryKey(): string;
    abstract public static function Find(): object;
    abstract public  function GetUserInfo(): string;

    public function save()
    {
        $table = $this->tableName();
        $attributes =  $this->attributes();
        $columns = implode(', ', $attributes);
        $params = implode(", ", array_map(fn ($el) => ":$el", $attributes));

        $statment = $this->db->prepare("INSERT INTO $table ($columns) VALUES ($params)");

        foreach ($attributes as $attr) {
            $statment->bindValue(":$attr", $this->{$attr});
        }

        return $statment->execute();
    }

    public function Hash(string $attribute)
    {
        $this->{$attribute} = password_hash($this->{$attribute}, PASSWORD_ARGON2ID);
    }
}
