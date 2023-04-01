<?php

use Core\Database\Migration;

/**
 * Initial Migration. (Articles Table)
 */
class m0003_topics extends Migration
{
    public function up(): void
    {
        $SQL = "CREATE TABLE `topics` (
        `id` bigint(1) NOT NULL AUTO_INCREMENT,
        `slug` varchar(300) NOT NULL,
        `topic` varchar(80) DEFAULT NULL,
        `status` varchar(60) NOT NULL,
        `created_at` datetime NOT NULL DEFAULT current_timestamp(),
        `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
        PRIMARY KEY (`id`),
        UNIQUE KEY `slug` (`slug`),
        KEY `topic` (`topic`)
        ) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4";
        $this->connection->exec($SQL);
    }

    public function down(): void
    {
        $SQL = "DROP TABLE topics;";
        $this->connection->exec($SQL);
    }
}