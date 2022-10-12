<?php

namespace App\Validation\Contracts;

use Illuminate\Contracts\Validation\Validator as IValidator;
use Illuminate\Support\Facades\Validator;

abstract class AbstractValidation
{

    protected const REQUIRED = 'required';
    protected const SOMETIMES = 'sometimes';

    protected array $data;

    protected string $requiredValidationMethod = self::REQUIRED;

    protected function getMessages() : array
    {
        return [];
    }

    protected function getCustomAttributes() : array
    {
        return [];
    }

    public function make(array $data) : IValidator
    {
        return Validator::make(
            $data,
            $this->getRules(),
            $this->getMessages(),
            $this->getCustomAttributes()
        );

    }

    public function requireSometimes(bool $sometimes = true): self
    {
        $this->requiredValidationMethod =  ($sometimes) ? self::SOMETIMES : self::REQUIRED;
        return $this;
    }

    abstract protected function getRules() : array;

}
