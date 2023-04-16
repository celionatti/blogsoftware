<?php

use Core\Database\Migration;

/**
 * Related Articles Migration. (Related Articles Table)
 */
class m0008_related_articles extends Migration
{
    public function up(): void
    {
        $SQL = "CREATE TABLE `related_articles` (
        `id` bigint(1) NOT NULL AUTO_INCREMENT,
        `article_slug` varchar(300) NOT NULL,
        `related_slug` varchar(300) NOT NULL,
        `created_at` datetime NOT NULL DEFAULT current_timestamp(),
        `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
        PRIMARY KEY (`id`),
        KEY `article_slug` (`article_slug`),
        KEY `related_slug` (`related_slug`)
        ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4";
        $this->connection->exec($SQL);
    }

    public function down(): void
    {
        $SQL = "DROP TABLE related_articles;";
        $this->connection->exec($SQL);
    }
}