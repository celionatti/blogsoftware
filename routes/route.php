<?php

/** @var $router */

use controllers\AuthController;
use controllers\SiteController;
use controllers\AdminController;
use controllers\TasksController;
use controllers\AdminTasksController;
use controllers\AdminPodcastsController;
use controllers\AdminBoardPostsController;

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
$router->post('/contact', [SiteController::class, 'contact']);
$router->post('/subscribers', [SiteController::class, 'subscribers']);
$router->get('/board-post/read', [SiteController::class, 'board_post']);

$router->get('/register', [AuthController::class, 'register']);
$router->post('/register', [AuthController::class, 'register']);
$router->get('/login', [AuthController::class, 'login']);
$router->post('/login', [AuthController::class, 'login']);

$router->post('/logout', [AuthController::class, 'logout']);

// Quiz AND Tasks
$router->get('/task/registration', [TasksController::class, 'task_registration']);
$router->get('/quiz', [TasksController::class, 'quiz']);

// Admin
$router->get('/admin', [AdminController::class, 'index'])->only('admin');

// Admin Articles
$router->get('/admin/articles', [AdminController::class, 'articles'])->only('admin');
$router->get('/admin/articles/drafts', [AdminController::class, 'drafts'])->only('admin');
$router->get('/admin/articles/create', [AdminController::class, 'create_article'])->only('admin');
$router->post('/admin/articles/create', [AdminController::class, 'create_article'])->only('admin');
$router->get('/admin/articles/edit', [AdminController::class, 'edit_article'])->only('admin');
$router->patch('/admin/articles/edit', [AdminController::class, 'edit_article'])->only('admin');
$router->get('/admin/articles/trash', [AdminController::class, 'trash_article'])->only('admin');
$router->delete('/admin/articles/trash', [AdminController::class, 'trash_article'])->only('admin');
$router->get('/admin/articles/related-articles', [AdminController::class, 'related_articles'])->only('admin');
$router->post('/admin/articles/related-articles/add', [AdminController::class, 'add_related_articles'])->only('admin');
$router->delete('/admin/articles/related-articles/remove', [AdminController::class, 'remove_related_articles'])->only('admin');
$router->get('/admin/articles/comments-article', [AdminController::class, 'comments_article'])->only('admin');
$router->get('/admin/articles/comments-article/replies', [AdminController::class, 'comments_article_replies'])->only('admin');
$router->delete('/admin/articles/comments-article/trash', [AdminController::class, 'comments_article_trash'])->only('admin');
$router->patch('/admin/articles/comments-article/status', [AdminController::class, 'comments_article_status'])->only('admin');
$router->delete('/admin/articles/comments-article/replies/trash', [AdminController::class, 'comments_article_replies_trash'])->only('admin');
$router->patch('/admin/articles/comments-article/replies/status', [AdminController::class, 'comments_article_replies_status'])->only('admin');

// Admin Users
$router->get('/admin/users', [AdminController::class, 'users'])->only('admin');
$router->get('/admin/users/create', [AdminController::class, 'create_user'])->only('admin');
$router->post('/admin/users/create', [AdminController::class, 'create_user'])->only('admin');
$router->get('/admin/users/edit', [AdminController::class, 'edit_user'])->only('admin');
$router->patch('/admin/users/edit', [AdminController::class, 'edit_user'])->only('admin');
$router->get('/admin/users/delete', [AdminController::class, 'delete_user'])->only('admin');
$router->delete('/admin/users/delete', [AdminController::class, 'delete_user'])->only('admin');

// Admin Topics
$router->get('/admin/topics', [AdminController::class, 'topics'])->only('admin');
$router->get('/admin/topics/create', [AdminController::class, 'create_topic'])->only('admin');
$router->post('/admin/topics/create', [AdminController::class, 'create_topic'])->only('admin');
$router->get('/admin/topics/edit', [AdminController::class, 'edit_topic'])->only('admin');
$router->patch('/admin/topics/edit', [AdminController::class, 'edit_topic'])->only('admin');
$router->get('/admin/topics/delete', [AdminController::class, 'delete_topic'])->only('admin');
$router->delete('/admin/topics/delete', [AdminController::class, 'delete_topic'])->only('admin');

// Admin Collections
$router->get('/admin/collections/create', [AdminController::class, 'create_collection'])->only('admin');
$router->get('/admin/collections', [AdminController::class, 'collections'])->only('admin');

// Admin Messages
$router->get('/admin/messages', [AdminController::class, 'messages'])->only('admin');
$router->delete('/admin/messages/trash', [AdminController::class, 'trash_messages'])->only('admin');


// Admin Subscribers
$router->get('/admin/subscribers', [AdminController::class, 'subscribers'])->only('admin');
$router->delete('/admin/subscribers/trash', [AdminController::class, 'trash_subscriber'])->only('admin');

// Admin Podcasts
$router->get('/admin/podcasts', [AdminPodcastsController::class, 'index'])->only('admin');

// Admin Tasks
$router->get('/admin/tasks', [AdminTasksController::class, 'index'])->only('admin');
$router->get('/admin/tasks/create', [AdminTasksController::class, 'create_task'])->only('admin');
$router->post('/admin/tasks/create', [AdminTasksController::class, 'create_task'])->only('admin');
$router->get('/admin/tasks/edit', [AdminTasksController::class, 'edit_task'])->only('admin');
$router->patch('/admin/tasks/edit', [AdminTasksController::class, 'edit_task'])->only('admin');
$router->get('/admin/tasks/archive', [AdminTasksController::class, 'archive_task'])->only('admin');
$router->delete('/admin/tasks/trash', [AdminTasksController::class, 'trash_task'])->only('admin');
$router->get('/admin/tasks/view', [AdminTasksController::class, 'view_task'])->only('admin');
$router->get('/admin/tasks/questions', [AdminTasksController::class, 'questions'])->only('admin');
$router->post('/admin/tasks/questions', [AdminTasksController::class, 'questions'])->only('admin');
$router->get('/admin/tasks/questions/question', [AdminTasksController::class, 'question'])->only('admin');
$router->post('/admin/tasks/questions/question', [AdminTasksController::class, 'question'])->only('admin');
$router->get('/admin/tasks/questions/question/edit', [AdminTasksController::class, 'edit_question'])->only('admin');
$router->patch('/admin/tasks/questions/question/edit', [AdminTasksController::class, 'edit_question'])->only('admin');
$router->delete('/admin/tasks/questions/question/trash', [AdminTasksController::class, 'trash_question'])->only('admin');

// Admin Board Posts
$router->get('/admin/board-posts', [AdminBoardPostsController::class, 'index'])->only('admin');
$router->get('/admin/board-posts/create', [AdminBoardPostsController::class, 'create'])->only('admin');
$router->post('/admin/board-posts/create', [AdminBoardPostsController::class, 'create'])->only('admin');
$router->get('/admin/board-posts/edit', [AdminBoardPostsController::class, 'edit'])->only('admin');
$router->patch('/admin/board-posts/edit', [AdminBoardPostsController::class, 'edit'])->only('admin');
$router->delete('/admin/board-posts/trash', [AdminBoardPostsController::class, 'trash'])->only('admin');
$router->patch('/admin/board-posts/status', [AdminBoardPostsController::class, 'status'])->only('admin');

// $router->get('/users', 'controllers/users.php');