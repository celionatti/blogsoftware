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
    public function quiz_confirm(Request $request, Response $response)
    {
        $params = [
            'conditions' => "status = :status",
            'bind' => ['status' => "active"],
        ];

        $view = [
            'task' => Tasks::findFirst($params),
            'user' => $this->currentUser,
        ];
        
        $this->view->render('tasks/quiz_confirm', $view);
    }


    /**
     * @throws Exception
     */
    public function quiz(Request $request, Response $response)
    {
        $task_id = $request->get("task_id");
        $user_id = $request->get("user_id");

        if($this->currentUser->uid !== $user_id) {
            Application::$app->session->setFlash("success", "You do not have permission to view this task");
            redirect("/");
        }

        $currentPage = isset($_GET['page']) ? $_GET['page'] : 1;
        $recordsPerPage = 1;

        $params = [
            'columns' => "questions.*",
            'conditions' => "task_registration.user_id = :user_id AND task_registration.status = :status AND questions.task_slug = :task_slug",
            'bind' => ['user_id' => $this->currentUser->uid, 'status' => "active", 'task_slug' => $task_id],
            'joins' => [
                // ['answers', 'questions.slug = answers.question_id'],
                ['questions', 'task_registration.task_slug = questions.task_id', 'questions', 'LEFT'],
            ],
            'limit' => $recordsPerPage,
            'offset' => ($currentPage - 1) * $recordsPerPage
        ];

        $total = TaskRegistration::findTotal($params);
        $numberOfPages = ceil($total / $recordsPerPage);

        $questions = TaskRegistration::find($params);
        dd($questions);

        $view = [
            'prevPage' => $this->previous_pagination($currentPage),
            'nextPage' => $this->next_pagination($currentPage, $numberOfPages),
        ];
        $this->view->render('tasks/quiz', $view);
    }
}