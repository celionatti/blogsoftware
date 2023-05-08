<?php

use Core\Support\Pagination;

?>

<?php $this->start('content'); ?>
<div class="bg-white" id="board">
    <div class="card text-black">
        <div class="card-header">
            <div class="d-flex justify-content-between">
                <h6 class="text-start"><span>Question No:</span> 4 of 5</h6>
                <h6 class="text-end"><span>Time:</span> <span id="counter">00:00</span>
                </h6>
            </div>
        </div>
        <div class="card-body text-start">
            <form action="" method="post">
                <?php foreach($questions as $question): ?>
                <h4><?= $question->question ?></h4>
                <?php if(! empty($question->image) && file_exists($question->image)): ?>
                <div class="text-center my-3 mx-auto" id="image">
                    <img src="<?= get_image($question->image) ?>" class=""
                        style="height:200px;width:400px;object-fit:cover;">
                </div>
                <?php endif; ?>
                <?php if (!empty($question->comment)) : ?>
                <div class="my-2 container border-bottom border-top py-2 border-1 border-danger">
                    <h6 class="text-start text-danger m-0">Hint: <span
                            class="text-muted"><?= $question->comment ?></span></h6>
                </div>
                <?php endif; ?>

                <?php if($question->type === "objective"): ?>
                <div>
                    <div class="form-check my-3">
                        <input type="radio" class="form-check-input border border-primary"
                            style="transform: scale(1.5);cursor: pointer;" name="answer"
                            value="<?= $question->opt_one ?>">
                        <span class="text-normal"><?= $question->opt_one ?></span>
                    </div>
                    <div class="form-check my-3">
                        <input type="radio" class="form-check-input border border-info"
                            style="transform: scale(1.5);cursor: pointer;" name="answer"
                            value="<?= $question->opt_two ?>">
                        <span class="text-normal"><?= $question->opt_two ?></span>
                    </div>
                    <div class="form-check my-3">
                        <input type="radio" class="form-check-input border border-warning"
                            style="transform: scale(1.5);cursor: pointer;" name="answer"
                            value="<?= $question->opt_three ?>">
                        <span class="text-normal"><?= $question->opt_three ?>
                        </span>
                    </div>
                    <div class="form-check my-3">
                        <input type="radio" class="form-check-input border border-dark"
                            style="transform: scale(1.5);cursor: pointer;" name="answer"
                            value="<?= $question->opt_four ?>">
                        <span class="text-normal"><?= $question->opt_four ?>
                        </span>
                    </div>
                </div>
                <?php endif; ?>

                <?php endforeach; ?>
                <div class="d-flex justify-content-between">
                    <?= Pagination::bootstrap_quiz_next($nextPage); ?>
                    <button type="submit" class="btn btn-sm btn-danger w-25">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php $this->end(); ?>

<?php $this->start("script"); ?>
<script>
    remaining_time = <?= $time ?>
// Set the time for the exam in seconds
var countDownSeconds = remaining_time;

// Update the countdown every second
var x = setInterval(function() {

    // Decrement the countdown timer
    countDownSeconds--;

    // Calculate minutes and seconds
    var minutes = Math.floor(countDownSeconds / 60);
    var seconds = countDownSeconds % 60;

    // Display the countdown timer
    document.getElementById("counter").innerHTML = minutes + "m " + seconds + "s ";

    // If the countdown is over, display "Exam Over"
    if (countDownSeconds < 1) {
        clearInterval(x);
        document.getElementById("counter").innerHTML = "00:00";
    }
}, 1000)
</script>
<?php $this->end(); ?>