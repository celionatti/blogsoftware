<?php

use Core\Application;

$currentUser = Application::$app->currentUser;

?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2"><?= $this->getHeader() ?></h1>

    <div class="btn-toolbar mb-2 mb-md-0">
        <button type="button" class="btn btn-sm btn-outline-danger">
            <span class="bi bi-person"></span> <span class="text-capitalize"><?= $currentUser->displayName() ?></span>
        </button>
    </div>
</div>