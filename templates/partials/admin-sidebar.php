<?php

?>

<nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
    <div class="position-sticky pt-3 sidebar-sticky">
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="/admin">
                    <span class="align-text-center bi bi-house"></span>
                    Dashboard
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/admin/articles">
                    <span class="align-text-center bi bi-newspaper"></span>
                    Articles
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/admin/topics">
                    <span class="align-text-center bi bi-tags"></span>
                    Topics
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/admin/users">
                    <span class="align-text-center bi bi-people"></span>
                    Users
                </a>
            </li>
        </ul>

        <h6
            class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted text-uppercase">
            <span>Saved reports</span>
            <a class="link-secondary" aria-label="Add a new report">
                <span class="align-text-center bi bi-plus-circle"></span>
            </a>
        </h6>
        <ul class="nav flex-column mb-2">
            <li class="nav-item">
                <a class="nav-link" href="/admin/collections">
                    <span class="align-text-center bi bi-collection"></span>
                    Collections
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/admin/tasks">
                    <span class="align-text-center bi bi-list-task"></span>
                    Tasks
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/admin/messages">
                    <span class="align-text-center bi bi-envelope-paper"></span>
                    Messages
                </a>
            </li>
            <li class="nav-item my-3">
                <a class="nav-link text-danger" href="/">
                    <span class="align-text-center bi bi-globe"></span>
                    Visit Site
                </a>
            </li>
        </ul>
    </div>
</nav>