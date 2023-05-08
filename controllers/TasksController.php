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

        if ($this->session->exists("start_time")) {
            $this->session->remove("start_time"); // Delete the start time.
            $this->session->remove("total_time");
            $this->session->remove("remaining_time");
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
        if($request->isPost()) {
            $task_id = $request->get("task_id");
            $user_id = $request->get("user_id");

            $reg_params = [
                'conditions' => "user_id = :user_id AND task_id = :task_id AND status = :status",
                'bind' => ['user_id' => $user_id, 'task_id' => $task_id, 'status' => "active"],
            ];

            $reg_user = TaskRegistration::findFirst($reg_params);

            if($reg_user) {
                $remaining_time = $this->session->get("remaining_time");
                $task_user= $this->session->get("task_user");

                if(! $task_user) {
                    $task_user = $this->session->set("task_user", $reg_user->task_slug);
                }

                /**
                 * Checking is Time is out.
                 */
                if ($remaining_time && $remaining_time <= 0) {
                    dd("Quiz is done with. Thanks");
                }

                /**
                 * Count the numbers of questions that are answered by the user.
                 * So as to limit it to the number of questions in tasks.
                 */
                $task_params = [
                    'conditions' => "slug = :slug",
                    'bind' => ['slug' => $task_id]
                ];

                $task = Tasks::findFirst($task_params);

                $answers_params = [
                    'conditions' => "task_slug = :task_slug",
                    'bind' => ['task_slug' => $reg_user->task_slug]
                ];

                $answers_total = Answers::findTotal($answers_params);
                
                 if ($answers_total >= (int) $task->limit) {

                 }
            }

        }
    }

    private function submit_quiz(Request $request, Response $response)
    {
        
    }
}