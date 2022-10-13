<?php

namespace App\Repository\Contracts;

interface IPdv
{
    public function getLimit(int $id) : float;
}
