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
use Core\Support\Helpers\Image;
use Core\Support\Helpers\FileUpload;

class SettingsController extends Controller
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
            'limit' => $recordsPerPage,
            'offset' => ($currentPage - 1) * $recordsPerPage
        ];

        $total = Settings::findTotal($params);
        $numberOfPages = ceil($total / $recordsPerPage);

        $view = [
            'settings' => Settings::find($params),
            'prevPage' => $this->previous_pagination($currentPage),
            'nextPage' => $this->next_pagination($currentPage, $numberOfPages),
        ];
        $this->view->render('admin/extras/settings', $view);
    }

    public function create(Request $request, Response $response)
    {
        $settings = new Settings();

        if($request->isPost()) {
            $settings->loadData($request->getBody());

            if (empty($settings->getErrors())) {
                if ($settings->save()) {
                    Application::$app->session->setFlash("success", "Setting {$settings->name} Saved Successfully!");
                    redirect('/admin/settings');
                }
            }
        }

        $view = [
            'errors' => $settings->getErrors(),
            'typeOpts' => [
                'text' => 'Text',
                'link' => 'Link',
                'image' => 'Image'
            ],
            'setting' => $settings,
        ];

        $this->view->render('admin/extras/create-setting', $view);
    }

    public function edit(Request $request, Response $response)
    {
        $id = $request->get('setting-id');
        $name = $request->get('setting-name');

        $params = [
            'conditions' => "id = :id AND name = :name",
            'bind' => ['id' => $id, 'name' => $name]
        ];
        $settings = Settings::findFirst($params);

        if($request->isPatch()) {
            $settings->loadData($request->getBody());

            if ($settings->type === "image") {
                $upload = new FileUpload('value');
                $uploadErrors = $upload->validate();
            }


            if ($settings->type === "image" && !empty($uploadErrors)) {
                foreach ($uploadErrors as $field => $error) {
                    $settings->setError($field, $error);
                }
            }

            if (empty($settings->getErrors())) {
                if ($settings->save()) {
                    if ($settings->type === "image") {
                        $upload->directory('uploads/settings');
                    }
                    if ($settings->type === "image" && !empty($upload->tmp)) {
                        if ($settings->type === "image" && $upload->upload()) {
                            if (file_exists($settings->value)) {
                                unlink($settings->value);
                                $settings->value = "";
                            }
                            $settings->value = $upload->fc;
                            $image = new Image();
                            $image->resize($settings->value);
                            $settings->save();
                        }
                    }
                    Application::$app->session->setFlash("success", "Setting {$settings->name} Updated Successfully!");
                    redirect('/admin/settings');
                }
            }
        }

        $view = [
            'errors' => $settings->getErrors(),
            'typeOpts' => [
                'text' => 'Text',
                'link' => 'Link',
                'image' => 'Image'
            ],
            'setting' => $settings,
        ];

        $this->view->render('admin/extras/edit-setting', $view);
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