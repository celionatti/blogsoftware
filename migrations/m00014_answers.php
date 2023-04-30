<?php

use Core\Database\Migration;

/**
 * Answers Migration. (Answers Table)
 */
class m00014_answers extends Migration
{
    public function up(): void
    {
        $SQL = "CREATE TABLE `answers` (
        `id` bigint(1) NOT NULL AUTO_INCREMENT,
        `task_slug` varchar(300) NOT NULL,
        `question_id` varchar(300) NOT NULL,
        `answer` text DEFAULT NULL,
        `created_at` datetime NOT NULL DEFAULT current_timestamp(),
        `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
        PRIMARY KEY (`id`),
        KEY `question_id` (`question_id`),
        KEY `task_slug` (`task_slug`)
        ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4";
        $this->connection->exec($SQL);
    }

    public function down(): void
    {
        $SQL = "DROP TABLE answers;";
        $this->connection->exec($SQL);
    }
}