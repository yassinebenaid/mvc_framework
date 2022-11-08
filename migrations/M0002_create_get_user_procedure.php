<?php

use app\core\Application;

class M0002_create_get_user_procedure
{
    public function up()
    {
        $sql = "CREATE PROCEDURE users_get_user_email(IN _email VARCHAR(255))
                BEGIN 
                SELECT email FROM users WHERE LOWER(email) = LOWER(_email);
                END";

        Application::$app->db->pdo->exec($sql);
    }
    public function down()
    {
        $sql = "DROP TABLE IF EXISTS users";

        Application::$app->db->pdo->exec($sql);
    }
}
