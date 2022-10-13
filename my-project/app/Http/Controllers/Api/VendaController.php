<?php

namespace App\Http\Controllers\Api;

use App\Enum\HttpResponses;
use App\Http\Controllers\Contract\AbstractRestController;
use App\Http\Controllers\Contract\IRestController;
use App\Services\Contract\AbstractRestService;
use App\Validation\Services\Venda\Contracts\ACreateValidationService;
use App\Validation\Services\Venda\Contracts\AUpdateValidationService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class VendaController extends AbstractRestController implements IRestController
{
    private AbstractRestService $create;
    private AbstractRestService $update;
    private AbstractRestService $get;

    public function __construct(
        private readonly ACreateValidationService $validationCreate,
        private readonly AUpdateValidationService $validationUpdate,
        AbstractRestService ...$abstractRestService
    )
    {
        $this->create = current($abstractRestService);
        next($abstractRestService);
        $this->update = current($abstractRestService);
        next($abstractRestService);
        $this->get = current($abstractRestService);
    }

    public function store(Request $request): JsonResponse|JsonResource
    {
        $validator = $this->validationCreate->make($request->all());

        if($validator->fails()){
            return $this->jsonResponse([$validator->errors()], HttpResponses::UNPROCESSABLE_ENTITY);
        }
        return $this->create->dispatch($validator->validate());
    }

    public function index(Request $request): JsonResponse|JsonResource
    {
        $data = $request->only(['status']);
        return $this->get->dispatch($data);
    }

    public function show(Request $request, mixed $id): JsonResponse|JsonResource
    {
        return $this->get->dispatch($request->all(), $id);
    }

    public function update(Request $request, mixed $id): JsonResponse|JsonResource
    {
        $data = $request->only(['status']);
        $validator = $this->validationUpdate->requireSometimes()->make($data);
        if($validator->fails()){
            return $this->jsonResponse([$validator->errors()], HttpResponses::UNPROCESSABLE_ENTITY);
        }
        return $this->update->dispatch($validator->validate(), $id);
    }
}
