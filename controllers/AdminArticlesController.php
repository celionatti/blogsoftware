<?php

namespace controllers;

use Exception;
use Core\Request;
use models\Users;
use Core\Response;
use models\Topics;
use Core\Controller;
use models\Articles;
use models\Comments;
use models\Contacts;
use Core\Application;
use models\CommentReplies;
use models\RelatedArticles;
use Core\Support\Helpers\Image;
use Core\Support\Helpers\FileUpload;
use models\Subscribers;

class AdminArticlesController extends Controller
{
    public $currentUser;

    public function onConstruct(): void
    {
        $this->view->setLayout('admin');
        $this->currentUser = Users::getCurrentUser();
    }

    public function articles(Request $request, Response $response)
    {
        $currentPage = isset($_GET['page']) ? $_GET['page'] : 1;
        $recordsPerPage = 5;

        $params = [
            'columns' => "articles.*, topics.topic",
            'conditions' => "articles.status = :status",
            'joins' => [
                ['topics', 'articles.topic = topics.slug'],
            ],
            'bind' => ['status' => 'published'],
            'order' => 'articles.id DESC',
            'limit' => $recordsPerPage,
            'offset' => ($currentPage - 1) * $recordsPerPage
        ];

        $total = Articles::findTotal($params);
        $numberOfPages = ceil($total / $recordsPerPage);

        $view = [
            'navigations' => [
                ['label' => 'Dashboard', 'url' => 'admin'],
                ['label' => 'Articles', 'url' => '']
            ],
            'errors' => [],
            'articles' => Articles::find($params),
            'prevPage' => $this->previous_pagination($currentPage),
            'nextPage' => $this->next_pagination($currentPage, $numberOfPages),
        ];

        $this->view->render('admin/articles/index', $view);
    }

    public function drafts(Request $request, Response $response)
    {
        $currentPage = isset($_GET['page']) ? $_GET['page'] : 1;
        $recordsPerPage = 5;

        $params = [
            'columns' => "articles.*, topics.topic",
            'conditions' => "articles.status = :status",
            'joins' => [
                ['topics', 'articles.topic = topics.slug'],
            ],
            'bind' => ['status' => 'draft'],
            'order' => 'articles.id DESC',
            'limit' => $recordsPerPage,
            'offset' => ($currentPage - 1) * $recordsPerPage
        ];

        $total = Articles::findTotal($params);
        $numberOfPages = ceil($total / $recordsPerPage);

        $view = [
            'navigations' => [
                ['label' => 'Dashboard', 'url' => 'admin'],
                ['label' => 'Articles', 'url' => 'admin/articles'],
                ['label' => 'Drafts', 'url' => 'admin/articles/drafts']
            ],
            'errors' => [],
            'articles' => Articles::find($params),
            'prevPage' => $this->previous_pagination($currentPage),
            'nextPage' => $this->next_pagination($currentPage, $numberOfPages),
        ];

        $this->view->render('admin/articles/drafts', $view);
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
            'navigations' => [
                ['label' => 'Dashboard', 'url' => 'admin'],
                ['label' => 'Articles', 'url' => 'admin/articles'],
                ['label' => 'Create Article', 'url' => 'admin/articles/create']
            ],
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
            'navigations' => [
                ['label' => 'Dashboard', 'url' => 'admin'],
                ['label' => 'Articles', 'url' => 'admin/articles'],
                ['label' => 'Edit Article', 'url' => 'admin/articles/edit']
            ],
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
            'navigations' => [
                ['label' => 'Dashboard', 'url' => 'admin'],
                ['label' => 'Articles', 'url' => 'admin/articles'],
                ['label' => 'Delete Article', 'url' => '']
            ],
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
            'conditions' => "status = :status AND title LIKE :title OR author LIKE :author OR topic LIKE :topic",
            'bind' => ['status' => 'published', 'title' => "%$article->title%", 'author' => "%$article->author%", 'topic' => "%$article->topic%"],
            'order' => "created_at DESC",
            'limit' => $recordsPerPage,
            'offset' => ($currentPage - 1) * $recordsPerPage
        ];


        $total = Articles::findTotal($params);
        $numberOfPages = ceil($total / $recordsPerPage);

