<?php

/** @var $router */

use controllers\AuthController;
use controllers\DocsController;
use controllers\SiteController;
use controllers\AdminController;
use controllers\TasksController;
use controllers\SettingsController;
use controllers\AdminTasksController;
use controllers\AdminUsersController;
use controllers\AdminTopicsController;
use controllers\AdminCreditsController;
use controllers\AdminArticlesController;
use controllers\AdminPodcastsController;
use controllers\AdminBoardPostsController;
use controllers\WalletController;

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
$router->get('/search', [SiteController::class, 'search']);
$router->get('/author', [SiteController::class, 'author']);
$router->post('/author', [SiteController::class, 'author']);
$router->get('/account', [SiteController::class, 'account']);
$router->get('/account/edit', [SiteController::class, 'account_edit']);
$router->patch('/account/edit', [SiteController::class, 'account_edit']);
$router->get('/account/change-password', [SiteController::class, 'change_password']);
$router->patch('/account/change-password', [SiteController::class, 'change_password']);
$router->get('/account/request-wallet', [WalletController::class, 'request_wallet']);
$router->post('/account/request-wallet', [WalletController::class, 'request_wallet']);
$router->get('/account/request-withdrawal', [WalletController::class, 'request_withdrawal']);
$router->post('/account/request-withdrawal', [WalletController::class, 'request_withdrawal']);

$router->get('/register', [AuthController::class, 'register']);
$router->post('/register', [AuthController::class, 'register']);
$router->get('/login', [AuthController::class, 'login']);
$router->post('/login', [AuthController::class, 'login']);
$router->get('/forgot_password', [AuthController::class, 'forgot_password']);
$router->post('/forgot_password', [AuthController::class, 'forgot_password']);
$router->get('/change_password', [AuthController::class, 'change_password']);
$router->patch('/change_password', [AuthController::class, 'change_password']);

$router->post('/logout', [AuthController::class, 'logout']);

// Policy & Terms
$router->get('/docs/policy', [DocsController::class, 'policy']);
$router->get('/docs/terms', [DocsController::class, 'terms']);

// Quiz AND Tasks
$router->get('/task/registration', [TasksController::class, 'task_registration']);
$router->post('/task/registration', [TasksController::class, 'task_registration']);
$router->get('/quiz/confirm', [TasksController::class, 'quiz_confirm']);
$router->post('/quiz', [TasksController::class, 'quiz']);
$router->get('/quiz', [TasksController::class, 'quiz']);
$router->get('/quiz/submit', [TasksController::class, 'quiz_submit']);

// Admin
$router->get('/admin', [AdminController::class, 'index'])->only('admin');

// Admin Articles
$router->get('/admin/articles', [AdminArticlesController::class, 'articles'])->only('admin');
$router->get('/admin/articles/drafts', [AdminArticlesController::class, 'drafts'])->only('admin');
$router->get('/admin/articles/create', [AdminArticlesController::class, 'create_article'])->only('admin');
$router->post('/admin/articles/create', [AdminArticlesController::class, 'create_article'])->only('admin');
$router->get('/admin/articles/edit', [AdminArticlesController::class, 'edit_article'])->only('admin');
$router->patch('/admin/articles/edit', [AdminArticlesController::class, 'edit_article'])->only('admin');
$router->get('/admin/articles/trash', [AdminArticlesController::class, 'trash_article'])->only('admin');
$router->delete('/admin/articles/trash', [AdminArticlesController::class, 'trash_article'])->only('admin');
$router->get('/admin/articles/related-articles', [AdminArticlesController::class, 'related_articles'])->only('admin');
$router->post('/admin/articles/related-articles/add', [AdminArticlesController::class, 'add_related_articles'])->only('admin');
$router->delete('/admin/articles/related-articles/remove', [AdminArticlesController::class, 'remove_related_articles'])->only('admin');
$router->get('/admin/articles/comments-article', [AdminArticlesController::class, 'comments_article'])->only('admin');
$router->get('/admin/articles/comments-article/replies', [AdminArticlesController::class, 'comments_article_replies'])->only('admin');
$router->delete('/admin/articles/comments-article/trash', [AdminArticlesController::class, 'comments_article_trash'])->only('admin');
$router->patch('/admin/articles/comments-article/status', [AdminArticlesController::class, 'comments_article_status'])->only('admin');
$router->delete('/admin/articles/comments-article/replies/trash', [AdminArticlesController::class, 'comments_article_replies_trash'])->only('admin');
$router->patch('/admin/articles/comments-article/replies/status', [AdminArticlesController::class, 'comments_article_replies_status'])->only('admin');
$router->patch('/admin/articles/featured-article', [AdminArticlesController::class, 'featured_article'])->only('admin');

