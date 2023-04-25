<?php

namespace models;

use Core\Database\DbModel;
use Core\Support\Helpers\Token;
use Core\Validations\RequiredValidation;
use Core\Validations\UniqueValidation;

class TaskRegistration extends DbModel
{
    const STATUS_ACTIVE = "active";
    const STATUS_BLOCKED = "blocked";

    public string $task_slug = "";
    public string $user_id = "";
    public string $task_id = "";
    public string $status = self::STATUS_ACTIVE;
    public string $created_at = "";
    public string $updated_at = "";

    public static function tableName(): string
    {
        return 'task_registration';
    }

    public function beforeSave(): void
    {
        $this->timeStamps();

        $this->runValidation(new UniqueValidation($this, ['field' => 'task_slug', 'msg' => "Task Slug is a required field."]));

        if ($this->isNew()) {
            $this->task_slug = Token::TransactID(6, "TT");
        } else {
            $this->_skipUpdate = ['task_slug'];
        }
    }
}