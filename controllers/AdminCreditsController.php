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
use models\CreditWithdraws;

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
        $currentPage = isset($_GET['page']) ? $_GET['page'] : 1;
        $recordsPerPage = 5;

        $params = [
            'columns' => "credit_withdraws.*, users.surname, users.email, users.name, credits.slug as credit_slug",
            'joins' => [
                ['users', 'credit_withdraws.user_id = users.uid'],
                ['credits', 'credit_withdraws.wallet_id = credits.wallet_id', 'credits', 'LEFT'],
            ],
            'order' => 'credit_withdraws.created_at DESC',
            'limit' => $recordsPerPage,
            'offset' => ($currentPage - 1) * $recordsPerPage
        ];

        $total = CreditWithdraws::findTotal($params);
        $numberOfPages = ceil($total / $recordsPerPage);

        $view = [
            'navigations' => [
                ['label' => 'Dashboard', 'url' => 'admin'],
                ['label' => 'Credits & Wallets', 'url' => ''],
            ],
            'credits' => CreditWithdraws::find($params),
            'prevPage' => $this->previous_pagination($currentPage),
            'nextPage' => $this->next_pagination($currentPage, $numberOfPages),
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
            'navigations' => [
                ['label' => 'Dashboard', 'url' => 'admin'],
                ['label' => 'Credits & Wallets', 'url' => 'admin/credits'],
                ['label' => 'Wallets', 'url' => ''],
            ],
            'credits' => Credits::find($params),
            'prevPage' => $this->previous_pagination($currentPage),
            'nextPage' => $this->next_pagination($currentPage, $numberOfPages),
        ];
        $this->view->render('admin/credits/wallets', $view);
    }

    /**
     * @throws Exception
     */
    public function wallets_disabled(Request $request, Response $response)
    {
        $currentPage = isset($_GET['page']) ? $_GET['page'] : 1;
        $recordsPerPage = 5;

        $params = [
            'columns' => "credits.*, users.surname, users.email, users.name",
            'conditions' => "credits.status = :status",
            'joins' => [
                ['users', 'credits.user_id = users.uid'],
            ],
            'bind' => ['status' => 'disabled'],
            'order' => 'credits.id DESC',
            'limit' => $recordsPerPage,
            'offset' => ($currentPage - 1) * $recordsPerPage
        ];

        $total = Credits::findTotal($params);
        $numberOfPages = ceil($total / $recordsPerPage);

        $view = [
            'navigations' => [
                ['label' => 'Dashboard', 'url' => 'admin'],
                ['label' => 'Credits & Wallets', 'url' => 'admin/credits'],
                ['label' => 'Wallets', 'url' => 'admin/wallets'],
                ['label' => 'Disabled Wallets', 'url' => ''],
            ],
            'credits' => Credits::find($params),
            'prevPage' => $this->previous_pagination($currentPage),
            'nextPage' => $this->next_pagination($currentPage, $numberOfPages),
        ];
        $this->view->render('admin/credits/disabled_wallets', $view);
    }

    public function wallet_status(Request $request, Response $response)
    {
        if ($request->isPatch()) {
            $params = [
                'conditions' => "slug = :slug",
                'bind' => ['slug' => $request->post('slug')]
            ];

            $credit = Credits::findFirst($params);

            if ($credit) {
                $credit->loadData($request->getBody());
                if ($credit->save()) {
                    Application::$app->session->setFlash("success", "Wallet status Updated successfully");
                    last_uri();
                }
            }
        }
    }

    public function wallet_trash(Request $request, Response $response)
    {
        if ($request->isDelete()) {
            $params = [
                'conditions' => "slug = :slug",
                'bind' => ['slug' => $request->post('slug')]
            ];

            $credit = Credits::findFirst($params);

            if ($credit->delete()) {
                Application::$app->session->setFlash("success", "Wallet Deleted successfully");
                last_uri();
            }
        }
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

        if ($request->isPost()) {
            Csrf::check_csrf();

            $isError = false;

            if (empty($request->post("amount") || $request->post("amount") === 0)) {
                $isError = true;
                $credit->setError('amount', 'Something is wrong. Please try again.');
                $credit->setError('details', '');
            }

            if (empty($credit->getErrors())) {
                $credit->balance = $credit->balance + $request->post("amount");

                if ($credit->save()) {
                    Application::$app->session->setFlash("success", "{$credit->surname} Credited successfully.");
                    redirect('/admin/credits');
                } else {
                    Application::$app->session->setFlash("success", "Something went wrong, Try again later.");
                    last_uri();
                }
            }
        }

        $view = [
            'navigations' => [
                ['label' => 'Dashboard', 'url' => 'admin'],
                ['label' => 'Credits & Wallets', 'url' => 'admin/credits'],
                ['label' => 'Wallets', 'url' => 'admin/wallets'],
                ['label' => 'Info', 'url' => ''],
            ],
            'errors' => $credit->getErrors(),
            'credit' => $credit,
        ];

        $this->view->render('admin/credits/info', $view);
    }

    public function status(Request $request, Response $response)
    {
        if ($request->isPatch()) {
            $params = [
                'conditions' => "slug = :slug",
                'bind' => ['slug' => $request->post('slug')]
            ];

            $creditWithdraw = CreditWithdraws::findFirst($params);

            if ($creditWithdraw) {
                $creditWithdraw->loadData($request->getBody());
                $creditWithdraw->accepted_by = $this->currentUser->uid;
                if ($creditWithdraw->save()) {
                    Application::$app->session->setFlash("success", "Credit Updated successfully");
                    last_uri();
                }
            }
        }
    }

    public function withdraw(Request $request, Response $response)
    {
        if ($request->isPatch()) {
            $creditParams = [
                'conditions' => "wallet_id = :wallet_id",
                'bind' => ['wallet_id' => $request->post('wallet_id')]
            ];

            $credit = Credits::findFirst($creditParams);

            if ($credit) {
                $credit->balance = $credit->balance - $request->post('amount');

                if ($credit->save()) {
                    Application::$app->session->setFlash("success", "Credit Withdraw successfully");
                    last_uri();
                }
            }
        }
    }
}
