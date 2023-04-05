<?php

use Core\Database\Migration;

/**
 * User Session Migration. (User Sessions Table)
 */
class m0004_user_sessions extends Migration
{
    public function up(): void
    {
        $SQL = "CREATE TABLE `user_sessions` (
        `id` bigint(1) NOT NULL AUTO_INCREMENT,
        `user_id` varchar(300) NOT NULL,
        `hash` varchar(300) DEFAULT NULL,
        `ip` varchar(60) NOT NULL,
        `os` varchar(60) NOT NULL,
        PRIMARY KEY (`id`),
        UNIQUE KEY `user_id` (`user_id`),
        KEY `ip` (`ip`),
        KEY `hash` (`hash`)
        ) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4";
        $this->connection->exec($SQL);
    }

    public function down(): void
    {
        $SQL = "DROP TABLE topics;";
        $this->connection->exec($SQL);
    }
}