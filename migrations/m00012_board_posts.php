<?php

use Core\Database\Migration;

/**
 * Board Posts Migration. (Board Posts Table)
 */
class m00012_board_posts extends Migration
{
    public function up(): void
    {
        $SQL = "CREATE TABLE `board_posts` (
        `id` bigint(1) NOT NULL AUTO_INCREMENT,
        `slug` varchar(300) NOT NULL,
        `title` varchar(2000) DEFAULT NULL,
        `content` text NOT NULL,
        `thumbnail` text DEFAULT NULL,
        `thumbnail_caption` text DEFAULT NULL,
        `user_id` varchar(300) NOT NULL,
        `author` varchar(300) NOT NULL,
        `meta_title` varchar(60) NOT NULL,
        `meta_description` varchar(160) NOT NULL,
        `meta_keywords` varchar(60) NOT NULL,
        `status` varchar(15) DEFAULT 'disabled',
        `created_at` datetime NOT NULL DEFAULT current_timestamp(),
        `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
        PRIMARY KEY (`id`),
        UNIQUE KEY `slug` (`slug`),
        KEY `title` (`title`)
        ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4";
        $this->connection->exec($SQL);
    }

    public function down(): void
    {
        $SQL = "DROP TABLE board_posts;";
        $this->connection->exec($SQL);
    }
}