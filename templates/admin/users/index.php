<?php

use Core\Forms\BootstrapForm;

?>


<?php $this->start('content') ?>
<div class="container bg-white p-2 rounded">
    <h2 class="text-muted text-center border-bottom border-3 border-danger py-2">Users</h2>

    <div id="table-actions" class="row mt-3">
        <?= BootstrapForm::inputField('', 'search', '', ['class' => 'form-control form-control-sm shadow', 'type' => 'search'], ['class' => 'col my-1'], $errors) ?>

        <div class="col text-end">
            <a href="/admin/users/trash" class="btn btn-danger btn-sm">
                <i class="bi bi-trash"></i>
                Trash
            </a>
            <a href="/admin/users/create" class="btn btn-primary btn-sm">
                <i class="bi bi-plus-circle"></i>
                New User
            </a>
        </div>
    </div>

    <div class="border border-muted border-1 px-2 table-responsive">
        <table class="table table-striped">
            <thead>
                <th>S/N</th>
                <th>Author</th>
                <th>Title</th>
                <th>Topic</th>
                <th>Views</th>
                <th>Published</th>
            </thead>
            <tbody>
                <tr>
                    <td>1</td>
                    <td>Celio Natti</td>
                    <td>
                        <a href="" target="_blank" class="text-dark text-decoration-none">Article title One</a>
                        <div class="my-2">
                            <a href="" class="text-danger">Trash</a>
                            <span class="divider">|</span>
                            <a href="" class="text-info">Edit</a>
                            <span class="divider">|</span>
                            <a href="" class="text-primary">Related Article</a>
                        </div>
                    </td>
                    <td>Africa</td>
                    <td>1000</td>
                    <td>Published</td>
                </tr>
            </tbody>
            <tfoot>
                <nav aria-label="Pagination example">
                    <ul class="pagination pagination-sm">
                        <li class="page-item"><a class="page-link" href="#">1</a></li>
                        <li class="page-item active" aria-current="page">
                            <a class="page-link" href="#">2</a>
                        </li>
                        <li class="page-item"><a class="page-link" href="#">3</a></li>
                    </ul>
                </nav>
            </tfoot>
        </table>
    </div>

</div>
<?php $this->end(); ?>

<?php $this->start('script') ?>

<script>
    const changeFeaturedPostBtn = document.querySelector('.change-featured-post');
    const inputWrapper = document.querySelector('.input-wrapper');
    const titleWrapper = document.querySelector('.title-wrapper');

    changeFeaturedPostBtn.addEventListener('click', function () {
        inputWrapper.classList.toggle('d-none');
        titleWrapper.classList.toggle('d-none');
    });
</script>

<?php $this->end(); ?>