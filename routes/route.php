<?php

/** @var $router */

use controllers\AuthController;
use controllers\SiteController;
use controllers\AdminController;

$router->get('/', [SiteController::class, 'index']);

$router->get('/register', [AuthController::class, 'register']);
$router->post('/register', [AuthController::class, 'register']);
$router->get('/login', [AuthController::class, 'login']);
$router->post('/login', [AuthController::class, 'login']);

// Admin
$router->get('/admin', [AdminController::class, 'index']);

$router->get('/admin/articles', [AdminController::class, 'articles']);
$router->get('/admin/articles/create', [AdminController::class, 'create_article']);
$router->post('/admin/articles/create', [AdminController::class, 'create_article']);
$router->get('/admin/articles/edit', [AdminController::class, 'edit_article']);
$router->patch('/admin/articles/edit', [AdminController::class, 'edit_article']);
$router->get('/admin/articles/trash', [AdminController::class, 'trash_article']);
$router->delete('/admin/articles/trash', [AdminController::class, 'trash_article']);

$router->get('/admin/users', [AdminController::class, 'users']);
$router->get('/admin/users/create', [AdminController::class, 'create_user']);
$router->post('/admin/users/create', [AdminController::class, 'create_user']);
$router->get('/admin/users/edit', [AdminController::class, 'edit_user']);
$router->patch('/admin/users/edit', [AdminController::class, 'edit_user']);
$router->get('/admin/users/delete', [AdminController::class, 'delete_user']);
$router->delete('/admin/users/delete', [AdminController::class, 'delete_user']);

$router->get('/admin/topics', [AdminController::class, 'topics']);
$router->get('/admin/topics/create', [AdminController::class, 'create_topic']);
$router->post('/admin/topics/create', [AdminController::class, 'create_topic']);
$router->get('/admin/topics/edit', [AdminController::class, 'edit_topic']);
$router->patch('/admin/topics/edit', [AdminController::class, 'edit_topic']);
$router->get('/admin/topics/delete', [AdminController::class, 'delete_topic']);
$router->delete('/admin/topics/delete', [AdminController::class, 'delete_topic']);

$router->get('/admin/collections/create', [AdminController::class, 'create_collection']);
$router->get('/admin/collections', [AdminController::class, 'collections']);

// $router->get('/users', 'controllers/users.php');