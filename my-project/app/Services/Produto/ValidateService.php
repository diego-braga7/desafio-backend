<?php
namespace App\Services\Produto;
use App\DomainModel\ProdutoVenda;
use App\Services\Produto\Contract\IHttp;
use App\Services\Produto\Contract\IValidateService;
use Illuminate\Support\Collection;

class ValidateService implements IValidateService
{
    public function __construct(
        private IHttp $http
    )
    {
    }

    public function get(array $productsRequest) : Collection
    {

       $collection = $this->http->request();
       $produtos = $collection->map((function ($produto) use ($productsRequest){

           foreach ($productsRequest as $productRequest) {
                if($produto['id'] == $productRequest['id']){
                    $produto['quantidade'] = $productRequest['quantidade'];
                    $produto['valor_unitario'] = $produto['valor'];
                    $produto['produto_id'] = $produto['id'];
                    $produto['id'] = 0;
                    return (new ProdutoVenda($produto));
                }
           }
           return false;
       }));

        return $produtos->filter(function ($produto){
            return $produto instanceof  ProdutoVenda;
         });
    }
}
