<?php

namespace models;

use Core\Database\DbModel;
use Core\Support\Helpers\Token;
use Core\Validations\RequiredValidation;
use Core\Validations\UniqueValidation;

class Topics extends DbModel
{
    const STATUS_ACTIVE = "active";
    const STATUS_DISABLED = "disabled";

    public string $slug = "";
    public string $topic = "";
    public string $status = self::STATUS_DISABLED;
    public string $created_at = "";
    public string $updated_at = "";

    public static function tableName(): string
    {
        return 'topics';
    }

    public function beforeSave(): void
    {
        $this->timeStamps();

        $this->runValidation(new RequiredValidation($this, ['field' => 'topic', 'msg' => "Topic Title is a required field."]));
        $this->runValidation(new UniqueValidation($this, ['field' => ['topic'], 'msg' => 'Topic already exists.']));

        if ($this->isNew()) {
            $this->slug = Token::generateOTP(60);
        } else {
            $this->_skipUpdate = ['slug'];
        }
    }

    public static function navTopics()
    {
        $params = [
            'conditions' => "status = 'active'",
            'group' => 'id',
            'order' => 'topic DESC'
        ];
        return self::find($params);
    }

    public static function articles_topic_count($slug)
    {
        $params = [
            'columns' => "articles.*, topics.slug",
            'conditions' => "topics.slug = :slug",
            'bind' => ['slug' => $slug],
            'joins' => [
                ['articles', 'topics.slug = articles.topic', 'articles', 'LEFT']
            ],
        ];
        return self::findTotal($params);
    }
}