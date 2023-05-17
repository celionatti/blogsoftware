<?php

namespace controllers;

use Exception;
use Core\Request;
use models\Users;
use Core\Response;
use Core\Controller;
use models\Articles;
use models\Settings;
use Core\Application;

class SettingsController extends Controller
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
        $currentPage = isset($_GET['page']) ? $_GET['page'] : 1;
        $recordsPerPage = 5;

        $params = [
            'limit' => $recordsPerPage,
            'offset' => ($currentPage - 1) * $recordsPerPage
        ];

        $total = Articles::findTotal($params);
        $numberOfPages = ceil($total / $recordsPerPage);

        $view = [
            'settings' => Settings::find($params),
            'prevPage' => $this->previous_pagination($currentPage),
            'nextPage' => $this->next_pagination($currentPage, $numberOfPages),
        ];
        $this->view->render('admin/extras/settings', $view);
    }

    public function trash(Request $request, Response $response)
    {
        $id = $request->get('setting-id');
        $name = $request->get('setting-name');

        $params = [
            'conditions' => "id = :id AND name = :name",
            'bind' => ['id' => $id, 'name' => $name]
        ];
        $setting = Settings::findFirst($params);
        
        if($setting) {
            if($setting->delete()) {
                if (file_exists($setting->value)) {
                    unlink($setting->value);
                    $setting->value = '';
                }
                Application::$app->session->setFlash("success", "{$setting->name} Deleted successfully");
                redirect('/admin/settings');
            }
        }
    }
}