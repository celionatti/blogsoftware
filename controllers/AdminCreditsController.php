<?php

namespace controllers;

use Exception;
use Core\Request;
use models\Users;
use Core\Response;
use Core\Controller;
use models\Credits;

class AdminCreditsController extends Controller
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
            'podcasts' => Users::find(),
        ];
        $this->view->render('admin/credits/index', $view);
    }

    /**
     * @throws Exception
     */
    public function wallets(Request $request, Response $response)
    {
        $currentPage = isset($_GET['page']) ? $_GET['page'] : 1;
        $recordsPerPage = 5;

        $params = [
            'columns' => "credits.*, users.surname, users.email, users.name",
            'conditions' => "credits.status = :status",
            'joins' => [
                ['users', 'credits.user_id = users.uid'],
            ],
            'bind' => ['status' => 'active'],
            'order' => 'credits.id DESC',
            'limit' => $recordsPerPage,
            'offset' => ($currentPage - 1) * $recordsPerPage
        ];

        $total = Credits::findTotal($params);
        $numberOfPages = ceil($total / $recordsPerPage);

        $view = [
            'credits' => Credits::find($params),
            'prevPage' => $this->previous_pagination($currentPage),
            'nextPage' => $this->next_pagination($currentPage, $numberOfPages),
        ];
        $this->view->render('admin/credits/wallets', $view);
    }
}