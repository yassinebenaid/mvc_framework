<?php

use app\core\Application;

class M0003_get_user_info_procedure
{
    public function up()
    {
        $sql = "CREATE PROCEDURE users_get_user_info(IN _email VARCHAR(255),IN _id INT)
                BEGIN 
                SELECT * FROM users WHERE LOWER(email) = LOWER(_email) OR id = _id;
                END";

        Application::$app->db->pdo->exec($sql);
    }
    public function down()
    {
        $sql = "DROP TABLE IF EXISTS users";

        Application::$app->db->pdo->exec($sql);
    }
}
