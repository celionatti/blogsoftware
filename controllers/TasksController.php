<?php

namespace controllers;

use Exception;
use Core\Request;
use models\Users;
use Core\Response;
use Core\Controller;

class TasksController extends Controller
{
    public $currentUser;

    public function onConstruct(): void
    {
        $this->view->setLayout('task');
        $this->currentUser = Users::getCurrentUser();
    }

    /**
     * @throws Exception
     */
    public function task_registration(Request $request, Response $response)
    {
        $view = [
            
        ];
        $this->view->render('tasks/register', $view);
    }


    /**
     * @throws Exception
     */
    public function quiz(Request $request, Response $response)
    {
        $view = [
            
        ];
        $this->view->render('tasks/quiz', $view);
    }
}