<?php

namespace models;

use Core\Database\DbModel;
use Core\Validations\RequiredValidation;

class Ratings extends DbModel
{
    public string $name = "";
    public string $rating = "";
    public string $review = "";
    public string $created_at = "";
    public string $updated_at = "";

    public static function tableName(): string
    {
        return 'ratings';
    }

    public function beforeSave(): void
    {
        $this->timeStamps();

        $this->runValidation(new RequiredValidation($this, ['field' => 'name', 'msg' => "Name is a required field."]));
        $this->runValidation(new RequiredValidation($this, ['field' => 'rating', 'msg' => "Rating is a required field."]));
    }

    public static function RatingStars($rating)
    {
        if ($rating <= 63) {
            echo '<span class="text-normal"><i class="bi bi-star-half text-warning"></i></span>';
        } elseif($rating <= 315) {
            echo '
            <span class="text-normal"><i class="bi bi-star-fill text-warning"></i></span>
            <span class="text-normal"><i class="bi bi-star-half text-warning"></i></span>
            ';
        } elseif($rating <= 1575) {
            echo '
            <span class="text-normal"><i class="bi bi-star-fill text-warning"></i></span>
            <span class="text-normal"><i class="bi bi-star-fill text-warning"></i></span>
            <span class="text-normal"><i class="bi bi-star-half text-warning"></i></span>
            ';
        } elseif($rating <= 7875) {
            echo '
            <span class="text-normal"><i class="bi bi-star-fill text-warning"></i></span>
            <span class="text-normal"><i class="bi bi-star-fill text-warning"></i></span>
            <span class="text-normal"><i class="bi bi-star-fill text-warning"></i></span>
            <span class="text-normal"><i class="bi bi-star-half text-warning"></i></span>
            ';
        } elseif($rating <= 39375) {
            echo '
            <span class="text-normal"><i class="bi bi-star-fill text-warning"></i></span>
            <span class="text-normal"><i class="bi bi-star-fill text-warning"></i></span>
            <span class="text-normal"><i class="bi bi-star-fill text-warning"></i></span>
            <span class="text-normal"><i class="bi bi-star-fill text-warning"></i></span>
            <span class="text-normal"><i class="bi bi-star-half text-warning"></i></span>
            ';
        } else {
            echo '<span class="text-normal"><i class="bi bi-star text-warning"></i></span>';
        }
    }
}