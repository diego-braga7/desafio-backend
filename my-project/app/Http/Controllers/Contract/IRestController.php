<?php
namespace App\Http\Controllers\Contract;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;

interface IRestController
{
    public function index(Request $request): JsonResponse|JsonResource;

    public function store(Request $request): JsonResponse|JsonResource;

    public function show(Request $request, mixed $id): JsonResponse|JsonResource;

    public function update(Request $request, mixed $id): JsonResponse|JsonResource;

    public function destroy(Request $request, mixed $id): JsonResponse|JsonResource;
}
