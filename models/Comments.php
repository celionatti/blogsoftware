<?php

namespace models;

use Core\Database\DbModel;
use Core\Support\Helpers\Token;
use Core\Validations\RequiredValidation;
use Core\Validations\UniqueValidation;

class Comments extends DbModel
{
    const STATUS_ACTIVE = "active";
    const STATUS_DISABLED = "disabled";

    public $id;
    public string $article_slug = "";
    public string $user = "anonymous";
    public string $message = "";
    public string $status = self::STATUS_ACTIVE;
    public string $created_at = "";
    public string $updated_at = "";

    public static function tableName(): string
    {
        return 'comments';
    }

    public function beforeSave(): void
    {
        $this->timeStamps();

        $this->runValidation(new RequiredValidation($this, ['field' => 'message', 'msg' => "Message is a required field."]));
    }
}