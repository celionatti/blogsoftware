<?php

use Core\Config;

?>

<?php $this->start('content'); ?>
<div class="bg-white" id="board">
    <div class="card text-black">
        <div class="card-header">
            <span>::</span>
            <span>Task Registration</span>
            <span>::</span>
        </div>
        <div class="card-body text-start">
            <table class="table table-responsive">
                <tr>
                    <th class="text-start">Name: </th>
                    <td class="text-end text-capitalize">Amisu</td>
                </tr>
                <tr>
                    <th class="text-start">E-mail: </th>
                    <td class="text-end text-capitalize">15</td>
                </tr>
                <tr>
                    <th class="text-start">Task: </th>
                    <td class="text-end text-capitalize">Amisu Quiz</td>
                </tr>
            </table>
            <form action="<?= Config::get('domain') ?>task/registration" method="post" class="d-inline">
                
            </form>
            <a href="" class="btn btn-sm btn-dark w-100">
                <i class="bi bi-box-arrow-right"></i>
                Register
            </a>
        </div>
    </div>
</div>
<?php $this->end(); ?>
