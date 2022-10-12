<?php

namespace App\Providers;

use App\Http\Controllers\Api\PdvController;
use App\Services\Contract\AbstractRestService;
use App\Services\Contract\IValidationRequest;
use App\Services\Pdv\createRestService;
use App\Services\ValidationRequest;
use App\Validation\Contracts\AbstractValidation;
use App\Validation\Services\Pdv\CreateValidationService;
use Illuminate\Support\ServiceProvider;

class BindingDependencyInjectionProvider extends ServiceProvider
{
    public function register()
    {
        parent::register();

        $this->app->when(PdvController::class)
        ->needs(AbstractRestService::class)
        ->give(fn($app) => $app->make(createRestService::class));

        $this->app->when(PdvController::class)
            ->needs(AbstractValidation::class)
            ->give(fn($app) => $app->make(CreateValidationService::class));

        $this->app->bind(IValidationRequest::class, ValidationRequest::class);
    }
}
