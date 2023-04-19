<?php

use Core\Database\Migration;

/**
 * Questions Migration. (Questions Table)
 */
class m00010_questions extends Migration
{
    public function up(): void
    {
        $SQL = "CREATE TABLE `questions` (
        `id` bigint(1) NOT NULL AUTO_INCREMENT,
        `slug` varchar(300) NOT NULL,
        `task_slug` varchar(300) NOT NULL,
        `question` text NOT NULL,
        `image` text DEFAULT NULL,
        `type` varchar(30) NOT NULL,
        `correct_answer` varchar(300) NULL,
        `opt_one` varchar(300) NOT NULL,
        `opt_two` varchar(300) NOT NULL,
        `opt_three` varchar(300) NOT NULL,
        `opt_four` varchar(300) NOT NULL,
        `user` varchar(300) NOT NULL,
        `comment` varchar(300) NULL,
        `created_at` datetime NOT NULL DEFAULT current_timestamp(),
        `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
        PRIMARY KEY (`id`),
        UNIQUE KEY `slug` (`slug`),
        KEY `type` (`type`),
        KEY `user` (`user`)
        ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4";
        $this->connection->exec($SQL);
    }

    public function down(): void
    {
        $SQL = "DROP TABLE questions;";
        $this->connection->exec($SQL);
    }
}