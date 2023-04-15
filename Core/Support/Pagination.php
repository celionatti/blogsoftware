<?php

namespace Core\Support;

use Core\Application;
use Core\Config;

class Pagination
{
    public static function bootstrap_prev_next($prevPage, $nextPage)
    {
        $prevActive = !$prevPage ? "disabled" : "";
        $nextActive = !$nextPage ? "disabled" : "";
        $prevPageLink = Config::get('domain') . Application::$app->currentLink . "?page=" . $prevPage;
        $nextPageLink = Config::get('domain') . Application::$app->currentLink . "?page=" . $nextPage;
        echo "
            <nav aria-label='Pagination'>
                <ul class='d-flex justify-content-evenly align-items-center my-1 pagination'>
                    <li class='page-item $prevActive' aria-current='page'>
                        <a class='page-link'
                            href='$prevPageLink'>Prev</a>
                    </li>
                    <li class='page-item $nextActive' aria-current='page'>
                        <a class='page-link'
                            href='$nextPageLink'>Next</a>
                    </li>
                </ul>
            </nav>
        ";
    }
}