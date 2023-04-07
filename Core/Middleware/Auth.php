<?php

namespace Core\Middleware;

use models\Users;
use Core\Application;

class Auth
{
    public function handle(): void
    {
        $user = Users::getCurrentUser();
        $allowed = $user;
        if (!$allowed) {
            Application::$app->session->setFlash("success", "You do not have access to this page.");
            redirect("/");
        }
    }
}