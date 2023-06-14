<?php

namespace models;

use Core\Database\DbModel;
use Core\Support\Helpers\Token;
use Core\Validations\RequiredValidation;
use Core\Validations\UniqueValidation;

class CreditWithdraws extends DbModel
{
    const STATUS_SUCCESS = "success";
    const STATUS_FAILED = "failed";
    const STATUS_PENDING = "pending";


    public string $slug = "";
    public string $wallet_id = "";
    public string $user_id = "";
    public string $details = "";
    public string|float|null $amount = 0;
    public string $status = self::STATUS_PENDING;
    public string $created_at = "";
    public string $updated_at = "";

    public static function tableName(): string
    {
        return 'credit_withdraws';
    }

    public function beforeSave(): void
    {
        $this->timeStamps();

        $this->runValidation(new RequiredValidation($this, ['field' => 'wallet_id', 'msg' => "Wallet ID is a required field."]));
        $this->runValidation(new RequiredValidation($this, ['field' => 'user_id', 'msg' => "User ID is a required field."]));
        $this->runValidation(new RequiredValidation($this, ['field' => 'details', 'msg' => "Details is a required field."]));
        $this->runValidation(new RequiredValidation($this, ['field' => 'amount', 'msg' => "Amount is a required field."]));

        if ($this->isNew()) {
            $this->slug = Token::generateOTP(20);
        } else {
            $this->_skipUpdate = ['slug'];
        }
    }

}
