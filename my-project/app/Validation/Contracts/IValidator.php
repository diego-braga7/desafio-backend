<?php

namespace App\Validation\Contracts;

interface IValidator
{
    public function isValid(mixed $value): bool;
}
