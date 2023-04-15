<?php

namespace controllers;

use Exception;
use Core\Request;
use models\Users;
use Core\Response;
use models\Topics;
use Core\Controller;
use models\Articles;
use models\Contacts;
use Core\Application;
use Core\Support\Helpers\Image;
use Core\Support\Helpers\FileUpload;

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
            'users' => Users::find(),
        ];
        $this->view->render('admin/dashboard', $view);
    }

    public function articles(Request $request, Response $response)
    {
        $params = [
            'columns' => "articles.*, topics.topic",
            'joins' => [
                ['topics', 'articles.topic = topics.slug'],
            ],
            'order' => 'articles.id DESC'
        ];

        $view = [
            'errors' => [],
            'articles' => Articles::find($params),
            'total' => Articles::findTotal($params),
        ];

        $this->view->render('admin/articles/index', $view);
    }

    public function create_article(Request $request, Response $response)
    {
        $article = new Articles();

        $topics = Topics::find(['order' => 'topic']);
        $topicOptions = [0 => ''];
        foreach ($topics as $topic) {
            $topicOptions[$topic->slug] = $topic->topic;
        }

        if ($request->isPost()) {
            $article->loadData($request->getBody());
            $article->user_id = $this->currentUser->uid;
            $upload = new FileUpload('thumbnail');
            $subUpload = new FileUpload('sub_image');
            $upload->required = true;
            $subUpload->required = true;

            $uploadErrors = $upload->validate();
            $subUploadErrors = $subUpload->validate();

            if (!empty($uploadErrors)) {
                foreach ($uploadErrors as $field => $error) {
                    $article->setError($field, $error);
                }
            }
            if (!empty($subUploadErrors)) {
                foreach ($subUploadErrors as $field => $error) {
                    $article->setError($field, $error);
                }
            }

            if (empty($article->getErrors())) {
                if ($article->save()) {
                    $upload->directory('uploads/articles');
                    $subUpload->directory('uploads/articles/subs');
                    if (!empty($upload->tmp) && !empty($subUpload->tmp)) {
                        if ($upload->upload() && $subUpload->upload()) {
                            if (file_exists($article->thumbnail) && file_exists($article->sub_image)) {
                                unlink($article->thumbnail);
                                unlink($article->sub_image);
                                $article->thumbnail = "";
                                $article->sub_image = "";
                            }
                            $article->thumbnail = $upload->fc;
                            $article->sub_image = $subUpload->fc;
                            $image = new Image();
                            $image->resize($article->thumbnail);
                            $image->resize($article->sub_image);
                            $article->save();
                        }
                    }
                    Application::$app->session->setFlash("success", "{$article->title} Saved successfully.");
                    redirect('/admin/articles');
                }
            }
        }

        $view = [
            'errors' => $article->getErrors(),
            'statusOpts' => [
                '' => '--- Please Select ---',
                'published' => 'Published',
                'draft' => 'Draft'
            ],
            'article' => $article,
            'topicOpts' => $topicOptions,
        ];

        $this->view->render('admin/articles/create', $view);
    }

    public function edit_article(Request $request, Response $response)
    {
        $slug = $request->get('article-slug');

        $params = [
            'conditions' => "slug = :slug",
            'bind' => ['slug' => $slug]
        ];
        $article = Articles::findFirst($params);

        $topics = Topics::find(['order' => 'topic']);
        $topicOptions = [0 => ''];
        foreach ($topics as $topic) {
            $topicOptions[$topic->slug] = $topic->topic;
        }

        if ($request->isPatch()) {
            $article->loadData($request->getBody());
            $article->user_id = $this->currentUser->uid;
            $upload = new FileUpload('thumbnail');
            $subUpload = new FileUpload('sub_image');

            $uploadErrors = $upload->validate();
            $subUploadErrors = $subUpload->validate();

            if (!empty($uploadErrors)) {
                foreach ($uploadErrors as $field => $error) {
                    $article->setError($field, $error);
                }
            }
            if (!empty($subUploadErrors)) {
                foreach ($subUploadErrors as $field => $error) {
                    $article->setError($field, $error);
                }
            }

            if (empty($article->getErrors())) {
                if ($article->save()) {
                    $upload->directory('uploads/articles');
                    $subUpload->directory('uploads/articles/subs');
                    if (!empty($upload->tmp) && !empty($subUpload->tmp)) {
                        if ($upload->upload() && $subUpload->upload()) {
                            if (file_exists($article->thumbnail) && file_exists($article->sub_image)) {
                                unlink($article->thumbnail);
                                unlink($article->sub_image);
                                $article->thumbnail = "";
                                $article->sub_image = "";
                            }
                            $article->thumbnail = $upload->fc;
                            $article->sub_image = $subUpload->fc;
                            $image = new Image();
                            $image->resize($article->thumbnail);
                            $image->resize($article->sub_image);
                            $article->save();
                        }
                    }
                    Application::$app->session->setFlash("success", "{$article->title} Updated successfully.");
                    redirect('/admin/articles');
                }
            }
        }

        $view = [
            'errors' => $article->getErrors(),
            'statusOpts' => [
                '' => '--- Please Select ---',
                'published' => 'Published',
                'draft' => 'Draft'
            ],
            'article' => $article,
            'topicOpts' => $topicOptions,
        ];

        $this->view->render('admin/articles/edit', $view);
    }

    public function trash_article(Request $request, Response $response)
    {
        $slug = $request->get('article-slug');

        $params = [
            'conditions' => "slug = :slug",
            'bind' => ['slug' => $slug]
        ];
        $article = Articles::findFirst($params);

        if ($request->isDelete()) {
            if ($article) {
                if ($article->delete()) {
                    if (file_exists($article->thumbnail)) {
                        unlink($article->thumbnail);
                        $article->thumbnail = '';
                    }
                    if (file_exists($article->sub_image)) {
                        unlink($article->sub_image);
                        $article->sub_image = '';
                    }
                    Application::$app->session->setFlash("success", "{$article->title} Deleted successfully");
                    redirect('/admin/articles');
                }
            }
        }

        $view = [
            'errors' => [],
            'article' => $article,
        ];

        $this->view->render('admin/articles/delete', $view);
    }

    public function users(Request $request, Response $response)
    {
        $currentPage = isset($_GET['page']) ? $_GET['page'] : 1;
        $recordsPerPage = 1;

        $params = [
            'order' => 'name, surname',
            'limit' => $recordsPerPage,
            'offset' => ($currentPage - 1) * $recordsPerPage
        ];
        // $params = Users::mergeWithPagination($params);
        $total = Users::findTotal($params);
        $numberOfPages = ceil($total / $recordsPerPage);

        $view = [
            'errors' => [],
            'users' => Users::find($params),
            'prevPage' => $currentPage > 1 ? $currentPage - 1 : false,
            'nextPage' => $currentPage + 1 <= $numberOfPages ? $currentPage + 1 : false,
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
            'errors' => [],
            'user' => $user,
        ];

        $this->view->render('admin/users/delete', $view);
    }

    public function topics(Request $request, Response $response)
    {
        $params = ['order' => 'topic'];
        $params = Topics::mergeWithPagination($params);

        $view = [
            'errors' => [],
            'topics' => Topics::find($params),
        ];

        $this->view->render('admin/topics/index', $view);
    }

    public function create_topic(Request $request, Response $response)
    {
        $topic = new Topics();

        if ($request->isPost()) {
            $topic->loadData($request->getBody());

            if ($topic->save()) {
                Application::$app->session->setFlash("success", "{$topic->topic} Created successfully");
                redirect('/admin/topics');
            }
        }

        $view = [
            'errors' => $topic->getErrors(),
            'statusOpts' => [
                '' => '--- Please Select ---',
                'disabled' => 'Disabled',
                'active' => 'Active',
            ],
            'topic' => $topic,
        ];

        $this->view->render('admin/topics/create', $view);
    }

    public function edit_topic(Request $request, Response $response)
    {
        $slug = $request->get('topic-slug');

        $params = [
            'conditions' => "slug = :slug",
            'bind' => ['slug' => $slug]
        ];
        $topic = Topics::findFirst($params);

        if ($request->isPatch()) {
            $topic->loadData($request->getBody());

            if ($topic->save()) {
                Application::$app->session->setFlash("success", "{$topic->topic} Updated successfully");
                redirect('/admin/topics');
            }
        }

        $view = [
            'errors' => $topic->getErrors(),
            'statusOpts' => [
                '' => '--- Please Select ---',
                'disabled' => 'Disabled',
                'active' => 'Active',
            ],
            'topic' => $topic,
        ];

        $this->view->render('admin/topics/edit', $view);
    }

    public function delete_topic(Request $request, Response $response)
    {
        $slug = $request->get('topic-slug');

        $params = [
            'conditions' => "slug = :slug",
            'bind' => ['slug' => $slug]
        ];
        $topic = Topics::findFirst($params);

        if ($request->isDelete()) {
            if ($topic) {
                if ($topic->delete()) {
                    Application::$app->session->setFlash("success", "{$topic->topic} Deleted successfully");
                    redirect('/admin/topics');
                }
            }
        }

        $view = [
            'errors' => [],
            'topic' => $topic,
        ];

        $this->view->render('admin/topics/delete', $view);
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

    public function messages(Request $request, Response $response)
    {
        $params = ['order' => 'created_at DESC'];
        $params = Contacts::mergeWithPagination($params);

        $view = [
            'errors' => [],
            'messages' => Contacts::find($params),
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
                }
            }
            $messages = Contacts::find();
            if ($messages) {
                foreach ($messages as $message) {
                    $message->delete();
                }
                Application::$app->session->setFlash("success", "Message Deleted successfully");
            }
            redirect("/admin/messages");
        }
    }
}