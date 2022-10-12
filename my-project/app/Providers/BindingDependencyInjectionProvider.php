<?php

namespace App\Providers;

use App\Http\Controllers\Api\PdvController;
use App\Services\Contract\AbstractRestService;
use App\Services\Contract\IValidationRequest;
use App\Services\Pdv\CreateRestService;
use App\Services\Pdv\getRestService;
use App\Services\Pdv\UpdateRestService;
use App\Services\ValidationRequest;
use App\Validation\Services\Pdv\Contracts\ACreateValidationService;
use App\Validation\Services\Pdv\Contracts\AUpdateValidationService;
use App\Validation\Services\Pdv\CreateValidationService;
use App\Validation\Services\Pdv\UpdateValidationService;
use Illuminate\Support\ServiceProvider;

class BindingDependencyInjectionProvider extends ServiceProvider
{
    public function register()
    {
        parent::register();


        $this->app->bind(IValidationRequest::class, ValidationRequest::class);

        $this->app->when(PdvController::class)
            ->needs(AbstractRestService::class)
            ->give(function ($app) {
                return [
                    $app->make(CreateRestService::class),
                    $app->make(UpdateRestService::class),
                    $app->make(getRestService::class),
                ];
            });

        $this->app->bind(ACreateValidationService::class, CreateValidationService::class);
        $this->app->bind(AUpdateValidationService::class, UpdateValidationService::class);
    }
}
