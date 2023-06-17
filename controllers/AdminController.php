<?php

namespace controllers;

use Exception;
use Core\Request;
use models\Users;
use Core\Response;
use Core\Controller;
use models\Contacts;
use Core\Application;
use models\Articles;
use models\CreditWithdraws;
use models\Subscribers;

class AdminController extends Controller
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
        $view = [
            'navigations' => [
                ['label' => 'Dashboard', 'url' => 'admin']
            ],
            'users' => Users::findFirst(),
            'articles_count' => Articles::count_articles(),
            'users_count' => Users::users_count(),
            'withdrawals_count' => CreditWithdraws::withdrawPending_count(),
            'messages_count' => Contacts::messages_count()
        ];
        $this->view->render('admin/dashboard', $view);
    }

    public function collections(Request $request, Response $response)
    {
        $view = [
            'navigations' => [
                ['label' => 'Dashboard', 'url' => 'admin']
            ],
            'errors' => []
        ];

        $this->view->render('admin/collections/index', $view);
    }

    public function create_collection(Request $request, Response $response)
    {
        $view = [
            'navigations' => [
                ['label' => 'Dashboard', 'url' => 'admin']
            ],
            'errors' => [],
            'statusOpts' => [
                '' => '--- Please Select ---',
                'disabled' => 'Disabled',
                'active' => 'Active',
            ],
        ];

        $this->view->render('admin/collections/create', $view);
    }

    public function messages(Request $request, Response $response)
    {
        $currentPage = isset($_GET['page']) ? $_GET['page'] : 1;
        $recordsPerPage = 5;

        $params = [
            'order' => 'created_at DESC',
            'limit' => $recordsPerPage,
            'offset' => ($currentPage - 1) * $recordsPerPage
        ];
        $total = Contacts::findTotal($params);
        $numberOfPages = ceil($total / $recordsPerPage);

        $view = [
            'navigations' => [
                ['label' => 'Dashboard', 'url' => 'admin'],
                ['label' => 'Messages', 'url' => '']
            ],
            'errors' => [],
            'messages' => Contacts::find($params),
            'prevPage' => $this->previous_pagination($currentPage),
            'nextPage' => $this->next_pagination($currentPage, $numberOfPages),
        ];

        $this->view->render('admin/messages/index', $view);
    }

    public function trash_messages(Request $request, Response $response)
    {
        $slug = $request->get('message-slug');

        if ($request->isDelete()) {
            if ($slug) {
                $params = [
                    'conditions' => "slug = :slug",
                    'bind' => ['slug' => $slug]
                ];

                $message = Contacts::findFirst($params);

                if ($message) {
                    if ($message->delete()) {
                        Application::$app->session->setFlash("success", "{$message->name} Message Deleted successfully");
                    }
                } else {
                    Application::$app->session->setFlash("success", "Message Not Found");
                }
            }
            $messages = Contacts::find();
            if ($messages) {
                foreach ($messages as $message) {
                    $message->delete();
                }
                Application::$app->session->setFlash("success", "Message Deleted successfully");
            } else {
                Application::$app->session->setFlash("success", "No Messages");
            }
            redirect("/admin/messages");
        }
    }

    public function subscribers(Request $request, Response $response)
    {
        $currentPage = isset($_GET['page']) ? $_GET['page'] : 1;
        $recordsPerPage = 5;

        $params = [
            'order' => 'created_at DESC',
            'limit' => $recordsPerPage,
            'offset' => ($currentPage - 1) * $recordsPerPage
        ];
        $total = Subscribers::findTotal($params);
        $numberOfPages = ceil($total / $recordsPerPage);

        $view = [
            'navigations' => [
                ['label' => 'Dashboard', 'url' => 'admin'],
                ['label' => 'Subscribers', 'url' => ''],
            ],
            'errors' => [],
            'subscribers' => Subscribers::find($params),
            'prevPage' => $this->previous_pagination($currentPage),
            'nextPage' => $this->next_pagination($currentPage, $numberOfPages),
        ];

        $this->view->render('admin/extras/subscribers', $view);
    }
}