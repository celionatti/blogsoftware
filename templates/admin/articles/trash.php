<?php

use Core\Forms\BootstrapForm;

$this->setHeader("Trashed Articles");

?>


<?php $this->start('content') ?>
<div class="container bg-white p-2 rounded">
    <h2 class="text-muted text-center border-bottom border-3 border-danger py-2">Trashed Articles</h2>

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