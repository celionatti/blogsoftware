<?php

use Core\Database\Migration;

/**
 * Task Registration Migration. (Task Registration Table)
 */
class m00013_task_registration extends Migration
{
    public function up(): void
    {
        $SQL = "CREATE TABLE `task_registration` (
        `id` bigint(1) NOT NULL AUTO_INCREMENT,
        `task_slug` varchar(300) NOT NULL,
        `user_id` varchar(300) NOT NULL,
        `task_id` varchar(300) NOT NULL,
        `status` varchar(15) DEFAULT 'blocked',
        `created_at` datetime NOT NULL DEFAULT current_timestamp(),
        `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
        PRIMARY KEY (`id`),
        UNIQUE KEY `task_slug` (`task_slug`),
        KEY `user_id` (`user_id`),
        KEY `task_id` (`task_id`)
        ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4";
        $this->connection->exec($SQL);
    }

    public function down(): void
    {
        $SQL = "DROP TABLE task_registration;";
        $this->connection->exec($SQL);
    }
}