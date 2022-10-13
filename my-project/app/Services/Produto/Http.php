<?php

namespace App\Services\Produto;

use App\Enum\HttpResponses;
use App\Services\Produto\Contract\IHttp;
use Exception;
use Illuminate\Support\Facades\Http as HttpFacades;
use Illuminate\Database\Eloquent\Collection;

class Http implements IHttp
{

    private const BASE_URL = "https://api.redeconekta.com.br";
    private const URN = '/mockprodutos/produtos';

    /**
     * @throws Exception
     */
    public function request() : Collection
    {
        $uri = self::BASE_URL . self::URN;
        $response = HttpFacades::withHeaders([
            'Accept' => 'application/json'
        ])->get($uri);

        if($response->status() != HttpResponses::OK->value){
            throw new Exception(json_encode([
                'error' => $response->body()
            ]));
        }

        return new Collection(json_decode($response->body(), true));
    }
}
