<?php

use Core\Database\Migration;

/**
 * Comments Migration. (Comments Table)
 */
class m0005_comments extends Migration
{
    public function up(): void
    {
        $SQL = "CREATE TABLE `comments` (
        `id` bigint(1) NOT NULL AUTO_INCREMENT,
        `article_slug` varchar(300) NOT NULL,
        `user` varchar(300) NOT NULL DEFAULT 'anonymous',
        `message` text NOT NULL,
        `status` varchar(60) NOT NULL DEFAULT 'active',
        `created_at` datetime NOT NULL DEFAULT current_timestamp(),
        `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
        PRIMARY KEY (`id`),
        KEY `article_slug` (`article_slug`),
        KEY `user` (`user`)
        ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4";
        $this->connection->exec($SQL);
    }

    public function down(): void
    {
        $SQL = "DROP TABLE comments;";
        $this->connection->exec($SQL);
    }
}