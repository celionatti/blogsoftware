<?php

namespace controllers;

use Exception;
use Core\Request;
use models\Users;
use Core\Response;
use Core\Controller;
use models\Articles;
use models\Comments;
use models\Contacts;
use Core\Application;
use models\CommentReplies;

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
            'featured' => Articles::findFirst($featured_params),
            'articles' => Articles::find($articles_params),
        ];
        $this->view->render('welcome', $view);
    }

    public function news(Request $request, Response $response)
    {
        $currentPage = isset($_GET['page']) ? $_GET['page'] : 1;
        $recordsPerPage = 2;

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

        // $params = Articles::mergeWithPagination($params);
        $total = Articles::findTotal($params);
        $numberOfPages = ceil($total / $recordsPerPage);

        $view = [
            'articles' => Articles::find($params),
            'total' => $total,
            'prevPage' => $currentPage > 1 ? $currentPage - 1 : false,
            'nextPage' => $currentPage + 1 <= $numberOfPages ? $currentPage + 1 : false,
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
            'order' => 'articles.created_at DESC'
        ];

        $params = Articles::mergeWithPagination($params);
        $total = Articles::findTotal($params);

        $view = [
            'articles' => Articles::find($params),
            'total' => $total,
            'tag_name' => $tag_name
        ];

        $this->view->render('tags', $view);
    }

    public function search(Request $request, Response $response)
    {
        $view = [
            'errors' => [],
        ];
        $this->view->render('search', $view);
    }
}