<?php

use Core\Database\Migration;

/**
 * Credit_withdraw Migration. (Credit_withdraw Table)
 */
class m00018_credit_withdraws extends Migration
{
    public function up(): void
    {
        $SQL = "CREATE TABLE `credit_withdraws` (
        `id` bigint(1) NOT NULL AUTO_INCREMENT,
        `slug` varchar(300) NOT NULL,
        `wallet_id` varchar(300) DEFAULT NULL,
        `user_id` varchar(300) DEFAULT NULL,
        `amount` bigint(20) NOT NULL DEFAULT '0',
        `details` text DEFAULT NULL,
        `status` varchar(30) NOT NULL DEFAULT 'disabled',
        `created_at` datetime NOT NULL DEFAULT current_timestamp(),
        `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
        PRIMARY KEY (`id`),
        KEY `wallet_id` (`wallet_id`),
        KEY `user_id` (`user_id`),
        INDEX `slug` (`slug`)
        ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4";
        $this->connection->exec($SQL);
    }

    public function down(): void
    {
        $SQL = "DROP TABLE credit_withdraws;";
        $this->connection->exec($SQL);
    }
}