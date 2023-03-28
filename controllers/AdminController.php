<?php

namespace controllers;

use Core\Controller;
use Core\Request;
use Core\Response;
use Exception;
use models\Users;

class AdminController extends Controller
{
    public function onConstruct(): void
    {
        $this->view->setLayout('admin');
    }

    /**
     * @throws Exception
     */
    public function index(Request $request, Response $response)
    {
        $view = [
            'users' => Users::find(),
        ];
        $this->view->render('admin/dashboard', $view);
    }

    public function articles(Request $request, Response $response)
    {
        $view = [
            'errors' => []
        ];

        $this->view->render('admin/articles/index', $view);
    }

    public function create_article(Request $request, Response $response)
    {
        $view = [
            'errors' => [],
            'statusOpts' => [
                '' => '--- Please Select ---',
                'published' => 'Published',
                'draft' => 'Draft'
            ],
        ];

        $this->view->render('admin/articles/create', $view);
    }

    public function users(Request $request, Response $response)
    {
        $view = [
            'errors' => []
        ];

        $this->view->render('admin/users/index', $view);
    }

    public function create_user(Request $request, Response $response)
    {
        $view = [
            'errors' => [],
            'aclOpts' => [
                '' => '--- Please Select ---',
                'guest' => 'Guest',
                'author' => 'Author',
                'admin' => 'Admin'
            ],
        ];

        $this->view->render('admin/users/create', $view);
    }

    public function topics(Request $request, Response $response)
    {
        $view = [
            'errors' => []
        ];

        $this->view->render('admin/topics/index', $view);
    }

    public function create_topic(Request $request, Response $response)
    {
        $view = [
            'errors' => [],
            'statusOpts' => [
                '' => '--- Please Select ---',
                'disabled' => 'Disabled',
                'active' => 'Active',
            ],
        ];

        $this->view->render('admin/topics/create', $view);
    }
}