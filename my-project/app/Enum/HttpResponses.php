<?php
namespace App\Enum;

enum HttpResponses: int
{
    case UNPROCESSABLE_ENTITY = 422;
    case METHOD_NOT_ALLOWED = 405;
    case OK = 200;
    case CREATED = 201;
}
