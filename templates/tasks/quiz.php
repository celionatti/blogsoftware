<?php


?>

<?php $this->start('content'); ?>
<div class="bg-white" id="board">
    <div class="card text-black">
        <div class="card-header">
            <div class="d-flex justify-content-between">
                <h6 class="text-start"><span>Question No:</span> 4 of 5</h6>
                <h6 class="text-end"><span>Time:</span> <span id="counter">00:00</span></h6>
            </div>
        </div>
        <div class="card-body text-start">
            <form action="" method="post">
                <h4>What type of dance is this?</h4>
                <div class="text-center my-3 mx-auto" id="image">
                    <img src="<?= get_image() ?>" class="" style="height:200px;width:400px;object-fit:cover;">
                </div>
                <div>
                    <div class="form-check my-3">
                        <input type="radio" class="form-check-input border border-primary"
                            style="transform: scale(1.5);cursor: pointer;" name="answer" value="">
                        Answer one
                    </div>
                    <div class="form-check my-3">
                        <input type="radio" class="form-check-input border border-info"
                            style="transform: scale(1.5);cursor: pointer;" name="answer" value="">
                        Answer two
                    </div>
                    <div class="form-check my-3">
                        <input type="radio" class="form-check-input border border-warning"
                            style="transform: scale(1.5);cursor: pointer;" name="answer" value="">
                        Answer three
                    </div>
                    <div class="form-check my-3">
                        <input type="radio" class="form-check-input border border-dark"
                            style="transform: scale(1.5);cursor: pointer;" name="answer" value="">
                        Answer four
                    </div>
                </div>
                <div class="d-flex justify-content-between">
                    <button class="btn btn-sm btn-primary w-75 mx-3" id="next_btn">Next</button>
                    <button class="btn btn-sm btn-danger w-25" id="submit_btn">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php
$time = 15;

$seconds = (($time * 60) - ((time() - $time)));

?>
<?php $this->end(); ?>