<?php
namespace App\Enum;

enum HttpResponses: int
{
    case NOT_FOUND = 404;
    case UNPROCESSABLE_ENTITY = 422;
    case METHOD_NOT_ALLOWED = 405;
    case OK = 200;
    case CREATED = 201;
}
