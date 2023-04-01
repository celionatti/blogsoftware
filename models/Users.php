<?php

namespace models;

use Core\Database\DbModel;
use Core\Support\Helpers\Bcrypt;
use Core\Support\Helpers\Token;
use Core\Validations\EmailValidation;
use Core\Validations\MatchesValidation;
use Core\Validations\MinValidation;
use Core\Validations\RequiredValidation;
use Core\Validations\UniqueValidation;

class Users extends DbModel
{
    const BLOCKED = 0;
    const UNBLOCKED = 1;
    const USER_ACCESS = 'user';
    const ADMIN_ACCESS = 'admin';
    const MANAGER_ACCESS = 'manager';
    const AUTHOR_ACCESS = 'author';

    public string $uid = "";
    public string $surname = "";
    public string $username = "";
    public string $name = "";
    public string $email = "";
    public string $avatar = "";
    public string $phone = "";
    public string $acl = self::USER_ACCESS;
    public string $password = "";
    public string $confirm_password = "";
    public string $token = "";
    public string $bio = "";
    public string $social = "";
    public int $blocked = self::BLOCKED;
    public string $created_at = "";
    public string $updated_at = "";

    public static function tableName(): string
    {
        return 'users';
    }

    public function beforeSave(): void
    {
        $this->timeStamps();

        $this->runValidation(new RequiredValidation($this, ['field' => 'surname', 'msg' => "Surname is a required field."]));
        $this->runValidation(new RequiredValidation($this, ['field' => 'name', 'msg' => "First Name is a required field."]));
        $this->runValidation(new RequiredValidation($this, ['field' => 'username', 'msg' => "Username is a required field."]));
        $this->runValidation(new RequiredValidation($this, ['field' => 'email', 'msg' => "Email is a required field."]));
        $this->runValidation(new EmailValidation($this, ['field' => 'email', 'msg' => 'You must provide a valid email.']));
        $this->runValidation(new UniqueValidation($this, ['field' => ['email', 'surname', 'username'], 'msg' => 'A user with that email address already exists.']));

        $this->runValidation(new RequiredValidation($this, ['field' => 'acl', 'msg' => "Access Level is a required field."]));

        $this->runValidation(new RequiredValidation($this, ['field' => 'phone', 'msg' => "Phone Number is a required field."]));
        $this->runValidation(new RequiredValidation($this, ['field' => 'social', 'msg' => "Social Link is a required field."]));

        if ($this->isNew()) {
            $this->runValidation(new RequiredValidation($this, ['field' => 'password', 'msg' => "Password is a required field."]));
            $this->runValidation(new RequiredValidation($this, ['field' => 'confirm_password', 'msg' => "Confirm Password is a required field."]));
            $this->runValidation(new MatchesValidation($this, ['field' => 'confirm_password', 'rule' => $this->password, 'msg' => "Your passwords do not match."]));
            $this->runValidation(new MinValidation($this, ['field' => 'password', 'rule' => 8, 'msg' => "Password must be at least 8 characters."]));

            $this->uid = Token::generateOTP(60);
            $this->password = Bcrypt::hashPassword($this->password);
        }
    }

    public function validateEditUser()
    {
        $this->runValidation(new RequiredValidation($this, ['field' => 'password', 'msg' => "Password is a required field."]));
        $this->runValidation(new RequiredValidation($this, ['field' => 'confirm_password', 'msg' => "Confirm Password is a required field."]));
        $this->runValidation(new MatchesValidation($this, ['field' => 'confirm_password', 'rule' => $this->password, 'msg' => "Your passwords do not match."]));
        $this->runValidation(new MinValidation($this, ['field' => 'password', 'rule' => 8, 'msg' => "Password must be at least 8 characters."]));
        $this->password = Bcrypt::hashPassword($this->password);
    }
}