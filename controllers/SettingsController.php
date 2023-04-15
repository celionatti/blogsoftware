<?php

namespace controllers;

use Exception;
use Core\Request;
use models\Users;
use Core\Response;
use Core\Controller;
use models\Articles;

class SettingsController extends Controller
{
    public $currentUser;

    public function onConstruct(): void
    {
        $this->view->setLayout('blog');
        $this->currentUser = Users::getCurrentUser();
    }

    /**
     * @throws Exception
     */
    public function index(Request $request, Response $response)
    {
        $featured_params = [
            'columns' => "articles.*, users.username, topics.topic, topics.slug as topic_slug",
            'conditions' => "articles.status = :status AND articles.featured = '1'",
            'bind' => ['status' => 'published'],
            'joins' => [
                ['users', 'articles.user_id = users.uid'],
                ['topics', 'articles.topic = topics.slug', 'topics', 'LEFT']
            ],
            'limit' => "1",
            'order' => 'articles.created_at DESC'
        ];

        $view = [
            'featured' => Articles::findFirst($featured_params),
        ];
        $this->view->render('welcome', $view);
    }
}