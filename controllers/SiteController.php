<?php

namespace controllers;

use Core\Support\Helpers\Bcrypt;
use Exception;
use Core\Request;
use models\Users;
use Core\Response;
use models\Ratings;
use Core\Controller;
use models\Articles;
use models\Comments;
use models\Contacts;
use Core\Application;
use models\BoardPosts;
use models\Subscribers;
use models\CommentReplies;
use Core\Support\Helpers\Image;
use Core\Support\Helpers\FileUpload;

class SiteController extends Controller
{
    public $currentUser;

    public function onConstruct(): void
    {
        $this->view->setLayout('blog');
        $this->currentUser = Users::getCurrentUser();
    }

    /**
     * @throws Exception
     */
    public function index(Request $request, Response $response)
    {
        $featured_params = [
            'columns' => "articles.*, users.username, topics.topic, topics.slug as topic_slug",
            'conditions' => "articles.status = :status AND articles.featured = '1'",
            'bind' => ['status' => 'published'],
            'joins' => [
                ['users', 'articles.user_id = users.uid'],
                ['topics', 'articles.topic = topics.slug', 'topics', 'LEFT']
            ],
            'limit' => "1",
            'order' => 'articles.created_at DESC'
        ];
        $articles_params = [
            'columns' => "articles.*, users.username, topics.topic, topics.slug as topic_slug",
            'conditions' => "articles.status = :status AND articles.featured = '0'",
            'bind' => ['status' => 'published'],
            'joins' => [
                ['users', 'articles.user_id = users.uid'],
                ['topics', 'articles.topic = topics.slug', 'topics', 'LEFT']
            ],
            'limit' => "10",
            'order' => 'articles.created_at DESC'
        ];

        $view = [
            'errors' => [],
            'featured' => Articles::findFirst($featured_params),
            'articles' => Articles::find($articles_params),
        ];
        $this->view->render('welcome', $view);
    }

    public function news(Request $request, Response $response)
    {
        $currentPage = isset($_GET['page']) ? $_GET['page'] : 1;
        $recordsPerPage = 10;

        $params = [
            'columns' => "articles.*, users.username, users.avatar, topics.topic, topics.slug as topic_slug",
            'conditions' => "articles.status = :status",
            'bind' => ['status' => 'published'],
            'joins' => [
                ['users', 'articles.user_id = users.uid'],
                ['topics', 'articles.topic = topics.slug', 'topics', 'LEFT']
            ],
            'order' => 'articles.created_at DESC',
            'limit' => $recordsPerPage,
            'offset' => ($currentPage - 1) * $recordsPerPage
        ];

        $total = Articles::findTotal($params);
        $numberOfPages = ceil($total / $recordsPerPage);

        $view = [
            'articles' => Articles::find($params),
            'total' => $total,
            'prevPage' => $this->previous_pagination($currentPage),
            'nextPage' => $this->next_pagination($currentPage, $numberOfPages),
        ];
        $this->view->render('news', $view);
    }

    public function read(Request $request, Response $response)
    {
        $slug = $request->get('slug');

        $params = [
            'columns' => "articles.*, users.username",
            'conditions' => "slug = :slug AND status = :status",
            'bind' => ['status' => 'published', 'slug' => $slug],
            'joins' => [
                ['users', 'articles.user_id = users.uid'],
            ],
            'order' => 'id DESC'
        ];

        $article = Articles::findFirst($params);
        if (!$article)
            abort(Response::NOT_FOUND);

        $view = [
            'errors' => [],
            'article' => $article,
        ];
        $this->view->render('read', $view);
    }

    public function author(Request $request, Response $response)
    {
        $name = $request->get('name');

        $params = [
            'columns' => "username, surname, name, email, avatar, phone, social, bio",
            'conditions' => "username = :username",
            'bind' => ['username' => $name],
            'limit' => 1
        ];

        $author = Users::findFirst($params);
        if (!$author)
            abort(Response::NOT_FOUND);

        $rating_params = [
            'columns' => "SUM(rating) as total",
            'conditions' => "name = :name",
            'bind' => ['name' => $name],
        ];

        $rating = Ratings::findFirst($rating_params);

        if ($request->isPost()) {
            $ratings = new Ratings();

            $ratings->loadData($request->getBody());
            $ratings->name = $name;

            if ($ratings->save()) {
                redirect("/author?name=$name");
            }
        }

        $view = [
            'errors' => [],
            'author' => $author,
            'rating' => $rating->total,
        ];
        $this->view->render('author', $view);
    }

