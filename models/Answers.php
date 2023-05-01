<?php

namespace models;

use Core\Database\DbModel;
use Core\Validations\RequiredValidation;

class Answers extends DbModel
{
    public string $task_slug = "";
    public string $question_id = "";
    public string $answer = "";
    public string $created_at = "";
    public string $updated_at = "";

    public static function tableName(): string
    {
        return 'answers';
    }

    public function beforeSave(): void
    {
        $this->timeStamps();

        $this->runValidation(new RequiredValidation($this, ['field' => 'task_slug', 'msg' => "Task Slug is a required field."]));
    }
}