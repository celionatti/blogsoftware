<?php

namespace controllers;

use Exception;
use Core\Request;
use models\Users;
use Core\Response;
use Core\Controller;

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