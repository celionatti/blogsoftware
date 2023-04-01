<?php

namespace controllers;

use Core\Application;
use Exception;
use Core\Request;
use models\Users;
use Core\Response;
use Core\Controller;
use Core\Support\Helpers\Image;
use Core\Support\Helpers\FileUpload;

class AdminController extends Controller
{
    public function onConstruct(): void
    {
        $this->view->setLayout('admin');
    }

    /**
     * @throws Exception
     */
    public function index(Request $request, Response $response)
    {
        $view = [
            'users' => Users::find(),
        ];
        $this->view->render('admin/dashboard', $view);
    }

    public function articles(Request $request, Response $response)
    {
        $view = [
            'errors' => []
        ];

        $this->view->render('admin/articles/index', $view);
    }

    public function create_article(Request $request, Response $response)
    {
        $view = [
            'errors' => [],
            'statusOpts' => [
                '' => '--- Please Select ---',
                'published' => 'Published',
                'draft' => 'Draft'
            ],
        ];

        $this->view->render('admin/articles/create', $view);
    }

    public function users(Request $request, Response $response)
    {
        $params = ['order' => 'name, surname'];
        $params = Users::mergeWithPagination($params);

        $view = [
            'errors' => [],
            'users' => Users::find($params),
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
                    Application::$app->session->setFlash("{$user->surname} Registration successful, user should check E-mail for verification.", "success");
                    redirect('/admin/users');
                }
            }
        }

        $view = [
            'errors' => $user->getErrors(),
            'aclOpts' => [
                '' => '--- Please Select ---',
                'guest' => 'Guest',
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
                    Application::$app->session->setFlash("{$user->surname} Updated successful", "success");
                    redirect('/admin/users');
                }
            }
        }

        $view = [
            'errors' => $user->getErrors(),
            'aclOpts' => [
                '' => '--- Please Select ---',
                'guest' => 'Guest',
                'author' => 'Author',
                'admin' => 'Admin'
            ],
            'user' => $user,
        ];

        $this->view->render('admin/users/edit', $view);
    }

    public function topics(Request $request, Response $response)
    {
        $view = [
            'errors' => []
        ];

        $this->view->render('admin/topics/index', $view);
    }

    public function create_topic(Request $request, Response $response)
    {
        $view = [
            'errors' => [],
            'statusOpts' => [
                '' => '--- Please Select ---',
                'disabled' => 'Disabled',
                'active' => 'Active',
            ],
        ];

        $this->view->render('admin/topics/create', $view);
    }
    public function collections(Request $request, Response $response)
    {
        $view = [
            'errors' => []
        ];

        $this->view->render('admin/collections/index', $view);
    }

    public function create_collection(Request $request, Response $response)
    {
        $view = [
            'errors' => [],
            'statusOpts' => [
                '' => '--- Please Select ---',
                'disabled' => 'Disabled',
                'active' => 'Active',
            ],
        ];

        $this->view->render('admin/collections/create', $view);
    }
}