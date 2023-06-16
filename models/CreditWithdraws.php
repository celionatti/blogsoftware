<?php

namespace models;

use Core\Database\DbModel;
use Core\Support\Helpers\Token;
use Core\Validations\RequiredValidation;

class CreditWithdraws extends DbModel
{
    const STATUS_SUCCESS = "success";
    const STATUS_FAILED = "failed";
    const STATUS_PENDING = "pending";


    public string $slug = "";
    public string $wallet_id = "";
    public string $user_id = "";
    public string|null $accepted_by = "";
    public string|null $bank = "";
    public string|null $account_number = "";
    public string|null $account_name = "";
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
        $this->runValidation(new RequiredValidation($this, ['field' => 'amount', 'msg' => "Amount is a required field."]));
        $this->runValidation(new RequiredValidation($this, ['field' => 'bank', 'msg' => "Bank is a required field."]));
        $this->runValidation(new RequiredValidation($this, ['field' => 'account_number', 'msg' => "Account Number is a required field."]));
        $this->runValidation(new RequiredValidation($this, ['field' => 'account_name', 'msg' => "Account Name is a required field."]));

        if ($this->isNew()) {
            $this->slug = Token::generateOTP(20);
        } else {
            $this->_skipUpdate = ['slug'];
        }
    }

    public static function withdrawPending_count()
    {
        $params = [
            'conditions' => "status = :status",
            'bind' => ['status' => 'pending']
        ];

        return self::findTotal($params);
    }

}
