<?php

namespace controllers;

use Exception;
use Core\Request;
use models\Users;
use Core\Response;
use Core\Controller;
use models\Articles;
use models\Settings;
use Core\Application;

class DocsController extends Controller
{
    public $currentUser;

    public function onConstruct(): void
    {
        $this->view->setLayout('default');
    }

    /**
     * @throws Exception
     */
    public function policy(Request $request, Response $response)
    {
        $view = [
            
        ];
        $this->view->render('docs/policy', $view);
    }
}