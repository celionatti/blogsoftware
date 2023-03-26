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

    public function create_article(Request $request, Response $response)
    {
        $view = [
            'errors' => []
        ];

        $this->view->render('admin/articles/create', $view);
    }
}