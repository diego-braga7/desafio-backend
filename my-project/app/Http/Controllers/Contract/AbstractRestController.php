<?php
namespace App\Http\Controllers\Contract;

use App\Enum\HttpResponses;
use App\Validation\Contracts\AbstractValidation;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Routing\Controller as IlluminateRoutingController;
use Illuminate\Validation\Validator;

class AbstractRestController extends IlluminateRoutingController
{
    protected Validator $validator;

    public function __construct(
        protected AbstractValidation $validation,
        protected Request $request,
    )
    {
       $this->validator = $this->validation->make($this->request->all());
    }

    use ValidatesRequests;



    public function index(Request $request): JsonResponse|JsonResource
    {
        return $this->httpResponseMethodNotAllowed();
    }

    public function show(Request $request, mixed $id): JsonResponse|JsonResource
    {
        return $this->httpResponseMethodNotAllowed();
    }

    public function store(Request $request): JsonResponse|JsonResource
    {
        return $this->httpResponseMethodNotAllowed();
    }

    public function update(Request $request, mixed $id): JsonResponse|JsonResource
    {
        return $this->httpResponseMethodNotAllowed();
    }

    public function destroy(Request $request, mixed $id): JsonResponse|JsonResource
    {
        return $this->httpResponseMethodNotAllowed();
    }


    protected function jsonResponse(
        array         $data = [],
        HttpResponses $status = HttpResponses::OK,
        array         $headers = []
    )
    {
        return response()->json(
            $data, $status->value, $headers
        );

    }

    protected function httpResponseMethodNotAllowed(): JsonResource|JsonResponse
    {
        return $this->jsonResponse([
            'status' => HttpResponses::METHOD_NOT_ALLOWED->value,
            'message' => 'Method not allowed'
        ], HttpResponses::METHOD_NOT_ALLOWED);
    }

}
