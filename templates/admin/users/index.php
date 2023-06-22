<?php

use Core\Config;
use Core\Support\Pagination;

$this->setHeader("Users");

?>


<?php $this->start('content') ?>
<div class="container bg-white p-2 rounded">
    <h2 class="text-muted text-center border-bottom border-3 border-danger py-2">Users</h2>

    <div id="table-actions" class="row my-3">

        <div class="col text-end">
            <a href="<?= Config::get('domain') ?>admin/users/trash" class="btn btn-danger btn-sm">
                <i class="bi bi-trash"></i>
                Trash
            </a>
            <a href="<?= Config::get('domain') ?>admin/users/create" class="btn btn-primary btn-sm">
                <i class="bi bi-plus-circle"></i>
                New User
            </a>
        </div>
    </div>

    <div class="border border-muted border-1 px-2 table-responsive">
        <?php if ($users): ?>
            <table class="table table-primary">
                <thead>
                    <th>S/N</th>
                    <th>Image</th>
                    <th>Surname</th>
                    <th>First Name</th>
                    <th>E-mail</th>
                    <th>Access Role</th>
                </thead>
                <tbody>
                    <?php foreach ($users as $key => $user): ?>
                        <tr>
                            <td>
                                <?= $key + 1 ?>
                            </td>
                            <td><img src="<?= get_image($user->avatar) ?? '' ?>" alt="" class="d-block"
                                    style="height:50px;width:60px;object-fit:cover;border-radius: 10px;cursor: pointer;"></td>
                            <td class="text-capitalize">
                                <?= $user->surname ?>
                            </td>
                            <td class="text-capitalize">
                                <?= $user->name ?>
                            </td>
                            <td>
                                <a href="" target="_blank" class="text-dark text-decoration-none">
                                    <?= $user->email ?>
                                </a>
                                <div class="my-2">
                                    <a href="<?= Config::get('domain') ?>admin/users/delete?uid=<?= $user->uid ?>"
                                        class="btn btn-danger btn-sm">Delete</a>
                                    <span class="divider">|</span>
                                    <a href="<?= Config::get('domain') ?>admin/users/edit?uid=<?= $user->uid ?>"
                                        class="btn btn-info btn-sm">Edit</a>
                                </div>
                            </td>
                            <td class="text-uppercase">
                                <?= $user->acl ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <?= Pagination::bootstrap_prev_next($prevPage, $nextPage) ?>
        <?php else: ?>
            <h4 class="text-center text-muted border-bottom border-3 border-danger p-3">No Data Available at the moment!
            </h4>
        <?php endif; ?>
    </div>

</div>
<?php $this->end(); ?>

<?php $this->start('script') ?>

<script>

</script>

<?php $this->end(); ?>