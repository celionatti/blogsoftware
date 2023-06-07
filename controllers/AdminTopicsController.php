<?php

namespace controllers;

use Core\Request;
use models\Users;
use Core\Response;
use models\Topics;
use Core\Controller;
use Core\Application;

class AdminTopicsController extends Controller
{
    public $currentUser;

    public function onConstruct(): void
    {
        $this->view->setLayout('admin');
        $this->currentUser = Users::getCurrentUser();
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

}