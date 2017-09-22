<?php

namespace Tutorial\Validator;

use Zend\Validator\AbstractValidator;

class FloatValidator extends AbstractValidator
{
    const FLOAT = 'float';
    protected $messageTemplates = [
        self::FLOAT => "'%value%' is not a float",
    ];

    public function isValid($value)
    {
        $this->setValue($value);

        if (! is_float($value)) {
            $this->error(self::FLOAT);
            return false;
        }

        return true;
    }
}
