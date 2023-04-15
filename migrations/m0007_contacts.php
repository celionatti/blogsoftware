<?php

use Core\Database\Migration;

/**
 * Comments Migration. (Comments Table)
 */
class m0007_contacts extends Migration
{
    public function up(): void
    {
        $SQL = "CREATE TABLE `contacts` (
        `id` bigint(1) NOT NULL AUTO_INCREMENT,
        `slug` varchar(300) NOT NULL,
        `name` varchar(300) NOT NULL,
        `email` varchar(300) NOT NULL,
        `subject` varchar(2000) NOT NULL,
        `message` text NOT NULL,
        `created_at` datetime NOT NULL DEFAULT current_timestamp(),
        `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
        PRIMARY KEY (`id`),
        KEY `slug` (`slug`),
        KEY `name` (`name`)
        ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4";
        $this->connection->exec($SQL);
    }

    public function down(): void
    {
        $SQL = "DROP TABLE contacts;";
        $this->connection->exec($SQL);
    }
}