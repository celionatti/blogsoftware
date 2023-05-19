<?php

use Core\Config;
use models\Articles;
use models\Settings;
use Core\Application;
use models\RelatedArticles;

$slug = Application::$app->request->get("slug");

$related_articles = RelatedArticles::fetch_related_articles($slug);

$articles = Articles::fetch_articles();

$settings = Settings::fetchSettings();

?>

<div class="col-md-4">
    <div class="position-sticky" style="top: 2rem;">

        <?php if ($related_articles): ?>
            <div class="mb-5">
                <h4 class="fst-italic border-bottom border-danger border-3 text-center my-2">Related Articles</h4>

                <div class="col shadow rounded bg-light p-3">
                    <?php foreach ($related_articles as $article): ?>
                        <div class="border-top border-muted border-3 py-2">
                            <a href="<?= Config::get('domain') ?>news/read?slug=<?= $article->slug ?>"
                                class="h6 text-black fw-bold">
                                <span class="bi bi-arrow-right me-2 text-danger"></span>
                                <?= $article->title ?>
                            </a>
                            <div class="text-muted small">By
                                <?= $article->author ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

            </div>
        <?php endif; ?>

        <?php if ($articles): ?>
            <div class="mb-3">
                <h4 class="fst-italic border-bottom border-danger border-3 text-center my-2">Recent Articles</h4>

                <div class="col shadow rounded bg-light p-3">
                    <?php foreach ($articles as $art): ?>
                        <div class="border-top border-muted border-3 py-2">
                            <a href="<?= Config::get('domain') ?>news/read?slug=<?= $art->slug ?>"
                                class="h6 text-black fw-bold">
                                <span class="bi bi-arrow-right me-2 text-danger"></span>
                                <?= $art->title ?>
                            </a>
                            <div class="text-muted small">By
                                <?= $art->author ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

            </div>
        <?php endif; ?>


        <div class="p-4 d-flex justify-content-between align-items-center">
            <a href="<?= $settings['facebook'] ?? "#" ?>" class="icon"><i class="bi bi-facebook"></i></a>
            <a href="<?= $settings['twitter'] ?? "#" ?>" class="icon"><i class="bi bi-twitter"></i></a>
            <a href="<?= $settings['instagram'] ?? "#" ?>" class="icon"><i class="bi bi-instagram"></i></a>
            <a href="<?= $settings['youtube'] ?? "#" ?>" class="icon"><i class="bi bi-youtube"></i></a>
        </div>

    </div>
</div>