// Admin Users
$router->get('/admin/users', [AdminUsersController::class, 'users'])->only('admin');
$router->get('/admin/users/create', [AdminUsersController::class, 'create_user'])->only('admin');
$router->post('/admin/users/create', [AdminUsersController::class, 'create_user'])->only('admin');
$router->get('/admin/users/edit', [AdminUsersController::class, 'edit_user'])->only('admin');
$router->patch('/admin/users/edit', [AdminUsersController::class, 'edit_user'])->only('admin');
$router->get('/admin/users/delete', [AdminUsersController::class, 'delete_user'])->only('admin');
$router->delete('/admin/users/delete', [AdminUsersController::class, 'delete_user'])->only('admin');

// Admin Topics
$router->get('/admin/topics', [AdminTopicsController::class, 'topics'])->only('admin');
$router->get('/admin/topics/create', [AdminTopicsController::class, 'create_topic'])->only('admin');
$router->post('/admin/topics/create', [AdminTopicsController::class, 'create_topic'])->only('admin');
$router->get('/admin/topics/edit', [AdminTopicsController::class, 'edit_topic'])->only('admin');
$router->patch('/admin/topics/edit', [AdminTopicsController::class, 'edit_topic'])->only('admin');
$router->get('/admin/topics/delete', [AdminTopicsController::class, 'delete_topic'])->only('admin');
$router->delete('/admin/topics/delete', [AdminTopicsController::class, 'delete_topic'])->only('admin');

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
$router->get('/admin/tasks/participants', [AdminTasksController::class, 'participants'])->only('admin');
$router->patch('/admin/tasks/participant/status', [AdminTasksController::class, 'participant_status'])->only('admin');
$router->delete('/admin/tasks/participants/trash', [AdminTasksController::class, 'participant_trash'])->only('admin');
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

// Admin Credits
$router->get('/admin/credits', [AdminCreditsController::class, 'index'])->only('admin');
$router->get('/admin/credits/info', [AdminCreditsController::class, 'info'])->only('admin');
$router->post('/admin/credits/info', [AdminCreditsController::class, 'info'])->only('admin');
$router->patch('/admin/credits/withdraw', [AdminCreditsController::class, 'withdraw'])->only('admin');
$router->patch('/admin/credits/status', [AdminCreditsController::class, 'status'])->only('admin');
$router->get('/admin/wallets', [AdminCreditsController::class, 'wallets'])->only('admin');


// Admin Settings
$router->get('/admin/settings', [SettingsController::class, 'index'])->only('admin');
$router->get('/admin/settings/create', [SettingsController::class, 'create'])->only('admin');
$router->post('/admin/settings/create', [SettingsController::class, 'create'])->only('admin');
$router->get('/admin/settings/trash', [SettingsController::class, 'trash'])->only('admin');
$router->get('/admin/settings/edit', [SettingsController::class, 'edit'])->only('admin');
$router->patch('/admin/settings/edit', [SettingsController::class, 'edit'])->only('admin');

// $router->get('/users', 'controllers/users.php');