    public function account(Request $request, Response $response)
    {
        if (!$this->currentUser)
            abort();

        $uid = $this->currentUser->uid;

        $params = [
            'columns' => "username, surname, name, email, avatar, phone, social, bio, acl",
            'conditions' => "uid = :uid",
            'bind' => ['uid' => $uid],
            'limit' => 1
        ];

        $user = Users::findFirst($params);
        if (!$user)
            abort(Response::NOT_FOUND);

        if ($user && $user->acl !== "user") {
            $article_params = [
                'conditions' => "user_id = :user_id",
                'bind' => ['user_id' => $uid],
            ];

            $rating_params = [
                'columns' => "SUM(rating) as total",
                'conditions' => "name = :name",
                'bind' => ['name' => $user->username],
            ];

            $article_count = Articles::findTotal($article_params);
            $rating = Ratings::findFirst($rating_params);
        }

        $view = [
            'errors' => [],
            'user' => $user,
            'article_count' => $article_count,
            'rating' => $rating->total,
        ];
        $this->view->render('docs/profile', $view);
    }

    public function account_edit(Request $request, Response $response)
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

        if ($request->isPatch()) {
            $user->loadData($request->getBody());

            if ($user->token) {
                $user->token = Bcrypt::hashPassword($user->token);
            }

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
                    redirect('/account');
                }
            }
        }

        $view = [
            'errors' => $user->getErrors(),
            'user' => $user,
        ];
        $this->view->render('docs/profile_edit', $view);
    }

    public function change_password(Request $request, Response $response)
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
        $isError = true;


        if ($request->isPatch()) {
            $user->loadData($request->getBody());
            $user->validateChangePassword();

            if (empty($user->getErrors())) {
                $u = Users::findFirst($params);

                if ($user) {
                    $verified = password_verify($request->post('old_password'), $u->password);
                    if ($verified) {
                        $isError = false;
                        if ($user->save()) {
                            Application::$app->session->setFlash("success", "Your password has been changed successfully");
                            redirect('/account');
                        }
                    } else {
                        Application::$app->session->setFlash("success", "Your password is not corret.");
                        redirect('/account/change-password');
                    }
                }
            }

        }

        $view = [
            'errors' => $user->getErrors(),
            'user' => $user,
        ];
        $this->view->render('docs/change_password', $view);
    }

    public function contact(Request $request, Response $response)
    {
        if ($request->isPost()) {
            $contact = new Contacts();

            $contact->loadData($request->getBody());

            if ($contact->save()) {
                Application::$app->session->setFlash("success", "{$contact->name} Message Sent, Thanks for contacting Us.");
                redirect('/contact');
            }
        }

        $view = [
            'errors' => [],
        ];
        $this->view->render('contact', $view);
    }

    // Start of Comment.

    public function comments(Request $request, Response $response)
    {
        $slug = $request->get('slug');

        if ($request->isPost()) {
            if ($request->post("comment_load_data")) {
                $params = [
                    'conditions' => "article_slug = :article_slug AND status = :status",
                    'bind' => ['article_slug' => $slug, 'status' => 'active'],
                    'order' => 'created_at DESC'
                ];

                $comments = Comments::find($params);

                if ($comments) {
                    $this->json_response($comments);
                } else {
                    $this->json_response("Give a Comment.");
                }

            }
        }
    }

    public function add_comment(Request $request, Response $response)
    {
        $comment = new Comments();

        if ($request->isPost()) {
            if ($request->post('add_comment')) {
                $comment->loadData($request->getBody());
                if ($this->currentUser) {
                    $comment->user = $this->currentUser->surname . ' ' . $this->currentUser->name;
                } else {
                    $comment->user = 'anonymous';
                }

                if ($comment->save()) {
                    $this->json_response("Comment Added Successfully.");
                } else {
                    $this->json_response("Comment not added, Something went wrong.");
                }
            }
        }
    }

    public function add_reply_comment(Request $request, Response $response)
    {
        $comment_replies = new CommentReplies();

        if ($request->isPost()) {
            if ($request->post('add_reply')) {
                $comment_replies->loadData($request->getBody());
                if ($this->currentUser) {
                    $comment_replies->user = $this->currentUser->surname . ' ' . $this->currentUser->name;
                } else {
                    $comment_replies->user = 'anonymous';
                }
                if ($comment_replies->save()) {
                    $this->json_response("Comment Replied Successfully.");
                } else {
                    $this->json_response("Comment not Replied, Something went wrong.");
                }
            }
        }
    }

    public function view_comment_replies(Request $request, Response $response)
    {
        if ($request->isPost()) {
            if ($request->post("view_comment_data")) {
                $comment_id = $request->post("comment_id");

                $params = [
                    'conditions' => "comment_id = :comment_id AND status = :status",
                    'bind' => ['comment_id' => $comment_id, 'status' => 'active'],
                    'order' => 'created_at DESC'
                ];

                $commentReplies = CommentReplies::find($params);

                if ($commentReplies) {
                    $this->json_response($commentReplies);
                } else {
                    $this->json_response("No comment replies yet.");
                }
            }
        }
    }

    public function add_sub_replies(Request $request, Response $response)
    {
        $comment_replies = new CommentReplies();

        if ($request->isPost()) {
            if ($request->post("add_sub_replies")) {
                $comment_replies->loadData($request->getBody());
                if ($this->currentUser) {
                    $comment_replies->user = $this->currentUser->surname . ' ' . $this->currentUser->name;
                } else {
                    $comment_replies->user = 'anonymous';
                }
                if ($comment_replies->save()) {
                    $this->json_response("Comment Replied Successfully.");
                } else {
                    $this->json_response("Comment not Replied, Something went wrong.");
                }
            }
        }
    }
    // End of Comments.

    public function tags(Request $request, Response $response)
    {
        $currentPage = isset($_GET['page']) ? $_GET['page'] : 1;
        $recordsPerPage = 10;

        $slug = $request->get('slug');
        $tag_name = $request->get('tag_name');

        $params = [
            'columns' => "articles.*, users.username, users.avatar, topics.topic, topics.slug as topic_slug",
            'conditions' => "articles.status = :status AND topics.slug = :slug",
            'bind' => ['status' => 'published', 'slug' => $slug],
            'joins' => [
                ['users', 'articles.user_id = users.uid'],
                ['topics', 'articles.topic = topics.slug', 'topics', 'LEFT']
            ],
            'order' => 'articles.created_at DESC',
            'limit' => $recordsPerPage,
            'offset' => ($currentPage - 1) * $recordsPerPage
        ];

        $total = Articles::findTotal($params);
        $numberOfPages = ceil($total / $recordsPerPage);

        $params = Articles::mergeWithPagination($params);
        $total = Articles::findTotal($params);

        $view = [
            'articles' => Articles::find($params),
            'total' => $total,
            'tag_name' => $tag_name,
            'prevPage' => $this->previous_pagination($currentPage),
            'nextPage' => $this->next_pagination($currentPage, $numberOfPages),
        ];

        $this->view->render('tags', $view);
    }

    public function search(Request $request, Response $response)
    {
        $currentPage = isset($_GET['page']) ? $_GET['page'] : 1;
        $recordsPerPage = 10;

        $search_query = $request->get("q");

        $params = [
            'columns' => "articles.*, users.username, users.avatar, topics.topic, topics.slug as topic_slug",
            'conditions' => "articles.status = :status AND articles.title LIKE :title OR articles.content LIKE :content",
            'bind' => ['status' => 'published', 'title' => "%$search_query%", 'content' => "%$search_query%"],
            'joins' => [
                ['users', 'articles.user_id = users.uid'],
                ['topics', 'articles.topic = topics.slug', 'topics', 'LEFT']
            ],
            'order' => 'articles.created_at DESC',
            'limit' => $recordsPerPage,
            'offset' => ($currentPage - 1) * $recordsPerPage
        ];

        $total = Articles::findTotal($params);
        $numberOfPages = ceil($total / $recordsPerPage);

        $view = [
            'articles' => Articles::find($params),
            'total' => $total,
            'search' => $search_query,
            'prevPage' => $this->previous_pagination($currentPage),
            'nextPage' => $this->next_pagination($currentPage, $numberOfPages),
        ];
        $this->view->render('search', $view);
    }

    public function subscribers(Request $request, Response $response)
    {
        $subscribers = new Subscribers();

        if ($request->isPost()) {
            $subscribers->loadData($request->getBody());

            if ($subscribers->save()) {
                Application::$app->session->setFlash("success", "You are now Subscribe to our newsletter");
                last_uri();
            }
        }
    }

    public function board_post(Request $request, Response $response)
    {
        $slug = $request->get('slug');

        $params = [
            'conditions' => "status = :status AND slug = :slug",
            'bind' => ['status' => 'active', 'slug' => $slug],
            'limit' => "1",
        ];

        $board = BoardPosts::findFirst($params);
        if (!$board)
            abort(Response::NOT_FOUND);

        $view = [
            'board' => $board,
        ];

        $this->view->render("board_post", $view);
    }
}