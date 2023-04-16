<?php

namespace models;

use Core\Database\DbModel;

class RelatedArticles extends DbModel
{
    public string $article_slug = "";
    public string $related_slug = "";
    public string $created_at = "";
    public string $updated_at = "";

    public static function tableName(): string
    {
        return 'related_articles';
    }

    public function beforeSave(): void
    {
        $this->timeStamps();
    }

    public static function add_related_articles($slug)
    {
        $params = [
            'conditions' => "related_slug = :related_slug",
            'bind' => ['related_slug' => $slug]
        ];

        $related = RelatedArticles::findFirst($params);

        if (!$related) {
            return true;
        }

        return false;
    }
}