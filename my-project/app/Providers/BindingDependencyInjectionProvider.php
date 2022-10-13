<?php

namespace App\Providers;

use App\Http\Controllers\Api\PdvController;
use App\Http\Controllers\Api\VendaController;
use App\Repository\Contracts\IPdv;
use App\Repository\Contracts\IProdutosVendas;
use App\Repository\Contracts\IVendas;
use App\Repository\Pdv;
use App\Repository\ProdutosVendas;
use App\Repository\Venda;
use App\Services\Contract\AbstractRestService;
use App\Services\Contract\IValidationRequest;
use App\Services\Pdv\CreateRestService;
use App\Services\Pdv\getRestService;
use App\Services\Pdv\UpdateRestService;
use App\Services\Produto\Contract\IHttp;
use App\Services\Produto\Contract\IValidateService;
use App\Services\Produto\Http;
use App\Services\Produto\ValidateService;
use App\Services\ValidationRequest;
use App\Services\Venda\CreateRestService as CreateRestServiceVenda;
use App\Services\Venda\GetRestService as GetRestServiceVenda;
use App\Services\Venda\UpdateRestService as UpdateRestServiceVenda;
use App\Validation\Services\Pdv\Contracts\ACreateValidationService;
use App\Validation\Services\Pdv\Contracts\AUpdateValidationService;
use App\Validation\Services\Pdv\CreateValidationService;
use App\Validation\Services\Pdv\UpdateValidationService;
use App\Validation\Services\Venda\Contracts\ACreateValidationService as ACreateValidationServiceVenda;
use App\Validation\Services\Venda\Contracts\AUpdateValidationService as AUpdateValidationServiceVenda;
use App\Validation\Services\Venda\CreateValidationService as CreateValidationServiceVenda;
use App\Validation\Services\Venda\UpdateValidationService as UpdateValidationServiceVenda;
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

        $this->app->when(VendaController::class)
            ->needs(AbstractRestService::class)
            ->give(function ($app) {
                return [
                    $app->make(CreateRestServiceVenda::class),
                    $app->make(UpdateRestServiceVenda::class),
                    $app->make(GetRestServiceVenda::class),
                ];
            });

        $this->app->bind(ACreateValidationServiceVenda::class, CreateValidationServiceVenda::class);
        $this->app->bind(AUpdateValidationServiceVenda::class, UpdateValidationServiceVenda::class);
        $this->app->bind(IHttp::class, Http::class);
        $this->app->bind(IValidateService::class, ValidateService::class);

        $this->app->bind(IVendas::class, Venda::class);
        $this->app->bind(IProdutosVendas::class, ProdutosVendas::class);
        $this->app->bind(IPdv::class, Pdv::class);
    }
}
