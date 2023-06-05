<?php

use Core\Database\Migration;

/**
 * Ratings Migration. (Ratings Table)
 */
class m00016_ratings extends Migration
{
    public function up(): void
    {
        $SQL = "CREATE TABLE `ratings` (
        `id` bigint(1) NOT NULL AUTO_INCREMENT,
        `name` varchar(300) NOT NULL,
        `rating` varchar(300) NOT NULL,
        `review` text DEFAULT NULL,
        `created_at` datetime NOT NULL DEFAULT current_timestamp(),
        `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
        PRIMARY KEY (`id`),
        KEY `name` (`name`),
        KEY `rating` (`rating`)
        ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4";
        $this->connection->exec($SQL);
    }

    public function down(): void
    {
        $SQL = "DROP TABLE ratings;";
        $this->connection->exec($SQL);
    }
}