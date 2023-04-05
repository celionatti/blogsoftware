<?php

namespace controllers;

use Exception;
use Core\Request;
use models\Users;
use Core\Response;
use Core\Controller;
use Core\Application;

class AuthController extends Controller
{
    public function onConstruct(): void
    {
        $this->view->setLayout('auth');
    }

    /**
     * @throws Exception
     */
    public function register(Request $request, Response $response)
    {
        $user = new Users();

        if ($request->isPost()) {
            $user->loadData($request->getBody());

            if ($user->save()) {
                Application::$app->session->setFlash("{$user->username} Account Created successfully", "success");
                redirect('/login');
            }
        }

        $view = [
            'errors' => $user->getErrors(),
            'user' => $user,
        ];
        $this->view->render('auth/register', $view);
    }

    /**
     * @throws Exception
     */
    public function login(Request $request, Response $response)
    {
        $user = new Users();
        $isError = true;

        if ($request->isPost()) {
            $user->loadData($request->getBody());
            $user->validateLogin();

            if (empty($user->getErrors())) {
                //continue with the login process
                $u = Users::findFirst(
                    [
                        'conditions' => "email = :email",
                        'bind' => ['email' => $request->post('email')]
                    ]
                );

                if ($u) {
                    $verified = password_verify($request->post('password'), $u->password);
                    if ($verified) {
                        //log the user in
                        $isError = false;
                        $remember = $request->post('remember') == 'on';
                        $u->login($remember);
                        redirect('/');
                    }
                }
            }
            if ($isError) {
                $user->setError('email', 'Something is wrong with the Email or Password. Please try again.');
                $user->setError('password', '');
            }
        }

        $view = [
            'errors' => $user->getErrors(),
            'user' => $user,
        ];
        $this->view->render('auth/login', $view);
    }
}