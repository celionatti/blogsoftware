<?php

use Core\Config;
use Core\Support\Pagination;
use Core\Forms\BootstrapForm;
use Core\Support\Helpers\TimeFormat;

?>


<?php $this->start('content') ?>
<div class="container bg-white p-2 rounded">
    <h2 class="text-muted text-center border-bottom border-3 border-danger py-2">Credits</h2>

    <div id="table-actions" class="row my-3">

        <div class="col text-end">
            <a href="<?= Config::get('domain') ?>admin/wallets" class="btn btn-primary btn-sm">
                <i class="bi bi-wallet"></i>
                Wallets
            </a>
        </div>
    </div>

    <div class="border border-muted border-1 px-2 table-responsive">
        
    </div>

</div>
<?php $this->end(); ?>