<?php

use Core\Application;
use Core\Config;

$queryString = Application::$app->queryString;
$currentLink = Application::$app->currentLink;

?>
<!-- Pagination -->
<nav aria-label="Pagination">
    <ul class="d-flex justify-content-evenly align-items-center my-1 pagination">
        <li class="page-item <?= !$this->prevPage ? 'disabled' : '' ?>" aria-current="page">
            <a class="page-link"
                href="<?= Config::get('domain') . $currentLink ?>?<?= $queryString ?>page=<?= $this->prevPage ?>">Prev</a>
        </li>
        <li class="page-item <?= !$this->nextPage ? 'disabled' : '' ?>" aria-current="page">
            <a class="page-link"
                href="<?= Config::get('domain') . $currentLink ?>?<?= $queryString ?>page=<?= $this->nextPage ?>">Next</a>
        </li>
    </ul>
</nav>
<!-- //Pagination -->