<?php

namespace controllers;

use Exception;
use Core\Request;
use models\Tasks;
use models\Users;
use Core\Response;
use Core\Controller;
use Core\Application;
use models\Questions;
use models\TaskRegistration;
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
            'navigations' => [
                ['label' => 'Dashboard', 'url' => 'admin'],
                ['label' => 'Tasks', 'url' => ''],
            ],
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
            'navigations' => [
                ['label' => 'Dashboard', 'url' => 'admin'],
                ['label' => 'Tasks', 'url' => 'admin/tasks'],
                ['label' => 'Create Task', 'url' => ''],
            ],
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
            'navigations' => [
                ['label' => 'Dashboard', 'url' => 'admin'],
                ['label' => 'Tasks', 'url' => 'admin/tasks'],
                ['label' => 'Edit Task', 'url' => ''],
            ],
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
            'navigations' => [
                ['label' => 'Dashboard', 'url' => 'admin'],
                ['label' => 'Tasks', 'url' => 'admin/tasks'],
                ['label' => 'Archive Tasks', 'url' => ''],
            ],
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
        $slug = $request->get("task-slug");

        $params = [
            'conditions' => "slug = :slug",
            'bind' => ['slug' => $slug]
        ];

        $view = [
            'navigations' => [
                ['label' => 'Dashboard', 'url' => 'admin'],
                ['label' => 'Tasks', 'url' => 'admin/tasks'],
                ['label' => 'Task Details', 'url' => ''],
            ],
            'task' => Tasks::findFirst($params)
        ];

        $this->view->render("admin/tasks/view", $view);
    }

    public function participants(Request $request, Response $response)
    {
        $task_slug = $request->get("task-slug");
        $currentPage = isset($_GET['page']) ? $_GET['page'] : 1;
        $recordsPerPage = 5;

        $task_params = [
            'conditions' => "slug = :slug",
            'bind' => ['slug' => $task_slug]
        ];

        $params = [
            'columns' => "task_registration.task_slug, task_registration.status, users.surname, users.name",
            'conditions' => "task_id = :task_id",
            'bind' => ['task_id' => $task_slug],
            'joins' => [
                ['users', 'task_registration.user_id = users.uid'],
            ],
            'order' => 'task_registration.created_at DESC',
            'limit' => $recordsPerPage,
            'offset' => ($currentPage - 1) * $recordsPerPage
        ];

        $total = TaskRegistration::findTotal($params);
        $numberOfPages = ceil($total / $recordsPerPage);

        $view = [
            'navigations' => [
                ['label' => 'Dashboard', 'url' => 'admin'],
                ['label' => 'Tasks', 'url' => 'admin/tasks'],
                ['label' => 'Task Participants', 'url' => ''],
            ],
            'errors' => [],
            'task' => Tasks::findFirst($task_params),
            'participants' => TaskRegistration::find($params),
            'prevPage' => $this->previous_pagination($currentPage),
            'nextPage' => $this->next_pagination($currentPage, $numberOfPages),
        ];

        $this->view->render("admin/tasks/participants", $view);
    }

    public function participant_status(Request $request, Response $response)
    {
        if($request->isPatch()) {
            $params = [
                'conditions' => "task_slug = :task_slug",
                'bind' => ['task_slug' => $request->post('task_slug')]
            ];

            $participant = TaskRegistration::findFirst($params);

            if(!$participant) {
                Application::$app->session->setFlash("success", "Participant Not Found");
                last_uri();
            }

            if ($participant) {
                $participant->loadData($request->getBody());
                if ($participant->save()) {
                    Application::$app->session->setFlash("success", "Participant Updated successfully");
                    last_uri();
                }
            }
        }
    }

    public function participant_trash(Request $request, Response $response)
    {
        if($request->isDelete()) {
            $participants = TaskRegistration::find();

            if (!$participants) {
                Application::$app->session->setFlash("success", "Participants Not Found");
                last_uri();
            }

            if($participants) {
                foreach($participants as $participant) {
                    $participant->delete();
                }
                Application::$app->session->setFlash("success", "Participants Deleted successfully");
                last_uri();
            }
        }
    }

    public function questions(Request $request, Response $response)
    {
        $currentPage = isset($_GET['page']) ? $_GET['page'] : 1;
        $recordsPerPage = 5;

        $slug = $request->get("task-slug");

        $params = [
            'conditions' => "slug = :slug",
            'bind' => ['slug' => $slug]
        ];

        $questions_params = [
            'columns' => "questions.*, users.username",
            'conditions' => "questions.task_slug = :task_slug",
            'joins' => [
                ['users', 'questions.user = users.uid'],
            ],
            'bind' => ['task_slug' => $slug],
            'order' => 'questions.created_at DESC',
            'limit' => $recordsPerPage,
            'offset' => ($currentPage - 1) * $recordsPerPage
        ];

        $task = Tasks::findFirst($params);

        $total = Questions::findTotal($questions_params);
        $numberOfPages = ceil($total / $recordsPerPage);

        $view = [
            'navigations' => [
                ['label' => 'Dashboard', 'url' => 'admin'],
                ['label' => 'Tasks', 'url' => 'admin/tasks'],
                ['label' => 'Task Questions', 'url' => ''],
            ],
            'task' => $task,
            'questions' => Questions::find($questions_params),
            'totalQuestions' => $total,
            'prevPage' => $this->previous_pagination($currentPage),
            'nextPage' => $this->next_pagination($currentPage, $numberOfPages),
        ];

        $this->view->render("admin/tasks/questions", $view);
    }

    public function question(Request $request, Response $response)
    {
        $slug = $request->get("task-slug");
        $type = $request->get("type");

        $type_search = ["objective", "subjective", "theory"];

        $params = [
            'conditions' => "slug = :slug",
            'bind' => ['slug' => $slug]
        ];

        $task = Tasks::findFirst($params);

        if (!in_array($type, $type_search)) {
            Application::$app->session->setFlash("success", "Question Type is Invalid!");
            redirect("/admin/tasks/questions?task-slug={$task->slug}");
        }

        $question = new Questions();

        if ($request->isPost()) {
            $question->loadData($request->getBody());
            $question->user = $this->currentUser->uid;
            $upload = new FileUpload('image');

            $uploadErrors = $upload->validate();

            if (!empty($uploadErrors)) {
                foreach ($uploadErrors as $field => $error) {
                    $question->setError($field, $error);
                }
            }

            if (empty($question->getErrors())) {
                if ($question->save()) {
                    $upload->directory('uploads/tasks/questions');
                    if (!empty($upload->tmp)) {
                        if ($upload->upload()) {
                            if (file_exists($question->image)) {
                                unlink($question->image);
                                $question->image = "";
                            }
                            $question->image = $upload->fc;
                            $image = new Image();
                            $image->resize($question->image);
                            $question->save();
                        }
                    }
                    Application::$app->session->setFlash("success", "{$question->question} Saved successfully.");
                    redirect("/admin/tasks/questions?task-slug={$task->slug}");
                }
            }
        }

        $view = [
            'navigations' => [
                ['label' => 'Dashboard', 'url' => 'admin'],
                ['label' => 'Tasks', 'url' => 'admin/tasks'],
                ['label' => 'Create Question', 'url' => ''],
            ],
            'errors' => $question->getErrors(),
            'task' => $task,
            'type' => $type,
            'question' => $question
        ];

        $this->view->render("admin/tasks/question", $view);
    }

    public function edit_question(Request $request, Response $response)
    {
        $task_slug = $request->get("task-slug");
        $slug = $request->get("slug");
        $type = $request->get("type");

        $type_search = ["objective", "subjective", "theory"];

        $task_params = [
            'conditions' => "slug = :slug",
            'bind' => ['slug' => $task_slug]
        ];

        $params = [
            'conditions' => "slug = :slug AND task_slug = :task_slug",
            'bind' => ['slug' => $slug, 'task_slug' => $task_slug]
        ];

        $task = Tasks::findFirst($task_params);

        if (!in_array($type, $type_search)) {
            Application::$app->session->setFlash("success", "Question Type is Invalid!");
            redirect("/admin/tasks/questions?task-slug={$task->slug}");
        }

        $question = Questions::findFirst($params);

        if (!$question) {
            Application::$app->session->setFlash("success", "Question does not exist");
            last_uri();
        }

        if ($request->isPatch()) {
            $question->loadData($request->getBody());
            $question->user = $this->currentUser->uid;
            $upload = new FileUpload('image');

            $uploadErrors = $upload->validate();

            if (!empty($uploadErrors)) {
                foreach ($uploadErrors as $field => $error) {
                    $question->setError($field, $error);
                }
            }

            if (empty($question->getErrors())) {
                if ($question->save()) {
                    $upload->directory('uploads/tasks/questions');
                    if (!empty($upload->tmp)) {
                        if ($upload->upload()) {
                            if (file_exists($question->image)) {
                                unlink($question->image);
                                $question->image = "";
                            }
                            $question->image = $upload->fc;
                            $image = new Image();
                            $image->resize($question->image);
                            $question->save();
                        }
                    }
                    Application::$app->session->setFlash("success", "{$question->question} Updated successfully.");
                    redirect("/admin/tasks/questions?task-slug={$task->slug}");
                }
            }
        }

        $view = [
            'navigations' => [
                ['label' => 'Dashboard', 'url' => 'admin'],
                ['label' => 'Tasks', 'url' => 'admin/tasks'],
                ['label' => 'Edit Question', 'url' => ''],
            ],
            'errors' => [],
            'task' => $task,
            'type' => $type,
            'question' => $question
        ];

        $this->view->render("admin/tasks/edit_question", $view);
    }

    public function trash_question(Request $request, Response $response)
    {
        $params = [
            'conditions' => "slug = :slug",
            'bind' => ['slug' => $request->post('question_slug')]
        ];

        $question = Questions::findFirst($params);

        if (!$question) {
            Application::$app->session->setFlash("success", "Comment Not Found");
            last_uri();
        }

        if ($request->isDelete()) {
            if ($question) {
                if ($question->delete()) {
                    Application::$app->session->setFlash("success", "Question Deleted successfully");
                    last_uri();
                }
            }
        }
    }
}