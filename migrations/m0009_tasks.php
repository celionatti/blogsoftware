<?php

use Core\Database\Migration;

/**
 * Tasks Migration. (Tasks Table)
 */
class m0009_tasks extends Migration
{
    public function up(): void
    {
        $SQL = "CREATE TABLE `tasks` (
        `id` bigint(1) NOT NULL AUTO_INCREMENT,
        `slug` varchar(300) NOT NULL,
        `type` varchar(30) NOT NULL,
        `title` varchar(300) NOT NULL,
        `thumbnail` text DEFAULT NULL,
        `time` varchar(300) NULL,
        `editable` varchar(10) NOT NULL DEFAULT 'yes',
        `instruction` varchar(300) NOT NULL,
        `status` varchar(10) NOT NULL DEFAULT 'disabled',
        `created_at` datetime NOT NULL DEFAULT current_timestamp(),
        `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
        PRIMARY KEY (`id`),
        UNIQUE KEY `slug` (`slug`),
        KEY `type` (`type`),
        KEY `title` (`title`)
        ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4";
        $this->connection->exec($SQL);
    }

    public function down(): void
    {
        $SQL = "DROP TABLE tasks;";
        $this->connection->exec($SQL);
    }
}