<?php

namespace controllers;

use Exception;
use Core\Request;
use models\Users;
use Core\Response;
use Core\Controller;
use models\Articles;

class SiteController extends Controller
{
    public function onConstruct(): void
    {
        $this->view->setLayout('blog');
    }

    /**
     * @throws Exception
     */
    public function index(Request $request, Response $response)
    {
        $view = [
            'users' => Users::find(),
        ];
        $this->view->render('welcome', $view);
    }

    public function news(Request $request, Response $response)
    {
        $params = [
            'columns' => "articles.*, users.username, users.avatar, topics.topic, topics.slug as topic_slug",
            'conditions' => "articles.status = :status",
            'bind' => ['status' => 'published'],
            'joins' => [
                ['users', 'articles.user_id = users.uid'],
                ['topics', 'articles.topic = topics.slug', 'topics', 'LEFT']
            ],
            'order' => 'articles.id DESC'
        ];

        $params = Articles::mergeWithPagination($params);
        $total = Articles::findTotal($params);

        $view = [
            'articles' => Articles::find($params),
            'total' => $total,
        ];
        $this->view->render('news', $view);
    }

    public function read(Request $request, Response $response)
    {
        $slug = $request->get('slug');

        $params = [
            'columns' => "articles.*, users.username",
            'conditions' => "slug = :slug AND status = :status",
            'bind' => ['status' => 'published', 'slug' => $slug],
            'joins' => [
                ['users', 'articles.user_id = users.uid'],
            ],
            'order' => 'id DESC'
        ];

        $article = Articles::findFirst($params);
        if (!$article)
            abort(Response::NOT_FOUND);

        $view = [
            'article' => $article,
        ];
        $this->view->render('read', $view);
    }

    public function contact(Request $request, Response $response)
    {
        $view = [
            'errors' => [],
        ];
        $this->view->render('contact', $view);
    }
}