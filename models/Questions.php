<?php

namespace models;

use Core\Database\DbModel;
use Core\Support\Helpers\Token;
use Core\Validations\RequiredValidation;
use Core\Validations\UniqueValidation;

class Questions extends DbModel
{
    public string $slug = "";
    public string $task_slug = "";
    public string $question = "";
    public string $image = "";
    public string $type = "";

    public string $correct_answer = "";
    public string $opt_one = "";
    public string $opt_two = "";
    public string $opt_three = "";
    public string $opt_four = "";

    public string $user = "";
    public string $comment = "";
    public string $created_at = "";
    public string $updated_at = "";

    public static function tableName(): string
    {
        return 'questions';
    }

    public function beforeSave(): void
    {
        $this->timeStamps();

        $this->runValidation(new RequiredValidation($this, ['field' => 'question', 'msg' => "Question is a required field."]));
        $this->runValidation(new RequiredValidation($this, ['field' => 'correct_answer', 'msg' => "Correct Answer is a required field."]));
        $this->runValidation(new UniqueValidation($this, ['field' => ['slug'], 'msg' => 'Question already exists.']));

        if ($this->isNew()) {
            $this->slug = Token::generateOTP(80);
        } else {
            $this->_skipUpdate = ['slug'];
        }
    }
}