<?php

?>

<div class="container">
    <header class="blog-header lh-1 py-3">
        <div class="row flex-nowrap justify-content-between align-items-center">
            <div class="col-4 pt-1">
                <a class="link-secondary" href="#">Subscribe</a>
            </div>
            <div class="col-4 text-center">
                <a class="blog-header-logo text-dark" href="#">
                    <h2>Natti Attention</h2>
                </a>
            </div>
            <div class="col-4 d-flex justify-content-end align-items-center">
                <button type="button" class="btn text-secondary ms-3" data-bs-toggle="modal"
                    data-bs-target="#searchModal">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" stroke="currentColor"
                        stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="mx-3" role="img"
                        viewBox="0 0 24 24">
                        <title>Search</title>
                        <circle cx="10.5" cy="10.5" r="7.5" />
                        <path d="M21 21l-5.2-5.2" />
                    </svg>
                </button>
                <a class="btn btn-sm btn-outline-secondary" href="/register">Sign up / Login</a>
            </div>
        </div>
        <!-- Search Modal -->
        <div class="modal fade mx-auto" id="searchModal" tabindex="-1">
            <div class="modal-dialog modal-fullscreen">
                <div class="modal-content" style="background: rgba(29, 29, 39, 0.7);">
                    <div class="modal-header border-0">
                        <button type="button" class="btn bg-white btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body d-flex align-items-center justify-content-center">
                        <div class="input-group" style="max-width: 600px;">
                            <input type="text" class="form-control bg-transparent border-light p-3 text-white"
                                placeholder="Type search keyword" />
                            <button class="btn btn-light px-4">
                                <span class="bi bi-search"></span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <nav class="navbar navbar-expand navbar-dark bg-dark" aria-label="The Buzz Navbar">
        <div class="container-fluid">
            <div class="collapse navbar-collapse" id="navbarBuzz">
                <ul class="navbar-nav mx-auto">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="/">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/blog">Blog</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/contact">Contact</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="nav-scroller py-1 mb-2">
        <nav class="nav d-flex justify-content-between">
            <a class="p-2 link-secondary fw-semibold active" href="#">World</a>
            <a class="p-2 link-secondary fw-semibold" href="#">Nigeria</a>
            <a class="p-2 link-secondary fw-semibold" href="#">Technology</a>
            <a class="p-2 link-secondary fw-semibold" href="#">Design</a>
            <a class="p-2 link-secondary fw-semibold" href="#">Culture</a>
            <a class="p-2 link-secondary fw-semibold" href="#">Business</a>
            <a class="p-2 link-secondary fw-semibold" href="#">Politics</a>
            <a class="p-2 link-secondary fw-semibold" href="#">Opinion</a>
            <a class="p-2 link-secondary fw-semibold" href="#">Health</a>
            <a class="p-2 link-secondary fw-semibold" href="#">Style</a>
            <a class="p-2 link-secondary fw-semibold" href="#">Travel</a>
        </nav>
    </div>
</div>