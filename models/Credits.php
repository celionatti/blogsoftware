<?php

namespace models;

use Core\Database\DbModel;
use Core\Support\Helpers\Token;
use Core\Validations\RequiredValidation;

class Credits extends DbModel
{
    public string $wallet_id = "";
    public string $user_id = "";
    public string $type = "";
    public string $status = "";
    public string $created_at = "";
    public string $updated_at = "";

    public static function tableName(): string
    {
        return 'credits';
    }

    public function beforeSave(): void
    {
        $this->timeStamps();

        $this->runValidation(new RequiredValidation($this, ['field' => 'type', 'msg' => "Wallet Type is a required field."]));

        if ($this->isNew()) {
            $this->wallet_id = Token::TransactID(15, "CN-WAL-");
        } else {
            $this->_skipUpdate = ['wallet_id'];
        }
    }
}