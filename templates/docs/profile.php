<?php


use Core\Config;
use models\Ratings;


?>

<?php $this->start('header') ?>
<style>
    .author-bg {
        background-image: url('/assets/img/bg-2.jpg');
        background-position: center;
        background-repeat: no-repeat, repeat;
        background-size: cover;
        background-blend-mode: lighten;
    }
</style>
<?php $this->end(); ?>

<?php $this->start('content') ?>
<div class="p-2 mb-4 bg-light rounded-3">
    <div class="container-fluid d-flex justify-content-center align-items-center author-bg rounded">
        <img src="<?= get_image($user->avatar) ?>" class="rounded-5 m-2" style="object-fit: cover; height: 350px; width:350px;" />
    </div>
    <div class="pt-3 pb-5 d-flex flex-column justify-content-center align-items-center">
        <h1 class="display-5 fw-bold text-capitalize">
            <?= $user->surname . " " . $user->name ?>
        </h1>
        <h3 class="text-muted text-center px-4">
            <?= htmlspecialchars_decode($user->bio) ?>
        </h3>
    </div>

    <!-- Details Section -->
    <div class="row m-3">
        <div class="col shadow p-3">
            <div class="share-title fw-bold border-bottom border-danger border-3">Others Info</div>
            <table class="table table-responsive table-striped">
                <?php if ($user->acl !== "user") : ?>
                    <?php if ($rating) : ?>
                        <tr>
                            <th>Rating:</th>
                            <td class="text-end">
                                <?php Ratings::RatingStars($rating) ?>
                            </td>
                        </tr>
                    <?php endif; ?>
                    <tr>
                        <th># of Articles:</th>
                        <td class="text-end">
                            <?= $article_count ?>
                        </td>
                    </tr>
                <?php endif; ?>
                <tr>
                    <th>Credits:</th>
                    <td class="text-end">
                        100 <span class="fw-bold text-primary">CNT</span>
                    </td>
                </tr>
                <tr>
                    <th>Role:</th>
                    <td class="text-end text-capitalize fw-bold">
                        <?= $user->acl ?>
                    </td>
                </tr>
                <tr>
                    <td colspan="2" class="text-end text-capitalize fw-bold"><a href="#" class="btn btn-sm btn-dark">Request withdrawal</a></td>
                </tr>
            </table>
        </div>
        <div class="col shadow p-3">
            <div class="share-title fw-bold border-bottom border-dark border-3">Personal Info</div>
            <table class="table table-responsive table-striped">
                <tr>
                    <th>Surname:</th>
                    <td class="text-end">
                        <?= $user->surname ?>
                    </td>
                </tr>
                <tr>
                    <th>Name:</th>
                    <td class="text-end">
                        <?= $user->name ?>
                    </td>
                </tr>
                <tr>
                    <th>Username:</th>
                    <td class="text-end">
                        <?= $user->username ?>
                    </td>
                </tr>
                <tr>
                    <th>E-Mail:</th>
                    <td class="text-end">
                        <?= $user->email ?>
                    </td>
                </tr>
                <tr>
                    <th>Phone:</th>
                    <td class="text-end">
                        <?= $user->phone ?>
                    </td>
                </tr>
                <tr>
                    <th>Social:</th>
                    <td class="bi bi-twitter px-2 text-end">
                        <?= $user->social ?>
                    </td>
                </tr>
                <tr>
                    <th>Token (Pin):</th>
                    <td class="px-2 text-end d-flex justify-content-between align-items-center">
                        <p class="text-center bg-white mx-auto w-75 py-2 px-3">****</p>
                        <span class="bi bi-lock-fill" role="button" onclick="revealToken()"></span>
                    </td>
                </tr>
                <tr>
                    <td class="text-start text-capitalize fw-bold"><a href="<?= Config::get("domain") ?>account/change-password" class="btn btn-sm btn-dark">Change Password</a></td>
                    <td colspan="2" class="text-end text-capitalize fw-bold"><a href="<?= Config::get("domain") ?>account/edit" class="btn btn-sm btn-dark">Update</a></td>
                </tr>
            </table>
        </div>
    </div>
</div>
<?php $this->end(); ?>


<?php $this->start("script"); ?>
<script>
    function revealToken() {
        alert("Reveal Token");
    }
</script>
<?php $this->end(); ?>