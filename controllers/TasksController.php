<?php

namespace controllers;

use Core\Application;
use Exception;
use Core\Request;
use models\Users;
use Core\Response;
use Core\Controller;
use models\TaskRegistration;
use models\Tasks;

class TasksController extends Controller
{
    public $currentUser;

    public function onConstruct(): void
    {
        $this->view->setLayout('task');
        $this->currentUser = Users::getCurrentUser();

        if(! $this->currentUser) {
            Application::$app->session->setFlash("success", "Create Account First!");
            redirect("/");
        }
    }

    /**
     * @throws Exception
     */
    public function task_registration(Request $request, Response $response)
    {
        $params = [
            'conditions' => "status = :status",
            'bind' => ['status' => "active"]
        ];

        if($request->isPost()) {
            $taskRegistration = new TaskRegistration();

            $taskRegistration->loadData($request->getBody());

            if($taskRegistration->save()) {
                Application::$app->session->setFlash("success", "Task Registration Successful!");
                redirect("/");
            }
        }

        $task = Tasks::findFirst($params);
        $view = [
            'task' => $task,
            'user' => $this->currentUser
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