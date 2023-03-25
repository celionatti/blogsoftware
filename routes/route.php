<?php

/** @var $router */

use controllers\SiteController;
use controllers\AdminController;

$router->get('/', [SiteController::class, 'index']);

// Admin
$router->get('/admin', [AdminController::class, 'index']);
$router->get('/admin/articles/create', [AdminController::class, 'create_article']);

// $router->get('/users', 'controllers/users.php');