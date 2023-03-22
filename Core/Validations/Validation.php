<?php

namespace Core\Validations;

use Exception;

abstract class Validation
{
    public bool $includeDeleted = false;
    public mixed $rule;
    public array $additionalFieldData = [];
    public mixed $field;
    public mixed $msg = '';
    public bool $success = true;
    protected $_obj;

    /**
     * @throws Exception
     */
    public function __construct($obj, $params)
    {
        $this->_obj = $obj;

        if (!array_key_exists('field', $params)) {
            throw new Exception("You must add a fields to the params array");
        }

        $this->field = $params['field'];
        if (is_array($params['field'])) {
            $this->field = $params['field'][0];
            array_shift($params['field']);
            $this->additionalFieldData = $params['field'];
        }

        if (!property_exists($this->_obj, $this->field)) {
            throw new Exception("The field must exist as a property on the model object");
        }

        if (!array_key_exists('msg', $params)) {
            throw new Exception("You must add a msg to the params array");
        }
        $this->msg = $params['msg'];

        if (array_key_exists('rule', $params)) {
            $this->rule = $params['rule'];
        }

        if (array_key_exists('includeDeleted', $params) && $params['includeDeleted']) {
            $this->includeDeleted = true;
        }

        try {
            $this->success = $this->runValidation();
        } catch (Exception $e) {
            echo "validation Exception on " . get_class() . ":" . $e->getMessage() . "<br />";
        }
    }

    abstract public function runValidation();
}