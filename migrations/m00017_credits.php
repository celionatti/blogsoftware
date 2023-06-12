<?php

use Core\Database\Migration;

/**
 * Credits Migration. (Credits Table)
 */
class m00017_credits extends Migration
{
    public function up(): void
    {
        $SQL = "CREATE TABLE `credits` (
        `id` bigint(1) NOT NULL AUTO_INCREMENT,
        `slug` varchar(300) NOT NULL,
        `wallet_id` varchar(300) NOT NULL,
        `user_id` text DEFAULT NULL,
        `type` varchar(30) NOT NULL DEFAULT 'personal',
        `balance` bigint(20) NOT NULL DEFAULT '0',
        `status` varchar(30) NOT NULL DEFAULT 'disabled',
        `created_at` datetime NOT NULL DEFAULT current_timestamp(),
        `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
        PRIMARY KEY (`id`),
        KEY `wallet_id` (`wallet_id`),
        KEY `type` (`type`),
        INDEX `balance` (`balance`),
        INDEX `slug` (`slug`)
        ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4";
        $this->connection->exec($SQL);
    }

    public function down(): void
    {
        $SQL = "DROP TABLE credits;";
        $this->connection->exec($SQL);
    }
}