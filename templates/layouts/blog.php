<?php


use Core\Support\FlashMessage;


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?= $this->getTitle(); ?>
    </title>
    <link type="text/css" rel="stylesheet" href="<?= assets_path('bootstrap/css/bootstrap.min.css'); ?>">
    <link type="text/css" rel="stylesheet" href="<?= assets_path('bootstrap/css/bootstrap-icons.css'); ?>">
    <link type="text/css" rel="stylesheet" href="<?= assets_path('css/styles.css'); ?>">
    <?php $this->content('header') ?>
    <style>
        #main-container {
            padding-bottom: 80px;
        }
    </style>
</head>

<body style="background: #eee">

    <div class="container-fluid">
        <?= FlashMessage::bootstrap_alert(); ?>
        <?php $this->partial('header') ?>
        <main class="container pb-5">
            <?php $this->content('content'); ?>
        </main>
        <?php $this->partial('footer') ?>
    </div>

    <script src="<?= assets_path('js/jquery-3.6.3.min.js'); ?>"></script>
    <script src="<?= assets_path('bootstrap/js/bootstrap.bundle.min.js'); ?>"></script>

    <?php $this->content('script') ?>

</body>

</html>