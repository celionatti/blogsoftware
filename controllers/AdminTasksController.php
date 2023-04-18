<?php

namespace controllers;

use Exception;
use Core\Request;
use models\Tasks;
use models\Users;
use Core\Response;
use Core\Controller;
use Core\Application;
use Core\Support\Helpers\Image;
use Core\Support\Helpers\FileUpload;

class AdminTasksController extends Controller
{
    public $currentUser;

    public function onConstruct(): void
    {
        $this->view->setLayout('admin');
        $this->currentUser = Users::getCurrentUser();
    }

    /**
     * @throws Exception
     */
    public function index(Request $request, Response $response)
    {
        $currentPage = isset($_GET['page']) ? $_GET['page'] : 1;
        $recordsPerPage = 5;

        $params = [
            'conditions' => "status = :status",
            'bind' => ['status' => 'active'],
            'order' => 'created_at DESC',
            'limit' => $recordsPerPage,
            'offset' => ($currentPage - 1) * $recordsPerPage
        ];

        $total = Tasks::findTotal($params);
        $numberOfPages = ceil($total / $recordsPerPage);

        $view = [
            'errors' => [],
            'tasks' => Tasks::find($params),
            'prevPage' => $this->previous_pagination($currentPage),
            'nextPage' => $this->next_pagination($currentPage, $numberOfPages),
        ];

        $this->view->render('admin/tasks/index', $view);
    }

    public function create_task(Request $request, Response $response)
    {
        $task = new Tasks();

        if ($request->isPost()) {
            $task->loadData($request->getBody());
            $upload = new FileUpload('thumbnail');
            $upload->required = true;

            $uploadErrors = $upload->validate();

            if (!empty($uploadErrors)) {
                foreach ($uploadErrors as $field => $error) {
                    $task->setError($field, $error);
                }
            }

            if (empty($task->getErrors())) {
                if ($task->save()) {
                    $upload->directory('uploads/tasks');
                    if (!empty($upload->tmp)) {
                        if ($upload->upload()) {
                            if (file_exists($task->thumbnail)) {
                                unlink($task->thumbnail);
                                $task->thumbnail = "";
                            }
                            $task->thumbnail = $upload->fc;
                            $image = new Image();
                            $image->resize($task->thumbnail);
                            $task->save();
                        }
                    }
                    Application::$app->session->setFlash("success", "{$task->title} Saved successfully.");
                    redirect('/admin/tasks');
                }
            }
        }

        $view = [
            'errors' => $task->getErrors(),
            'task' => $task,
            'typeOpts' => [
                Tasks::TYPE_QUIZ => 'Quiz',
                Tasks::TYPE_CHALLENGE => 'Challenge',
                Tasks::TYPE_COMPETITION => 'Competition'
            ],
            'statusOpts' => [
                Tasks::STATUS_DISABLED => 'Disabled',
                Tasks::STATUS_ACTIVE => 'Active',
            ],
        ];
        $this->view->render('admin/tasks/create', $view);
    }

    public function edit_task(Request $request, Response $response)
    {
        $slug = $request->get('task-slug');

        $params = [
            'conditions' => "slug = :slug",
            'bind' => ['slug' => $slug]
        ];
        $task = Tasks::findFirst($params);

        if ($request->isPatch()) {
            $task->loadData($request->getBody());
            $upload = new FileUpload('thumbnail');

            $uploadErrors = $upload->validate();

            if (!empty($uploadErrors)) {
                foreach ($uploadErrors as $field => $error) {
                    $task->setError($field, $error);
                }
            }

            if (empty($task->getErrors())) {
                if ($task->save()) {
                    $upload->directory('uploads/tasks');
                    if (!empty($upload->tmp)) {
                        if ($upload->upload()) {
                            if (file_exists($task->thumbnail)) {
                                unlink($task->thumbnail);
                                $task->thumbnail = "";
                            }
                            $task->thumbnail = $upload->fc;
                            $image = new Image();
                            $image->resize($task->thumbnail);
                            $task->save();
                        }
                    }
                    Application::$app->session->setFlash("success", "{$task->title} Updated successfully.");
                    redirect('/admin/tasks');
                }
            }
        }

        $view = [
            'errors' => $task->getErrors(),
            'task' => $task,
            'typeOpts' => [
                Tasks::TYPE_QUIZ => 'Quiz',
                Tasks::TYPE_CHALLENGE => 'Challenge',
                Tasks::TYPE_COMPETITION => 'Competition'
            ],
            'statusOpts' => [
                Tasks::STATUS_DISABLED => 'Disabled',
                Tasks::STATUS_ACTIVE => 'Active',
            ],
        ];
        $this->view->render('admin/tasks/edit', $view);
    }

    public function archive_task(Request $request, Response $response)
    {
        $currentPage = isset($_GET['page']) ? $_GET['page'] : 1;
        $recordsPerPage = 5;

        $params = [
            'conditions' => "status = :status",
            'bind' => ['status' => 'disabled'],
            'order' => 'created_at DESC',
            'limit' => $recordsPerPage,
            'offset' => ($currentPage - 1) * $recordsPerPage
        ];

        $total = Tasks::findTotal($params);
        $numberOfPages = ceil($total / $recordsPerPage);

        $view = [
            'errors' => [],
            'tasks' => Tasks::find($params),
            'prevPage' => $this->previous_pagination($currentPage),
            'nextPage' => $this->next_pagination($currentPage, $numberOfPages),
        ];

        $this->view->render('admin/tasks/archive', $view);
    }

    public function trash_task(Request $request, Response $response)
    {
        $params = [
            'conditions' => "slug = :slug",
            'bind' => ['slug' => $request->post('task_slug')]
        ];

        $task = Tasks::findFirst($params);

        if (!$task) {
            Application::$app->session->setFlash("success", "Task Not Found");
            last_uri();
        }

        if ($request->isDelete()) {
            if ($task) {
                if ($task->delete()) {
                    Application::$app->session->setFlash("success", "Task Deleted successfully");
                    last_uri();
                }
            }
        }
    }

    public function view_task(Request $request, Response $response)
    {
        $view = [];

        $this->view->render("admin/tasks/view", $view);
    }
}