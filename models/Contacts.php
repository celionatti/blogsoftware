<?php

namespace models;

use Core\Database\DbModel;
use Core\Support\Helpers\Token;
use Core\Validations\RequiredValidation;

class Contacts extends DbModel
{
    public string $slug = "";
    public string $name = "";
    public string $email = "";
    public string $subject = "";
    public string $message = "";
    public string $created_at = "";
    public string $updated_at = "";

    public static function tableName(): string
    {
        return 'contacts';
    }

    public function beforeSave(): void
    {
        $this->timeStamps();

        $this->runValidation(new RequiredValidation($this, ['field' => 'name', 'msg' => "Full Name is a required field."]));

        if ($this->isNew()) {
            $this->slug = Token::generateOTP(60);
        } else {
            $this->_skipUpdate = ['slug'];
        }
    }
}