<?php

namespace App\Services\Contract;

use App\Enum\HttpResponses;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;

abstract class AbstractRestService
{
  abstract public function dispatch(array $data, mixed $id = null): JsonResponse|JsonResource;


  protected function jsonResponse(mixed $responseData, HttpResponses $status = HttpResponses::OK): JsonResponse
  {
      return response()->json($responseData, $status->value);
  }
}