        $view = [
            'navigations' => [
                ['label' => 'Dashboard', 'url' => 'admin'],
                ['label' => 'Articles', 'url' => 'admin/articles'],
                ['label' => 'Related Article', 'url' => '']
            ],
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
                last_uri();
            }
        }
    }

    public function remove_related_articles(Request $request, Response $response)
    {
        if ($request->post('article_slug') == $request->post('related_slug')) {
            Application::$app->session->setFlash("error", "Article with the same title can't be removed");
            last_uri();
        }

        if ($request->isDelete()) {
            $params = [
                'conditions' => "article_slug = :article_slug AND related_slug = :related_slug",
                'bind' => ['article_slug' => $request->post('article_slug'), 'related_slug' => $request->post('related_slug')]
            ];

            $related_article = RelatedArticles::findFirst($params);
            if ($related_article) {
                if ($related_article->delete()) {
                    Application::$app->session->setFlash("success", "Related Article Deleted Successfully.");
                    last_uri();
                }
            }
        }
    }

    public function comments_article(Request $request, Response $response)
    {
        $slug = $request->get('article-slug');

        $currentPage = isset($_GET['page']) ? $_GET['page'] : 1;
        $recordsPerPage = 10;

        $params = [
            'conditions' => "slug = :slug",
            'bind' => ['slug' => $slug]
        ];

        $article = Articles::findFirst($params);

        $comments_params = [
            'conditions' => "article_slug = :article_slug",
            'bind' => ['article_slug' => $slug],
            'order' => "created_at DESC",
            'limit' => $recordsPerPage,
            'offset' => ($currentPage - 1) * $recordsPerPage
        ];

        $total = Articles::findTotal($params);
        $numberOfPages = ceil($total / $recordsPerPage);

        $view = [
            'navigations' => [
                ['label' => 'Dashboard', 'url' => 'admin'],
                ['label' => 'Articles', 'url' => 'admin/articles'],
                ['label' => 'Comments', 'url' => '']
            ],
            'article' => $article,
            'comments' => Comments::find($comments_params),
            'prevPage' => $this->previous_pagination($currentPage),
            'nextPage' => $this->next_pagination($currentPage, $numberOfPages),
        ];

        $this->view->render("admin/articles/comments", $view);
    }

    public function comments_article_replies(Request $request, Response $response)
    {
        $slug = $request->get('article-slug');
        $comment_id = $request->get('comment-id');

        $currentPage = isset($_GET['page']) ? $_GET['page'] : 1;
        $recordsPerPage = 10;

        $params = [
            'conditions' => "slug = :slug",
            'bind' => ['slug' => $slug]
        ];

        $article = Articles::findFirst($params);

        $comment_replies_params = [
            'conditions' => "comment_id = :comment_id",
            'bind' => ['comment_id' => $comment_id],
            'order' => "created_at DESC",
            'limit' => $recordsPerPage,
            'offset' => ($currentPage - 1) * $recordsPerPage
        ];

        $total = Articles::findTotal($params);
        $numberOfPages = ceil($total / $recordsPerPage);

        $view = [
            'navigations' => [
                ['label' => 'Dashboard', 'url' => 'admin'],
                ['label' => 'Articles', 'url' => 'admin/articles'],
                ['label' => 'Comments', 'url' => 'admin/articles/comments'],
                ['label' => 'Comment Replies', 'url' => '']
            ],
            'article' => $article,
            'comments' => CommentReplies::find($comment_replies_params),
            'prevPage' => $this->previous_pagination($currentPage),
            'nextPage' => $this->next_pagination($currentPage, $numberOfPages),
        ];

        $this->view->render("admin/articles/comment_replies", $view);
    }

    public function comments_article_trash(Request $request, Response $response)
    {
        $params = [
            'conditions' => "id = :id",
            'bind' => ['id' => $request->post('comment_id')]
        ];

        $comment = Comments::findFirst($params);

        if (!$comment) {
            Application::$app->session->setFlash("success", "Comment Not Found");
            last_uri();
        }

        if ($request->isDelete()) {
            if ($comment) {

                $comment_replies_params = [
                    'conditions' => "comment_id = :comment_id",
                    'bind' => ['comment_id' => $comment->id]
                ];

                $replies = CommentReplies::find($comment_replies_params);

                if (!$replies) {
                    return;
                } else {
                    foreach ($replies as $reply) {
                        $reply->delete();
                    }
                }

                if ($comment->delete()) {
                    Application::$app->session->setFlash("success", "Comment Deleted successfully");
                }
            }
            last_uri();
        }
    }

    public function comments_article_status(Request $request, Response $response)
    {
        $params = [
            'conditions' => "id = :id",
            'bind' => ['id' => $request->post('comment_id')]
        ];

        $comment = Comments::findFirst($params);

        if (!$comment) {
            Application::$app->session->setFlash("success", "Comment Not Found");
            last_uri();
        }

        if ($request->isPatch()) {
            if ($comment) {
                $comment->loadData($request->getBody());
                if ($comment->save()) {
                    Application::$app->session->setFlash("success", "Comment Updated successfully");
                }
            }
            last_uri();
        }
    }

    public function comments_article_replies_trash(Request $request, Response $response)
    {
        $params = [
            'conditions' => "id = :id",
            'bind' => ['id' => $request->post('comment_id')]
        ];

        $comment = CommentReplies::findFirst($params);

        if (!$comment) {
            Application::$app->session->setFlash("success", "Comment Not Found");
            last_uri();
        }

        if ($request->isDelete()) {
            if ($comment) {
                if ($comment->delete()) {
                    Application::$app->session->setFlash("success", "Comment Deleted successfully");
                    last_uri();
                }
            }
        }
    }

    public function comments_article_replies_status(Request $request, Response $response)
    {
        $params = [
            'conditions' => "id = :id",
            'bind' => ['id' => $request->post('comment_id')]
        ];

        $comment = CommentReplies::findFirst($params);

        if (!$comment) {
            Application::$app->session->setFlash("success", "Comment Not Found");
            last_uri();
        }

        if ($request->isPatch()) {
            if ($comment) {
                $comment->loadData($request->getBody());
                if ($comment->save()) {
                    Application::$app->session->setFlash("success", "Comment Updated successfully");
                    last_uri();
                }
            }
        }
    }

    public function featured_article(Request $request, Response $response)
    {
        $slug = $request->post('article_slug');

        $params = [
            'conditions' => "slug = :slug",
            'bind' => ['slug' => $slug]
        ];
        $article_featured = Articles::findFirst([
            'conditions' => "featured = :featured",
            'bind' => ['featured' => "1"]
        ]);

        if ($article_featured) {
            $article_featured->featured = 0;
            $article_featured->save();
        }
        
        $article = Articles::findFirst($params);

        if ($article) {
            $article->loadData($request->getBody());
            if ($article->save()) {
                Application::$app->session->setFlash("success", "Article Featured successfully");
                last_uri();
            }
        }
    }
}
