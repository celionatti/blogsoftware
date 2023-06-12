<?php

use Core\Database\Migration;

/**
 * Transactions Migration. (Transactions Table)
 */
class m00018_transactions extends Migration
{
    public function up(): void
    {
        $SQL = "CREATE TABLE `transactions` (
        `id` bigint(1) NOT NULL AUTO_INCREMENT,
        `slug` varchar(300) NOT NULL,
        `to` varchar(300) DEFAULT NULL,
        `from` varchar(300) DEFAULT NULL,
        `amount` bigint(20) NOT NULL DEFAULT '0',
        `method` varchar(30) NOT NULL DEFAULT 'credit',
        `details` text DEFAULT NULL,
        `status` varchar(30) NOT NULL DEFAULT 'disabled',
        `created_at` datetime NOT NULL DEFAULT current_timestamp(),
        `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
        PRIMARY KEY (`id`),
        KEY `to` (`to`),
        KEY `from` (`from`),
        INDEX `method` (`method`),
        INDEX `slug` (`slug`)
        ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4";
        $this->connection->exec($SQL);
    }

    public function down(): void
    {
        $SQL = "DROP TABLE transactions;";
        $this->connection->exec($SQL);
    }
}