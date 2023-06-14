<?php

namespace controllers;

use Core\Request;
use models\Users;
use Core\Response;
use Core\Controller;
use Core\Application;
use models\Credits;
use models\CreditWithdraws;

class WalletController extends Controller
{
    public $currentUser;

    public function onConstruct(): void
    {
        $this->view->setLayout('blog');
        $this->currentUser = Users::getCurrentUser();
    }

    public function request_wallet(Request $request, Response $response)
    {
        if (!$this->currentUser)
            abort();

        $uid = $this->currentUser->uid;

        $params = [
            'conditions' => "uid = :uid",
            'bind' => ['uid' => $uid],
            'limit' => 1
        ];

        $user = Users::findFirst($params);

        if (!$user)
            abort(Response::NOT_FOUND);

        $credit = Credits::findFirst([
            'conditions' => "user_id = :user_id",
            'bind' => ["user_id" => $uid]
        ]);

        if ($credit)
            abort(Response::BAD_REQUEST);


        $credit = new Credits();

        if ($request->isPost()) {
            $verifiedToken = password_verify($request->post('token'), $user->token);

            if ($verifiedToken) {
                unset($_POST['token']);

                $credit->loadData($request->getBody());
                $credit->user_id = $this->currentUser->uid;

                if ($credit->save()) {
                    Application::$app->session->setFlash("success", "Wallet Created successfully");
                    redirect('/account');
                } else {
                    $credit->setError('type', 'Something went wrong with creating your wallet. Please try again.');
                    $credit->setError('token', '');
                }
            }
        }

        $view = [
            'errors' => $credit->getErrors(),
            'typeOpts' => [
                '' => '',
                Credits::PERSONAL_WALLET => 'Personal Wallet',
                Credits::BUSINESS_WALLET => 'Business Wallet',
                Credits::INVESTMENT_WALLET => 'Investment Wallet'
            ],
            'credit' => $credit
        ];
        $this->view->render('docs/request_wallet', $view);
    }

    public function request_withdrawal(Request $request, Response $response)
    {
        if (!$this->currentUser)
            abort();

        $uid = $this->currentUser->uid;

        $params = [
            'conditions' => "uid = :uid",
            'bind' => ['uid' => $uid],
            'limit' => 1
        ];

        $user = Users::findFirst($params);

        if (!$user)
            abort(Response::NOT_FOUND);

        $withdraw = new CreditWithdraws();
        
        if($request->isPost()) {
            dd($_POST);
        }

        $view = [
            'errors' => [],
        ];
        $this->view->render('docs/request_withdraw', $view);
    }
}
