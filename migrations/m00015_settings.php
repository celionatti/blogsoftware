<?php

use Core\Config;
use Core\Database\Migration;

/**
 * Settings Migration. (Settings Table)
 */
class m00015_settings extends Migration
{
    public function up(): void
    {
        $SQL = "CREATE TABLE `settings` (
        `id` bigint(1) NOT NULL AUTO_INCREMENT,
        `name` varchar(300) NOT NULL,
        `value` text DEFAULT NULL,
        `type` varchar(30) NOT NULL,
        `status` varchar(30) NOT NULL DEFAULT 'disabled',
        `created_at` datetime NOT NULL DEFAULT current_timestamp(),
        `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
        PRIMARY KEY (`id`),
        KEY `name` (`name`),
        KEY `type` (`type`)
        ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4";
        $this->connection->exec($SQL);

        $title = Config::get("title");
        $logo = get_image("", "setting");

        $query = "INSERT INTO `settings` (
            `id`, 
            `name`, 
            `value`, 
            `type`) VALUES 
            (NULL, 'title', '$title', 'text'),
            (NULL, 'logo', '$logo', 'image'),
            (NULL, 'facebook', 'https://www.facebook.com/', 'link'),
            (NULL, 'instagram', 'https://www.instagram.com/', 'link'),
            (NULL, 'twitter', 'https://www.twitter.com/', 'link')
            ";
        $this->connection->exec($query);
    }

    public function down(): void
    {
        $SQL = "DROP TABLE settings;";
        $this->connection->exec($SQL);
    }
}