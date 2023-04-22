<?php

namespace controllers;

use Exception;
use Core\Request;
use models\Users;
use Core\Response;
use Core\Controller;
use Core\Application;
use models\BoardPosts;
use Core\Support\Helpers\Image;
use Core\Support\Helpers\FileUpload;

class AdminBoardPostsController extends Controller
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
            'conditions' => "status = :status",
            'bind' => ['status' => 'active'],
            'order' => 'created_at DESC',
            'limit' => $recordsPerPage,
            'offset' => ($currentPage - 1) * $recordsPerPage
        ];

        $total = BoardPosts::findTotal($params);
        $numberOfPages = ceil($total / $recordsPerPage);

        $view = [
            'errors' => [],
            'boards' => BoardPosts::find($params),
            'prevPage' => $this->previous_pagination($currentPage),
            'nextPage' => $this->next_pagination($currentPage, $numberOfPages),
        ];

        $this->view->render('admin/board/index', $view);
    }

    public function create(Request $request, Response $response)
    {
        $boardPost = new BoardPosts();

        if ($request->isPost()) {
            $boardPost->loadData($request->getBody());
            $boardPost->user_id = $this->currentUser->uid;
            $upload = new FileUpload('thumbnail');

            $uploadErrors = $upload->validate();

            if (!empty($uploadErrors)) {
                foreach ($uploadErrors as $field => $error) {
                    $boardPost->setError($field, $error);
                }
            }

            if (empty($boardPost->getErrors())) {
                if ($boardPost->save()) {
                    $upload->directory('uploads/board_posts');
                    if (!empty($upload->tmp)) {
                        if ($upload->upload()) {
                            if (file_exists($boardPost->thumbnail)) {
                                unlink($boardPost->thumbnail);
                                $boardPost->thumbnail = "";
                            }
                            $boardPost->thumbnail = $upload->fc;
                            $image = new Image();
                            $image->resize($boardPost->thumbnail);
                            $boardPost->save();
                        }
                    }
                    Application::$app->session->setFlash("success", "{$boardPost->title} Saved successfully.");
                    redirect('/admin/board-posts');
                }
            }
        }

        $view = [
            'errors' => $boardPost->getErrors(),
            'board' => $boardPost
        ];
        $this->view->render('admin/board/create', $view);
    }

    public function edit(Request $request, Response $response)
    {
        $slug = $request->get('slug');

        $params = [
            'conditions' => "slug = :slug",
            'bind' => ['slug' => $slug]
        ];
        $boardPost = BoardPosts::findFirst($params);

        if ($request->isPatch()) {
            $boardPost->loadData($request->getBody());
            $boardPost->user_id = $this->currentUser->uid;
            $upload = new FileUpload('thumbnail');

            $uploadErrors = $upload->validate();

            if (!empty($uploadErrors)) {
                foreach ($uploadErrors as $field => $error) {
                    $boardPost->setError($field, $error);
                }
            }

            if (empty($boardPost->getErrors())) {
                if ($boardPost->save()) {
                    $upload->directory('uploads/board_posts');
                    if (!empty($upload->tmp)) {
                        if ($upload->upload()) {
                            if (file_exists($boardPost->thumbnail)) {
                                unlink($boardPost->thumbnail);
                                $boardPost->thumbnail = "";
                            }
                            $boardPost->thumbnail = $upload->fc;
                            $image = new Image();
                            $image->resize($boardPost->thumbnail);
                            $boardPost->save();
                        }
                    }
                    Application::$app->session->setFlash("success", "{$boardPost->title} Saved successfully.");
                    redirect('/admin/board-posts');
                }
            }
        }

        $view = [
            'errors' => $boardPost->getErrors(),
            'board' => $boardPost
        ];
        $this->view->render('admin/board/edit', $view);
    }
}