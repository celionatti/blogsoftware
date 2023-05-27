<?php


use Core\Config;
use models\Settings;


$settings = Settings::fetchSettings();

?>

<?php $this->start("header") ?>
<style>
.watermark {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%) rotate(-45deg);
    color: rgba(0, 0, 0, 0.3);
    /* Adjust the color and opacity as needed */
    font-size: 44px;
    font-weight: bold;
    text-transform: uppercase;
}
</style>

<?php $this->end(); ?>

<?php $this->start("content") ?>
<main class="container my-3">
    <!-- Back To Home -->
    <a href="<?= Config::get("domain") ?>" class="back-home btn btn-primary text-white"><i class="bi bi-house-door"></i>
        Back To Home</a>
    <h1 class="watermark">
        <?= htmlspecialchars_decode($settings['title'] ?? $this->getTitle()) ?>
        <small>Terms & Conditions</small>
    </h1>

    <div class="text-2xl mt-4 shadow p-3">
        <?= htmlspecialchars_decode($settings['terms'] ?? "") ?>
    </div>
</main>
<?php $this->end(); ?>