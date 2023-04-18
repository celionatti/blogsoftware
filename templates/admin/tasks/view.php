<?php

use Core\Config;
use Core\Support\Pagination;
use Core\Forms\BootstrapForm;
use Core\Support\Helpers\TimeFormat;

?>


<?php $this->start('content') ?>
<div class="container bg-white p-2 rounded">
    <h2 class="text-muted text-center border-bottom border-3 border-danger py-2">Task Details</h2>

    <h5 class="text-muted text-center border-bottom border-3 border-danger py-2">Task: Details</h5>

    <div id="table-actions" class="row mt-3">
        <div class="col text-start">
            <a href="/admin/tasks/archive" class="btn btn-info btn-sm">
                <i class="bi bi-archive"></i>
                Archive Task
            </a>
        </div>

        <div class="col text-end">
            <a href="/admin/tasks/archive" class="btn btn-warning btn-sm">
                <i class="bi bi-archive"></i>
                Archive Task
            </a>
            <a href="/admin/tasks/create" class="btn btn-primary btn-sm">
                <i class="bi bi-plus-circle"></i>
                New Task
            </a>
        </div>
    </div>


</div>
<?php $this->end(); ?>