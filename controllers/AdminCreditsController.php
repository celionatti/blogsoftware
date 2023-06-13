<?php

namespace controllers;

use Exception;
use Core\Request;
use models\Users;
use Core\Response;
use models\Credits;
use Core\Controller;
use Core\Application;
use Core\Support\Csrf;
use models\Transactions;
use Core\Support\Helpers\Token;

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


    /**
     * @throws Exception
     */
    public function info(Request $request, Response $response)
    {
        $slug = $request->get("credit-slug");

        $params = [
            'columns' => "credits.*, users.surname, users.email, users.name, users.uid",
            'conditions' => "credits.status = :status AND credits.slug = :slug",
            'joins' => [
                ['users', 'credits.user_id = users.uid'],
            ],
            'bind' => ['status' => 'active', 'slug' => $slug],
            'order' => 'credits.id DESC',
            'limit' => '1',
        ];

        $credit = Credits::findFirst($params);
        $transaction = new Transactions();

        if ($request->isPost()) {
            Csrf::check_csrf();

            // $transaction->slug = Token::generateOTP(60);
            $transaction->to = $credit->uid;
            $transaction->from = $this->currentUser->uid;
            $transaction->details = $request->post("details");
            $transaction->method = Transactions::CREDIT_METHOD;
            $transaction->amount = $request->post("amount");
            $transaction->status = Transactions::STATUS_SUCCESS;

            if ($transaction->save()) {
                $last_transaction = Transactions::findFirst([
                    'conditions' => "slug = :slug",
                    'bind' => ['slug' => $transaction->slug],
                ]);

                if ($last_transaction) {
                    $c = Credits::findFirst($params);
                    $c->balance = $c->deposit($request->post("amount"));
                    if ($credit->save()) {
                        Application::$app->session->setFlash("success", "{$credit->surname} Credited successfully.");
                        redirect('/admin/credits');
                    }
                }
            }
        }

        $view = [
            'errors' => [],
            'credit' => $credit,
        ];

        $this->view->render('admin/credits/info', $view);
    }
}
