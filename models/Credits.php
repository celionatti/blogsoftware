<?php

namespace models;

use Core\Database\DbModel;
use Core\Support\Helpers\Token;
use Core\Validations\RequiredValidation;
use Core\Validations\UniqueValidation;

class Credits extends DbModel
{
    const STATUS_ACTIVE = "active";
    const STATUS_DISABLED = "disabled";

    const PERSONAL_WALLET = "personal";
    const INVESTMENT_WALLET = "investment";
    const BUSINESS_WALLET = "business";

    public string $slug = "";
    public string $wallet_id = "";
    public string $user_id = "";
    public string $type = self::PERSONAL_WALLET;
    public string|float|null $balance = 0;
    public string $status = self::STATUS_ACTIVE;
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
        $this->runValidation(new UniqueValidation($this, ['field' => 'user_id', 'msg' => "Wallet User Already Exists."]));

        if ($this->isNew()) {
            $this->slug = Token::generateOTP(60);
            $this->wallet_id = Token::TransactID(15, "CN-WAL");
        } else {
            $this->_skipUpdate = ['slug'];
            $this->_skipUpdate = ['wallet_id'];
        }
    }

    public function balance()
    {
        $this->balance = 0;
    }

    public function getBalance()
    {
        return $this->balance;
    }

    public function deposit($amount)
    {
        $this->balance += $amount;
    }

    public function withdraw($amount)
    {
        if ($amount <= $this->balance) {
            $this->balance -= $amount;
            return true;
        } else {
            return false;
        }
    }
}
