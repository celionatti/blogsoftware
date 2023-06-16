<?php

namespace controllers;

use Core\Request;
use models\Users;
use Core\Response;
use Core\Controller;
use Core\Application;
use Core\Support\Helpers\Image;
use Core\Support\Helpers\FileUpload;

class AdminUsersController extends Controller
{
    public $currentUser;

    public function onConstruct(): void
    {
        $this->view->setLayout('admin');
        $this->currentUser = Users::getCurrentUser();
    }

    public function users(Request $request, Response $response)
    {
        $currentPage = isset($_GET['page']) ? $_GET['page'] : 1;
        $recordsPerPage = 5;

        $params = [
            'order' => 'name, surname',
            'limit' => $recordsPerPage,
            'offset' => ($currentPage - 1) * $recordsPerPage
        ];
        $total = Users::findTotal($params);
        $numberOfPages = ceil($total / $recordsPerPage);

        $view = [
            'navigations' => [
                ['label' => 'Dashboard', 'url' => 'admin'],
                ['label' => 'Users', 'url' => 'admin/users']
            ],
            'errors' => [],
            'users' => Users::find($params),
            'prevPage' => $this->previous_pagination($currentPage),
            'nextPage' => $this->next_pagination($currentPage, $numberOfPages),
        ];

        $this->view->render('admin/users/index', $view);
    }

    public function create_user(Request $request, Response $response)
    {
        $user = new Users();

        if ($request->isPost()) {
            $user->loadData($request->getBody());
            $upload = new FileUpload('avatar');
            $upload->required = true;

            $uploadErrors = $upload->validate();

            if (!empty($uploadErrors)) {
                foreach ($uploadErrors as $field => $error) {
                    $user->setError($field, $error);
                }
            }

            if (empty($user->getErrors())) {
                if ($user->save()) {
                    $upload->directory('uploads/users');
                    if (!empty($upload->tmp)) {
                        if ($upload->upload()) {
                            if (file_exists($user->avatar)) {
                                unlink($user->avatar);
                                $user->avatar = null;
                            }
                            $user->avatar = $upload->fc;
                            $image = new Image();
                            $image->resize($user->avatar);
                            $user->save();
                        }
                    }
                    Application::$app->session->setFlash("success", "{$user->surname} Registration successfully, user should check E-mail for verification.");
                    redirect('/admin/users');
                }
            }
        }

        $view = [
            'navigations' => [
                ['label' => 'Dashboard', 'url' => 'admin'],
                ['label' => 'Users', 'url' => 'admin/users'],
                ['label' => 'Create User', 'url' => '']
            ],
            'errors' => $user->getErrors(),
            'aclOpts' => [
                '' => '--- Please Select ---',
                'user' => 'User',
                'author' => 'Author',
                'admin' => 'Admin'
            ],
            'user' => $user,
        ];

        $this->view->render('admin/users/create', $view);
    }

    public function edit_user(Request $request, Response $response)
    {
        $uid = $request->get('uid');

        $params = [
            'conditions' => "uid = :uid",
            'bind' => ['uid' => $uid]
        ];
        $user = Users::findFirst($params);

        if ($request->isPatch()) {
            $user->loadData($request->getBody());
            $upload = new FileUpload('avatar');

            $uploadErrors = $upload->validate();

            if (!empty($uploadErrors)) {
                foreach ($uploadErrors as $field => $error) {
                    $user->setError($field, $error);
                }
            }

            if (empty($user->getErrors())) {
                if ($user->save()) {
                    $upload->directory('uploads/users');
                    if (!empty($upload->tmp)) {
                        if ($upload->upload()) {
                            if (file_exists($user->avatar)) {
                                unlink($user->avatar);
                                $user->avatar = '';
                            }
                            $user->avatar = $upload->fc;
                            $image = new Image();
                            $image->resize($user->avatar);
                            $user->save();
                        }
                    }
                    Application::$app->session->setFlash("success", "{$user->surname} Updated successfully");
                    redirect('/admin/users');
                }
            }
        }

        $view = [
            'navigations' => [
                ['label' => 'Dashboard', 'url' => 'admin'],
                ['label' => 'Users', 'url' => 'admin/users'],
                ['label' => 'Edit User', 'url' => '']
            ],
            'errors' => $user->getErrors(),
            'aclOpts' => [
                '' => '--- Please Select ---',
                'user' => 'User',
                'author' => 'Author',
                'admin' => 'Admin'
            ],
            'user' => $user,
        ];

        $this->view->render('admin/users/edit', $view);
    }

    public function delete_user(Request $request, Response $response)
    {
        $uid = $request->get('uid');

        $params = [
            'conditions' => "uid = :uid",
            'bind' => ['uid' => $uid]
        ];
        $user = Users::findFirst($params);

        if ($request->isDelete()) {
            if ($user) {
                if ($user->delete()) {
                    if (file_exists($user->avatar)) {
                        unlink($user->avatar);
                        $user->avatar = '';
                    }
                    Application::$app->session->setFlash("success", "{$user->username} Deleted successfully");
                    redirect('/admin/users');
                }
            }
        }

        $view = [
            'navigations' => [
                ['label' => 'Dashboard', 'url' => 'admin'],
                ['label' => 'Users', 'url' => 'admin/users'],
                ['label' => 'Delete User', 'url' => '']
            ],
            'errors' => [],
            'user' => $user,
        ];

        $this->view->render('admin/users/delete', $view);
    }

}