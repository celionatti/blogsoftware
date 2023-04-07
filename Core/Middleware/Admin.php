<?php

namespace Core\Middleware;

use Core\Application;
use models\Users;

class Admin
{
    public function handle(): void
    {
        $user = Users::getCurrentUser();
        $allowed = $user && $user->hasPermission(['admin']);
        if (!$allowed) {
            Application::$app->session->setFlash("success", "You do not have access to this page.");
            redirect("/");
        }
    }
}