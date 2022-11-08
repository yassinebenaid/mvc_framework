<?php

use app\core\Application;

class M0001_users
{
    public function up()
    {
        $sql = "CREATE TABLE IF NOT EXISTS users (
            id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
            firstname VARCHAR(255) NOT NULL,
            lastname VARCHAR(255) NOT NULL,
            email VARCHAR(255) NOT NULL,
            password VARCHAR(255) NOT NULL
        )ENGINE=INNODB;";

        Application::$app->db->pdo->exec($sql);
    }
    public function down()
    {
        $sql = "DROP TABLE IF EXISTS users";

        Application::$app->db->pdo->exec($sql);
    }
}
