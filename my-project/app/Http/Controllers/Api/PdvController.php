<?php
namespace App\Http\Controllers\Api;

use App\Enum\HttpResponses;
use App\Http\Controllers\Contract\AbstractRestController;
use App\Http\Controllers\Contract\IRestController;
use App\Services\Contract\AbstractRestService;
use App\Validation\Contracts\AbstractValidation;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PdvController extends AbstractRestController implements IRestController
{

    public function __construct(
        private readonly AbstractRestService $create,
        protected AbstractValidation $validation,
        protected Request            $request,
    )
    {
        parent::__construct($this->validation, $this->request);
    }

    public function store(Request $request): JsonResponse|JsonResource
    {
        if($this->validator->fails()){
            return $this->jsonResponse([$this->validator->errors()], HttpResponses::UNPROCESSABLE_ENTITY);
        }

        return $this->create->dispatch($this->validator->validate());
    }
}
