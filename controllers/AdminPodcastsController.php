<?php

namespace controllers;

use Exception;
use Core\Request;
use models\Users;
use Core\Response;
use Core\Controller;
use Core\Support\Helpers\Image;
use Core\Support\Helpers\FileUpload;

class AdminPodcastsController extends Controller
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
            'podcasts' => Users::find(),
        ];
        $this->view->render('admin/podcasts', $view);
    }
}