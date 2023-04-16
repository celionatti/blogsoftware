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
use models\RelatedArticles;
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
        $currentPage = isset($_GET['page']) ? $_GET['page'] : 1;
        $recordsPerPage = 5;

        $params = [
            'columns' => "articles.*, topics.topic",
            'joins' => [
                ['topics', 'articles.topic = topics.slug'],
            ],
            'order' => 'articles.id DESC',
            'limit' => $recordsPerPage,
            'offset' => ($currentPage - 1) * $recordsPerPage
        ];

        $total = Articles::findTotal($params);
        $numberOfPages = ceil($total / $recordsPerPage);

        $view = [
            'errors' => [],
            'articles' => Articles::find($params),
            'prevPage' => $this->previous_pagination($currentPage),
            'nextPage' => $this->next_pagination($currentPage, $numberOfPages),
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

    public function related_articles(Request $request, Response $response)
    {
        $slug = $request->get('article-slug');

        $currentPage = isset($_GET['page']) ? $_GET['page'] : 1;
        $recordsPerPage = 5;

        $params = [
            'conditions' => "slug = :slug",
            'bind' => ['slug' => $slug]
        ];

        $article = Articles::findFirst($params);

        $related_params = [
            'conditions' => "status = :status AND title LIKE :title OR author LIKE :author",
            'bind' => ['status' => 'published', 'title' => "%$article->title%", 'author' => "%$article->author%"],
            'order' => "created_at DESC",
            'limit' => $recordsPerPage,
            'offset' => ($currentPage - 1) * $recordsPerPage
        ];


        $total = Articles::findTotal($params);
        $numberOfPages = ceil($total / $recordsPerPage);

        $view = [
            'article' => $article,
            'articles' => Articles::find($related_params),
            'prevPage' => $this->previous_pagination($currentPage),
            'nextPage' => $this->next_pagination($currentPage, $numberOfPages),
        ];

        $this->view->render('admin/articles/related', $view);
    }

    public function add_related_articles(Request $request, Response $response)
    {
        $related_articles = new RelatedArticles();

        $params = [
            'conditions' => "article_slug = :article_slug AND related_slug = :related_slug",
            'bind' => ['article_slug' => $request->post('article_slug'), 'related_slug' => $request->post('related_slug')]
        ];

        $existing_related_articles = RelatedArticles::findFirst($params);

        if ($request->post('article_slug') == $request->post('related_slug')) {
            Application::$app->session->setFlash("error", "Article with the same title can't be added");
            last_uri();
        }

        if ($existing_related_articles) {
            Application::$app->session->setFlash("error", "Article Already Existed, can't add anymore.");
            last_uri();
        }

        if ($request->isPost()) {
            $related_articles->loadData($request->getBody());

            if ($related_articles->save()) {
                Application::$app->session->setFlash("success", "Article Related Successfully.");
                redirect("/admin/articles");
            }
        }
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
        $total = Users::findTotal($params);
        $numberOfPages = ceil($total / $recordsPerPage);

        $view = [
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
        $currentPage = isset($_GET['page']) ? $_GET['page'] : 1;
        $recordsPerPage = 5;

        $params = [
            'order' => 'topic',
            'limit' => $recordsPerPage,
            'offset' => ($currentPage - 1) * $recordsPerPage
        ];
        $total = Topics::findTotal($params);
        $numberOfPages = ceil($total / $recordsPerPage);

        $view = [
            'errors' => [],
            'topics' => Topics::find($params),
            'prevPage' => $this->previous_pagination($currentPage),
            'nextPage' => $this->next_pagination($currentPage, $numberOfPages),
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
}