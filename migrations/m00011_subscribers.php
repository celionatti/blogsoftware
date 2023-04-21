<?php

use Core\Database\Migration;

/**
 * Subscribers Migration. (Subscribers Table)
 */
class m00011_subscribers extends Migration
{
    public function up(): void
    {
        $SQL = "CREATE TABLE `subscribers` (
        `id` bigint(1) NOT NULL AUTO_INCREMENT,
        `slug` varchar(300) NOT NULL,
        `email` varchar(700) NOT NULL,
        `status` varchar(30) NOT NULL DEFAULT 'active',
        `created_at` datetime NOT NULL DEFAULT current_timestamp(),
        `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
        PRIMARY KEY (`id`),
        UNIQUE KEY `slug` (`slug`),
        KEY `email` (`email`)
        ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4";
        $this->connection->exec($SQL);
    }

    public function down(): void
    {
        $SQL = "DROP TABLE subscribers;";
        $this->connection->exec($SQL);
    }
}