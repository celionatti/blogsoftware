<?php

use Core\Forms\BootstrapForm;

?>


<?php $this->start('content') ?>
<div class="container bg-white p-2 rounded">
    <h2 class="text-muted text-center border-bottom border-3 border-danger py-2">Collections</h2>

    <div id="table-actions" class="row mt-3">
        <?= BootstrapForm::inputField('', 'search', '', ['class' => 'form-control form-control-sm shadow', 'type' => 'search'], ['class' => 'col my-1'], $errors) ?>

        <div class="col text-end">
            <a href="/admin/collections/trash" class="btn btn-danger btn-sm">
                <i class="bi bi-trash"></i>
                Trash
            </a>
            <a href="/admin/collections/create" class="btn btn-primary btn-sm">
                <i class="bi bi-plus-circle"></i>
                New User
            </a>
        </div>
    </div>

    <div class="border border-muted border-1 px-2 table-responsive">
        <table class="table table-striped">
            <thead>
                <th>S/N</th>
                <th>Collection Title</th>
                <th># of Posts</th>
            </thead>
            <tbody>
                <tr>
                    <td>1</td>
                    <td>Celio Natti</td>
                    <td>Africa</td>
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