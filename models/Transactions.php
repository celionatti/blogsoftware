<?php

namespace models;

use Core\Database\DbModel;
use Core\Support\Helpers\Token;
use Core\Validations\RequiredValidation;
use Core\Validations\UniqueValidation;

class Transactions extends DbModel
{
    const STATUS_SUCCESS = "success";
    const STATUS_FAILED = "failed";
    const STATUS_PENDING = "pending";

    const CREDIT_METHOD = "credit";
    const TRANSFER_METHOD = "transfer";
    const WEB_METHOD = "web";

    // public string $id = "";
    public string $slug = "";
    public string $to = "";
    public string $from = "";
    public string $method = "";
    public string $details = "";
    public string|float|null $amount = 0;
    public string $status = self::STATUS_PENDING;
    public string $created_at = "";
    public string $updated_at = "";

    public static function tableName(): string
    {
        return 'transactions';
    }

    public function beforeSave(): void
    {
        $this->timeStamps();

        $this->runValidation(new RequiredValidation($this, ['field' => 'to', 'msg' => "Receiver is a required field."]));
        $this->runValidation(new RequiredValidation($this, ['field' => 'from', 'msg' => "Sender is a required field."]));
        $this->runValidation(new RequiredValidation($this, ['field' => 'method', 'msg' => "Method is a required field."]));
        $this->runValidation(new RequiredValidation($this, ['field' => 'amount', 'msg' => "Amount is a required field."]));
        // $this->runValidation(new UniqueValidation($this, ['field' => ['slug', 'to', 'from'], 'msg' => "Transaction Already Exists."]));

        if ($this->isNew()) {
            $this->slug = Token::generateOTP(60);
        } else {
            $this->_skipUpdate = ['slug'];
        }
    }

}
