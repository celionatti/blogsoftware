<?php

namespace models;

use Core\Database\DbModel;
use Core\Support\Helpers\Token;
use Core\Validations\RequiredValidation;

class Tasks extends DbModel
{
    const TYPE_QUIZ = "quiz";
    const TYPE_CHALLENGE = "challenge";
    const TYPE_COMPETITION = "competition";
    const YES_EDITABLE = "yes";
    const NO_EDITABLE = "no";
    const STATUS_ACTIVE = "active";
    const STATUS_DISABLED = "disabled";

    public string $slug = "";
    public string $type = "";
    public string $title = "";
    public string $thumbnail = "";
    public string $start_time = "";
    public string $end_time = "";
    public string $instruction = "";
    public string $editable = self::YES_EDITABLE;
    public string $status = self::STATUS_DISABLED;
    public string $created_at = "";
    public string $updated_at = "";

    public static function tableName(): string
    {
        return 'tasks';
    }

    public function beforeSave(): void
    {
        $this->timeStamps();

        $this->runValidation(new RequiredValidation($this, ['field' => 'title', 'msg' => "Title is a required field."]));
        $this->runValidation(new RequiredValidation($this, ['field' => 'start_time', 'msg' => "Start Time is a required field."]));
        $this->runValidation(new RequiredValidation($this, ['field' => 'end_time', 'msg' => "End Time is a required field."]));

        if ($this->isNew()) {
            $this->slug = Token::generateOTP(60);
        } else {
            $this->_skipUpdate = ['slug'];
        }
    }
}