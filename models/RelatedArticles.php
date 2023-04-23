<?php

namespace models;

use Core\Response;
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

    public static function fetch_related_articles($slug)
    {
        if (!$slug)
            abort(Response::NOT_FOUND);
            
        $params = [
            'columns' => "articles.title, articles.slug, articles.author",
            'conditions' => "related_articles.article_slug = :article_slug AND articles.status = :status",
            'bind' => ['article_slug' => $slug, 'status' => 'published'],
            'joins' => [
                ['articles', 'related_articles.related_slug = articles.slug'],
            ],
            'order' => 'articles.created_at DESC',
            'limit' => '5'
        ];

        $related_articles = RelatedArticles::find($params);
        
        return $related_articles;
    }
}