<?php

use Core\Database\Migration;

/**
 * Initial Migration. (Articles Table)
 */
class m0002_articles extends Migration
{
    public function up(): void
    {
        $SQL = "CREATE TABLE `articles` (
        `id` bigint(1) NOT NULL AUTO_INCREMENT,
        `slug` varchar(300) NOT NULL,
        `title` varchar(2000) DEFAULT NULL,
        `content` text NOT NULL,
        `topic` varchar(300) NOT NULL,
        `thumbnail` text DEFAULT NULL,
        `author` varchar(300) NOT NULL,
        `featured` tinyint(4) NOT NULL DEFAULT 0,
        `meta_title` varchar(60) NOT NULL,
        `meta_description` varchar(160) NOT NULL,
        `meta_keywords` varchar(60) NOT NULL,
        `status` varchar(15) DEFAULT 'draft',
        `created_at` datetime NOT NULL DEFAULT current_timestamp(),
        `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
        PRIMARY KEY (`id`),
        UNIQUE KEY `slug` (`slug`),
        KEY `topic` (`topic`),
        KEY `title` (`title`)
        ) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4";
        $this->connection->exec($SQL);
    }

    public function down(): void
    {
        $SQL = "DROP TABLE articles;";
        $this->connection->exec($SQL);
    }
}