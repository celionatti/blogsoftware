<?php


?>

<?php $this->start('content'); ?>
<div class="bg-white" id="board">
    <div class="card text-black">
        <div class="card-header">
            <span>::</span>
            <span>General Instruction</span>
            <span>::</span>
        </div>
        <div class="card-body text-start">
            <ol>
                <li>You are allowed to start the test whenever you want to. The timer would start only when you start the test. However remember that admin has full rights to disable the test at any time. So it is recommended to start the test at the prescribed time.</li>
                <li>To start the test, click on 'Start'.</li>
                <li>Use the navigation buttons to navigate through different questions.</li>
            </ol>
            <table class="table table-responsive">
                <tr>
                    <th class="text-start">Quiz Title: </th>
                    <td class="text-end text-capitalize">1</td>
                </tr>
                <tr>
                    <th class="text-start">Time: </th>
                    <td class="text-end text-capitalize">15</td>
                </tr>
                <tr>
                    <th class="text-start">Instruction: </th>
                    <td class="text-end text-capitalize">Use the navigation buttons to navigate through different questions.</td>
                </tr>
            </table>
            <button class="btn btn-sm btn-success w-100">
                <i class="bi bi-box-arrow-up-right"></i>
                Start
            </button>
        </div>
    </div>
</div>
<?php $this->end(); ?>