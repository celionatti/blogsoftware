<?php

use Core\Config;

?>


<?php $this->start('content') ?>
<div class="container py-5 d-flex flex-column align-items-center justify-content-center shadow">
    <div class="py-5">
        <h5 class="text-danger text-uppercase text-center border-bottom border-danger border-3">Internal Server Error</h5>
        <img src="<?= get_image("assets/img/error-1.jpg") ?>" class="img-thumbnail" style="height:460px;" />
    </div>
</div>
<?php $this->end(); ?>
