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

class BoardPosts extends DbModel
{
    const STATUS_ACTIVE = "active";
    const STATUS_DISABLED = "disabled";

    public string $slug = "";
    public string $title = "";
    public string $content = "";
    public string $thumbnail = "";

    public ?string $thumbnail_caption = null;
    public string $user_id = "";
    public string $author = "CNB, ";
    public string $meta_title = "";
    public string $meta_description = "";
    public string $meta_keywords = "";
    public string $status = self::STATUS_DISABLED;
    public string $created_at = "";
    public string $updated_at = "";

    public static function tableName(): string
    {
        return 'board_posts';
    }

    public function beforeSave(): void
    {
        $this->timeStamps();

        $this->runValidation(new RequiredValidation($this, ['field' => 'title', 'msg' => "Board Post Title is a required field."]));
        $this->runValidation(new RequiredValidation($this, ['field' => 'author', 'msg' => "Author is a required field."]));
        $this->runValidation(new RequiredValidation($this, ['field' => 'content', 'msg' => "Content is a required field."]));
        $this->runValidation(new RequiredValidation($this, ['field' => 'meta_title', 'msg' => "Meta Title is a required field."]));
        $this->runValidation(new RequiredValidation($this, ['field' => 'meta_description', 'msg' => "Meta Description is a required field."]));
        $this->runValidation(new RequiredValidation($this, ['field' => 'meta_keywords', 'msg' => "Meta Keywords is a required field."]));
        $this->runValidation(new UniqueValidation($this, ['field' => ['slug', 'title'], 'msg' => 'A Board Post with that title already exists.']));

        if ($this->isNew()) {
            $this->slug = Token::generateOTP(80);
        } else {
            $this->_skipUpdate = ['slug'];
        }
    }

    public static function boardPost()
    {
        $params = [
            'conditions' => "status = 'active'",
        ];

        return self::findFirst($params);
    }
}