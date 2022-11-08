<?php

namespace app\core\database;

use app\core\Application;

class DatabaseHandler
{
    public readonly \PDO $pdo;


    public function __construct(array $config)
    {
        $db = Database::GetInstance();
        $this->pdo = $db->Connect($config);
    }

    public function ApplyMigrations()
    {
        $this->createMigrationsTable();
        $appliedMigrations = $this->GetAppliedMigrations();
        $migrationFiles = $this->GetMigrationsFiles();

        if (sizeof($migrationFiles) < 1) {
            $this->log("No Migrations files to be applied !!!");
            exit;
        }

        $migrations_to_be_executed = array_diff($migrationFiles, $appliedMigrations);

        $migration_was_applied = [];

        foreach ($migrations_to_be_executed as $migration) {
            $className = pathinfo($migration, PATHINFO_FILENAME);
            require_once Application::$ROOT_DIR . "/migrations/" . $migration;

            $obj = new $className();
            $this->log("apply $className");
            $obj->up();
            $migration_was_applied[] = $migration;
        }

        if (!empty($migration_was_applied)) {
            $this->saveMigrations($migration_was_applied);
            $this->log("migrations has been applied successfully");
        } else {
            $this->log("All migrations are applied");
        }
    }

    private function GetMigrationsFiles()
    {
        $files = scandir(Application::$ROOT_DIR . "/migrations");
        $files = array_filter($files, fn ($el) => $el !== "." && $el !== "..");
        return $files;
    }

    private function createMigrationsTable()
    {
        $sql = "CREATE TABLE IF NOT EXISTS migrations (id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
                migration VARCHAR(255) NOT NULL,created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP)ENGINE=INNODB;";
        $this->pdo->exec($sql);
    }

    private function GetAppliedMigrations()
    {
        $statment = $this->pdo->prepare("SELECT migration FROM migrations");
        $statment->execute();
        return $statment->fetchAll(\PDO::FETCH_COLUMN);
    }

    private function saveMigrations(array $migrations)
    {
        $records = implode(" , ", array_map(fn ($el) => "('$el')", $migrations));
        $sql = "INSERT INTO migrations (migration) VALUES $records";
        $this->pdo->prepare($sql)->execute();
    }

    private function log(string $message)
    {
        sleep(1);
        echo "[" . date("y-m-d H:i:s") . "] -  $message" . PHP_EOL;
    }

    public function __destruct()
    {
        $db = Database::GetInstance();
        $db->Disconnect();
    }
}
