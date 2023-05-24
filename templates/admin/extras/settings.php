<?php

use Core\Config;
use Core\Support\Pagination;
use Core\Forms\BootstrapForm;

?>


<?php $this->start('content') ?>
<div class="container bg-white p-2 rounded">
    <h2 class="text-muted text-center border-bottom border-3 border-danger py-2">Settings</h2>

    <div id="table-actions" class="row my-2">
        <div class="col text-end">
            <a href="<?= Config::get('domain') ?>admin/settings/create" class="btn btn-info btn-sm">
                <i class="bi bi-plus"></i>
                Create
            </a>
        </div>
    </div>

    <div class="border border-muted border-1 px-2 py-2 table-responsive">
        <?php if ($settings): ?>
            <table class="table table-striped">
                <thead>
                    <th>S/N</th>
                    <th>Name</th>
                    <th>Value</th>
                </thead>
                <tbody>
                    <?php foreach ($settings as $key => $setting): ?>
                        <tr>
                            <td>
                                <?= $key + 1 ?>
                            </td>
                            <td>
                                <?= $setting->name ?>
                                <div class="my-2">
                                    <a href="<?= Config::get('domain') ?>admin/settings/trash?setting-id=<?= $setting->id ?>&setting-name=<?= $setting->name ?>"
                                        class="text-danger">Trash</a>
                                    <span class="divider">|</span>
                                    <a href="<?= Config::get('domain') ?>admin/settings/edit?setting-id=<?= $setting->id ?>&setting-name=<?= $setting->name ?>"
                                        class="text-info">Edit</a>
                                </div>
                            </td>
                            <?php if ($setting->type === "image"): ?>
                                <td>
                                    <img src="<?= get_image($setting->value) ?>" class="img-thumbnail" style="height:150px;" alt="">
                                </td>
                            <?php elseif ($setting->type === "link"): ?>
                                <td>
                                    <a href="<?= $setting->value ?>"><?= $setting->value ?></a>
                                </td>
                            <?php else: ?>
                                <td>
                                    <?= htmlspecialchars_decode($setting->value) ?>
                                </td>
                            <?php endif; ?>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <?= Pagination::bootstrap_prev_next($prevPage, $nextPage) ?>
        <?php else: ?>
            <h4 class="text-center text-danger border-bottom border-danger py-2">No Data Available Yet!</h4>
        <?php endif; ?>
    </div>

</div>
<?php $this->end(); ?>