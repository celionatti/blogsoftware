<?php

namespace controllers;

use Core\Controller;
use Core\Request;
use Core\Response;
use Exception;
use models\Users;

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
}