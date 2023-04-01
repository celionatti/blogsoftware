<?php

/** @var $router */

use controllers\SiteController;
use controllers\AdminController;

$router->get('/', [SiteController::class, 'index']);

// Admin
$router->get('/admin', [AdminController::class, 'index']);

$router->get('/admin/articles/create', [AdminController::class, 'create_article']);
$router->get('/admin/articles', [AdminController::class, 'articles']);

$router->get('/admin/users/create', [AdminController::class, 'create_user']);
$router->post('/admin/users/create', [AdminController::class, 'create_user']);
$router->get('/admin/users/edit', [AdminController::class, 'edit_user']);
$router->patch('/admin/users/edit', [AdminController::class, 'edit_user']);
$router->get('/admin/users', [AdminController::class, 'users']);

$router->get('/admin/topics/create', [AdminController::class, 'create_topic']);
$router->get('/admin/topics', [AdminController::class, 'topics']);

$router->get('/admin/collections/create', [AdminController::class, 'create_collection']);
$router->get('/admin/collections', [AdminController::class, 'collections']);

// $router->get('/users', 'controllers/users.php');