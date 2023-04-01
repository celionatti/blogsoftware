<?php

use Core\Support\FlashMessage;

/** @var $this \Core\View */

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
    <link type="text/css" rel="stylesheet" href="<?= assets_path('bootstrap/css/bootstrap-icons.css'); ?>">
    <link type="text/css" rel="stylesheet" href="<?= assets_path('bootstrap/css/bootstrap.min.css'); ?>">
    <link type="text/css" rel="stylesheet" href="<?= assets_path('css/dashboard.css'); ?>">
    <?php $this->content('header') ?>
    <style>
        .nav-scroller {
            position: relative;
            z-index: 2;
            height: 2.75rem;
            overflow-y: hidden;
        }

        .nav-scroller .nav {
            display: flex;
            flex-wrap: nowrap;
            padding-bottom: 1rem;
            margin-top: -1px;
            overflow-x: auto;
            text-align: center;
            white-space: nowrap;
            -webkit-overflow-scrolling: touch;
        }

        .sp-container {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            /* set a dark background color */
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 9999;
            /* display: none; */
        }

        .spinner {
            margin: 100px auto;
            width: 40px;
            height: 40px;
            position: relative;
            border-top: 3px solid rgba(0, 0, 0, 0.1);
            border-right: 3px solid rgba(0, 0, 0, 0.1);
            border-bottom: 3px solid rgba(0, 0, 0, 0.1);
            border-left: 3px solid #818a91;
            border-radius: 50%;
            animation: spin 1s ease-in-out infinite;
            display: flex;
            /* hide the spinner by default */
        }

        @keyframes spin {
            from {
                transform: rotate(0deg);
            }

            to {
                transform: rotate(360deg);
            }
        }
    </style>
</head>

<body style="background: #eee">
    <div class="sp-container">
        <div class="spinner"></div>
    </div>

    <?php $this->partial('admin-header') ?>

    <?= FlashMessage::bootstrap_alert(); ?>

    <div class="container-fluid">
        <div class="row">
            <?php $this->partial('admin-sidebar') ?>
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <?php $this->partial('admin-crumbs') ?>
                <?php $this->content('content'); ?>
            </main>
        </div>
    </div>

    <script src="<?= assets_path('js/jquery-3.6.3.min.js'); ?>"></script>
    <script src="<?= assets_path('bootstrap/js/bootstrap.bundle.min.js'); ?>"></script>
    <script>
        $(document).ready(function () {
            $(".spinner").hide();
            $(".sp-container").hide();
        });
    </script>

    <?php $this->content('script') ?>
</body>

</html>