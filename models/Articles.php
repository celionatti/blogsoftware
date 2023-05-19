<?php

namespace models;

use Core\Response;
use Core\Database\DbModel;
use Core\Support\Helpers\Token;
use Core\Support\Helpers\Bcrypt;
use Core\Validations\MinValidation;
use Core\Validations\EmailValidation;
use Core\Validations\UniqueValidation;
use Core\Validations\MatchesValidation;
use Core\Validations\RequiredValidation;

class Articles extends DbModel
{
    const STATUS_PUBLISHED = "published";
    const STATUS_DRAFT = "draft";
    const FEATURED_ACTIVE = 1;
    const FEATURED_DISABLED = 0;

    public string $slug = "";
    public string $title = "";
    public string $content = "";
    public ?string $topic = "";
    public string $thumbnail = "";

    public ?string $thumbnail_caption = null;
    public string $sub_image = "";

    public ?string $sub_image_caption = null;
    public string $user_id = "";
    public string $author = "CNB, ";
    public int $featured = self::FEATURED_DISABLED;
    public ?string $point_one = "";
    public ?string $point_two = "";
    public string $meta_title = "";
    public string $meta_description = "";
    public string $meta_keywords = "";
    public string $status = self::STATUS_DRAFT;
    public string $created_at = "";
    public string $updated_at = "";

    public static function tableName(): string
    {
        return 'articles';
    }

    public function beforeSave(): void
    {
        $this->timeStamps();

        $this->runValidation(new RequiredValidation($this, ['field' => 'title', 'msg' => "Article Title is a required field."]));
        $this->runValidation(new RequiredValidation($this, ['field' => 'topic', 'msg' => "Topic is a required field."]));
        $this->runValidation(new RequiredValidation($this, ['field' => 'author', 'msg' => "Author is a required field."]));
        $this->runValidation(new RequiredValidation($this, ['field' => 'point_one', 'msg' => "Key Point is a required field."]));
        $this->runValidation(new RequiredValidation($this, ['field' => 'meta_title', 'msg' => "Meta Title is a required field."]));
        $this->runValidation(new RequiredValidation($this, ['field' => 'meta_description', 'msg' => "Meta Description is a required field."]));
        $this->runValidation(new RequiredValidation($this, ['field' => 'meta_keywords', 'msg' => "Meta Keywords is a required field."]));
        $this->runValidation(new UniqueValidation($this, ['field' => ['slug', 'title', 'topic'], 'msg' => 'An Article with that title already exists.']));

        if ($this->isNew()) {
            $this->slug = Token::generateOTP(80);
        } else {
            $this->_skipUpdate = ['slug'];
        }
    }

    public static function fetch_articles()
    {       
        $params = [
            'conditions' => "status = :status",
            'bind' => ['status' => 'published'],
            'order' => 'created_at DESC',
            'limit' => '5'
        ];

        $articles = Articles::find($params);

        return $articles;
    }

}