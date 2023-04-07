<?php

use Core\Database\Migration;

/**
 * Comment Replies Migration. (Comment Replies Table)
 */
class m0006_comment_replies extends Migration
{
    public function up(): void
    {
        $SQL = "CREATE TABLE `comment_replies` (
        `id` bigint(1) NOT NULL AUTO_INCREMENT,
        `comment_id` varchar(300) NOT NULL,
        `user` varchar(300) NOT NULL DEFAULT 'anonymous',
        `message` text NOT NULL,
        `status` varchar(60) NOT NULL DEFAULT 'active',
        `created_at` datetime NOT NULL DEFAULT current_timestamp(),
        `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
        PRIMARY KEY (`id`),
        KEY `comment_id` (`comment_id`),
        KEY `user` (`user`)
        ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4";
        $this->connection->exec($SQL);
    }

    public function down(): void
    {
        $SQL = "DROP TABLE comment_replies;";
        $this->connection->exec($SQL);
    }
}