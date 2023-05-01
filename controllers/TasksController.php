<?php

namespace controllers;

use Core\Application;
use Exception;
use Core\Request;
use models\Users;
use Core\Response;
use Core\Controller;
use models\Answers;
use models\Questions;
use models\TaskRegistration;
use models\Tasks;

class TasksController extends Controller
{
    public $currentUser;

    public function onConstruct(): void
    {
        $this->view->setLayout('task');
        $this->currentUser = Users::getCurrentUser();

        if (!$this->currentUser) {
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

        if ($request->isPost()) {
            $taskRegistration = new TaskRegistration();

            $taskRegistration->loadData($request->getBody());

            if ($taskRegistration->save()) {
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

        $task = Tasks::findFirst($params);

        if (!$task) {
            Application::$app->session->setFlash("error", "No Active Task at the moment!");
            last_uri();
        }

        $view = [
            'task' => $task,
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

        if ($this->currentUser->uid !== $user_id) {
            Application::$app->session->setFlash("success", "You do not have permission to view this task");
            redirect("/");
        }

        $currentPage = isset($_GET['page']) ? $_GET['page'] : 1;
        $recordsPerPage = 1;

        $register_params = [
            'conditions' => "user_id = :user_id AND task_id = :task_id AND status = :status",
            'bind' => ['user_id' => $user_id, 'task_id' => $task_id, 'status' => "active"],
        ];

        $registered_users = TaskRegistration::findFirst($register_params);

        if ($registered_users) {
            $task_params = [
                'conditions' => "slug = :slug",
                'bind' => ['slug' => $task_id]
            ];

            $task = Tasks::findFirst($task_params);

            $answers_params = [
                'conditions' => "task_slug = :task_slug",
                'bind' => ['task_slug' => $registered_users->task_slug]
            ];

            $answers = Answers::findTotal($answers_params);

            if ($answers <= (int) $task->limit) {
                $params = [
                    'columns' => "questions.*",
                    'conditions' => "NOT EXISTS (SELECT 1 FROM answers WHERE answers.task_slug = :task_slug)",
                    'bind' => ['task_slug' => $task_id],
                    'joins' => [
                        ['answers', 'questions.task_slug = answers.task_slug', 'answers', 'LEFT'],
                    ],
                    'order' => "RAND()",
                    'limit' => $recordsPerPage,
                    'offset' => ($currentPage - 1) * $recordsPerPage
                ];

                $total = Questions::findTotal($params);
                $numberOfPages = ceil($total / $recordsPerPage);
            }

        }

        $view = [
            'questions' => Questions::find($params),
            'nextPage' => $this->next_pagination($currentPage, $numberOfPages),
        ];
        $this->view->render('tasks/quiz', $view);
    }
}