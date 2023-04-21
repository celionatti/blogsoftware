<?php

namespace models;

use Core\Database\DbModel;
use Core\Support\Helpers\Token;
use Core\Validations\RequiredValidation;

class Subscribers extends DbModel
{
    const STATUS_ACTIVE = "active";
    const STATUS_DISABLED = "disabled";

    public string $slug = "";
    public string $email = "";
    public string $status = self::STATUS_ACTIVE;
    public string $created_at = "";
    public string $updated_at = "";

    public static function tableName(): string
    {
        return 'subscribers';
    }

    public function beforeSave(): void
    {
        $this->timeStamps();

        $this->runValidation(new RequiredValidation($this, ['field' => 'email', 'msg' => "Email is a required field."]));

        if ($this->isNew()) {
            $this->slug = Token::generateOTP(60);
        } else {
            $this->_skipUpdate = ['slug'];
        }
    }
}