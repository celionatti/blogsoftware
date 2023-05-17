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
    private $currentTime;

    public function onConstruct(): void
    {
        $this->view->setLayout('task');
        $this->currentUser = Users::getCurrentUser();

        if (!$this->currentUser) {
            Application::$app->session->setFlash("success", "Create Account First!");
            redirect("/");
        }

        $this->currentTime = time();
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
        if ($this->session->exists("task_user")) {
            Application::$app->session->setFlash("error", "Something went wrong, Contact Admin!");
            last_uri();
        }

        $params = [
            'conditions' => "status = :status",
            'bind' => ['status' => "active"],
        ];

        $task = Tasks::findFirst($params);

        if (!$task) {
            Application::$app->session->setFlash("error", "No Active Task at the moment!");
            last_uri();
        }

        $reg_params = [
            'conditions' => "user_id = :user_id AND task_id = :task_id AND status = :status",
            'bind' => ['user_id' => $this->currentUser->uid, 'task_id' => $task->slug, 'status' => "active"],
        ];

        $reg_user = TaskRegistration::findFirst($reg_params);

        if($reg_user) {
            if ($this->session->exists("start_time")) {
                $this->session->remove("start_time"); // Delete the start time.
                $this->session->remove("total_time");
                $this->session->remove("remaining_time");
            }
            $this->session->set("task_user", $reg_user->task_slug);

            $this->session->set("start_time", time()); // Set the start time to the current time

            $this->session->set("total_time", 60 * $task->time);
        } else {
            Application::$app->session->setFlash("error", "Task already attempted, if not contact Admin!");
            redirect("/");
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
        $currentPage = isset($_GET['page']) ? $_GET['page'] : 1;
        $recordsPerPage = 1;
        $task_id = $request->get("task_id");
        $user_id = $request->get("user_id");

        $task_user = $this->session->get("task_user");

        $start_time = $this->session->get("start_time");
        $total_time = $this->session->get("total_time");
        $remaining_time = $this->session->get("remaining_time");

        if (!$task_user) {
            Application::$app->session->setFlash("error", "Something went wrong, Contact Admin!");
            redirect("/quiz/confirm");
        }

        if($request->isGet()) {
            $task_params = [
                'conditions' => "slug = :slug",
                'bind' => ['slug' => $task_id]
            ];

            $task = Tasks::findFirst($task_params);

            if($remaining_time && $remaining_time <= 0) {
                $this->quiz_submit();
            }

            $answers_params = [
                'conditions' => "task_slug = :task_slug",
                'bind' => ['task_slug' => $task_user]
            ];

            $answers_total = Answers::findTotal($answers_params);

            if ($answers_total <= (int) $task->limit) {
                /** 
                 * Fecthing the questions.
                 * 
                 */
                $params = [
                    'columns' => "questions.*",
                    'conditions' => "NOT EXISTS (SELECT 1 FROM answers WHERE answers.question_id = questions.slug)",
                    // 'bind' => ['question_id' => $task_user],
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

            $elapsed_time = $this->currentTime - $start_time;

            $this->session->set("remaining_time", $total_time - $elapsed_time); // Store the remaining time in a session variable

        }

        $answer = new Answers();

        if($request->isPost()) {
            $answer->loadData($request->getBody());
            $answer->task_slug = $task_user;
            
            if($answer->save()) {
                Application::$app->session->setFlash("success", "Question saved!");
                redirect("/quiz?task_id={$task_id}&user_id={$user_id}");
            }
        }

        $view = [
            'errors' => [],
            'questions' => Questions::find($params),
            'answers_total' => $answers_total,
            'total_questions' => $task->limit,
            'task_id' => $task_id,
            'user_id' => $user_id,
            'time' => $remaining_time,
        ];
        $this->view->render('tasks/quiz', $view);
    }

    public function quiz_submit()
    {
        $task_user = $this->session->get("task_user");

        if($task_user) {
            $params = [
                'conditions' => "task_slug = :task_slug",
                'bind' => ['task_slug' => $task_user]
            ];

            $regUser = TaskRegistration::findFirst($params);
            
            if($regUser) {
                $regUser->status = "disabled";

                if($regUser->save()) {
                    $this->session->remove("task_user");
                    $this->session->remove("start_time");
                    $this->session->remove("total_time");
                    $this->session->remove("remaining_time");

                    Application::$app->session->setFlash("success", "Quiz Submitted Successfully. Thanks!");
                    redirect("/");
                }
            }
        } else {
            Application::$app->session->setFlash("success", "Something went wrong, contact Admin!");
            redirect("/");
        }
    }
}