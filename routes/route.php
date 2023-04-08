<?php

/** @var $router */

use controllers\AuthController;
use controllers\SiteController;
use controllers\AdminController;

$router->get('/', [SiteController::class, 'index']);
$router->get('/news', [SiteController::class, 'news']);
$router->get('/news/read', [SiteController::class, 'read']);
$router->post('/news/read/comments', [SiteController::class, 'comments']);
$router->post('/news/read/add_comment', [SiteController::class, 'add_comment']);
$router->post('/news/read/add_reply_comment', [SiteController::class, 'add_reply_comment']);
$router->post('/news/read/view_comment_replies', [SiteController::class, 'view_comment_replies']);
$router->post('/news/read/add_sub_replies', [SiteController::class, 'add_sub_replies']);
$router->get('/tags', [SiteController::class, 'tags']);
$router->get('/contact', [SiteController::class, 'contact']);

$router->get('/register', [AuthController::class, 'register']);
$router->post('/register', [AuthController::class, 'register']);
$router->get('/login', [AuthController::class, 'login']);
$router->post('/login', [AuthController::class, 'login']);

$router->post('/logout', [AuthController::class, 'logout']);

// Admin
$router->get('/admin', [AdminController::class, 'index'])->only('admin');

$router->get('/admin/articles', [AdminController::class, 'articles'])->only('admin');
$router->get('/admin/articles/create', [AdminController::class, 'create_article'])->only('admin');
$router->post('/admin/articles/create', [AdminController::class, 'create_article'])->only('admin');
$router->get('/admin/articles/edit', [AdminController::class, 'edit_article'])->only('admin');
$router->patch('/admin/articles/edit', [AdminController::class, 'edit_article'])->only('admin');
$router->get('/admin/articles/trash', [AdminController::class, 'trash_article'])->only('admin');
$router->delete('/admin/articles/trash', [AdminController::class, 'trash_article'])->only('admin');

$router->get('/admin/users', [AdminController::class, 'users'])->only('admin');
$router->get('/admin/users/create', [AdminController::class, 'create_user'])->only('admin');
$router->post('/admin/users/create', [AdminController::class, 'create_user'])->only('admin');
$router->get('/admin/users/edit', [AdminController::class, 'edit_user'])->only('admin');
$router->patch('/admin/users/edit', [AdminController::class, 'edit_user'])->only('admin');
$router->get('/admin/users/delete', [AdminController::class, 'delete_user'])->only('admin');
$router->delete('/admin/users/delete', [AdminController::class, 'delete_user'])->only('admin');

$router->get('/admin/topics', [AdminController::class, 'topics'])->only('admin');
$router->get('/admin/topics/create', [AdminController::class, 'create_topic'])->only('admin');
$router->post('/admin/topics/create', [AdminController::class, 'create_topic'])->only('admin');
$router->get('/admin/topics/edit', [AdminController::class, 'edit_topic'])->only('admin');
$router->patch('/admin/topics/edit', [AdminController::class, 'edit_topic'])->only('admin');
$router->get('/admin/topics/delete', [AdminController::class, 'delete_topic'])->only('admin');
$router->delete('/admin/topics/delete', [AdminController::class, 'delete_topic'])->only('admin');

$router->get('/admin/collections/create', [AdminController::class, 'create_collection'])->only('admin');
$router->get('/admin/collections', [AdminController::class, 'collections'])->only('admin');

// $router->get('/users', 'controllers/users.php');