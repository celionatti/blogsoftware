<?php

use Core\Forms\BootstrapForm;

?>


<?php $this->start('content') ?>
<div class="container bg-white p-2 rounded">
    <h2 class="text-muted text-center border-bottom border-3 border-danger py-2">Articles</h2>

    <div id="featured_posts">
        <form action="" method="post">
            <strong>Featured Post: </strong>
            <span class="title-wrapper">
                <span>This is a sample post title</span>
                <button type="button" class="change-featured-post">Change</button>
            </span>
            <span class="input-wrapper d-none">
                <?= BootstrapForm::inputField('Featured Article', 'title', '', ['class' => 'form-control form-control-sm'], ['class' => 'form-floating my-2'], $errors) ?>
                <button type="submit" class="btn btn-dark">Update</button>
            </span>
        </form>
    </div>

    <div id="table-actions" class="row mt-3">
        <?= BootstrapForm::inputField('', 'search', '', ['class' => 'form-control form-control-sm shadow', 'type' => 'search'], ['class' => 'col my-1'], $errors) ?>

        <div class="col text-end">
            <a href="/admin/articles/trash" class="btn btn-danger btn-sm">
                <i class="bi bi-trash"></i>
                Trash
            </a>
            <a href="/admin/articles/create" class="btn btn-primary btn-sm">
                <i class="bi bi-plus-circle"></i>
                New Article
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
        </table>
        <nav aria-label="Standard pagination example">
            <ul class="pagination">
                <li class="page-item">
                    <a class="page-link" href="#" aria-label="Previous">
                        <span aria-hidden="true">&laquo;</span>
                    </a>
                </li>
                <li class="page-item"><a class="page-link" href="#">1</a></li>
                <li class="page-item"><a class="page-link" href="#">2</a></li>
                <li class="page-item"><a class="page-link" href="#">3</a></li>
                <li class="page-item">
                    <a class="page-link" href="#" aria-label="Next">
                        <span aria-hidden="true">&raquo;</span>
                    </a>
                </li>
            </ul>
        </nav>
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