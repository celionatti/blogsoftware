<?php


use Core\Support\FlashMessage;


?>

<!DOCTYPE html>
<html lang="en" class="h-100">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="<?= assets_path('img/favicon.ico') ?>" />
    <link rel="apple-touch-icon" href="<?= assets_path('img/favicon.ico') ?>" />
    <title>
        <?= $this->getTitle(); ?>
    </title>
    <link type="text/css" rel="stylesheet" href="<?= assets_path('bootstrap/css/bootstrap.min.css'); ?>">
    <link type="text/css" rel="stylesheet" href="<?= assets_path('bootstrap/css/bootstrap-icons.css'); ?>">
    <link type="text/css" rel="stylesheet" href="<?= assets_path('css/cover.css'); ?>">
    <?php $this->content('header') ?>
</head>

<body class="d-flex h-100 text-center text-bg-dark">

    <div class="cover-container d-flex w-100 h-100 p-3 mx-auto flex-column">
        <?= FlashMessage::bootstrap_alert(); ?>
        <?php $this->partial('task-header') ?>
        <main class="px-3">
            <?php $this->content('content'); ?>
        </main>
        <?php $this->partial('task-footer') ?>

    </div>

    <script src="<?= assets_path('js/jquery-3.6.3.min.js'); ?>"></script>
    <script src="<?= assets_path('bootstrap/js/bootstrap.bundle.min.js'); ?>"></script>

    <?php $this->content('script') ?>

</body>

</html>