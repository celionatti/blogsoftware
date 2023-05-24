<?php

namespace models;

use Core\Database\DbModel;
use Core\Support\Helpers\Token;
use Core\Validations\RequiredValidation;
use Core\Validations\UniqueValidation;

class Settings extends DbModel
{
    const STATUS_ACTIVE = "active";
    const STATUS_DISABLED = "disabled";

    public string $name = "";
    public string $value = "";
    public string $type = "";
    public string $status = self::STATUS_DISABLED;
    public string $created_at = "";
    public string $updated_at = "";

    public static function tableName(): string
    {
        return 'settings';
    }

    public function beforeSave(): void
    {
        $this->timeStamps();

        $this->runValidation(new RequiredValidation($this, ['field' => 'name', 'msg' => "Topic Title is a required field."]));
        $this->runValidation(new UniqueValidation($this, ['field' => ['name'], 'msg' => 'Setting Name already exists.']));
    }

    public static function fetchSettings()
    {
        $params = [
            'conditions' => "status = :status",
            'bind' => ['status' => 'active']
        ];

        $data['settings'] = Settings::find($params);

        $data['data'] = [];

        if ($data['settings']) {
            foreach ($data['settings'] as $row) {
                $data['data'][$row->name] = $row->value;
            }
        }
        return $data['data'];
    }
}