<?php

namespace Tests\Feature\Services\Venda;

use App\DomainModel\ProdutoVenda;
use App\DomainModel\Venda;
use App\Enum\HttpResponses;
use App\Repository\Contracts\IPdv;
use App\Repository\Contracts\IProdutosVendas;
use App\Repository\Contracts\IVendas;
use App\Services\Produto\Contract\IValidateService;
use App\Services\Venda\CreateRestService;
use Tests\TestCase;
use Illuminate\Support\Collection;

class CreateRestServiceTest extends TestCase
{

    private const PRODUTOS_REQUISICAO = [
        [
            'id' => 1,
            'quantidade' => 2
        ],
        [
            'id' => 2,
            'quantidade' => 2
        ]
    ];

    private const VENDA_ARRAY = [
        'id' => 1,
        'pdv_id' => 1,
        'valor' => 10.0,
        'status' => 'AGUARDANDO_PAGAMENTO',
        'quitado' => false
    ];

    public function makeHttpProdutos(): IValidateService
    {
        $vendaRepository = $this->createStub(IValidateService::class);

        $produtosRequisicao = self::PRODUTOS_REQUISICAO;
        $produtosVendas = [
            new ProdutoVenda(current($produtosRequisicao)),
            new ProdutoVenda(end($produtosRequisicao)),
        ];

        $collection = new Collection($produtosVendas);
        $vendaRepository->method('get')->willReturn(
            $collection
        );
        return $vendaRepository;
    }

    public function makeRepositoryVendaFind(bool $find = true): IVendas
    {
        $vendaRepository = $this->createStub(IVendas::class);

        $vendaRepository->method('create')->willReturn(
            $find ? (new Venda(self::VENDA_ARRAY)) : null
        );

        return $vendaRepository;
    }

    public function makeRepositoryPdvFind(float $limit = null): IPdv
    {
        $pdvRepository = $this->createStub(IPdv::class);

        $pdvRepository->method('getLimit')->willReturn(
            is_null($limit) ? 90.1 : $limit
        );
        return $pdvRepository;
    }

    public function makeRepositoryProdutosVendasFind(bool $find = true): IProdutosVendas
    {
        $produtosVendasRepository = $this->createStub(IProdutosVendas::class);

        $produtosVendasRepository->method('create')->willReturn(
            new ProdutoVenda([])
        );

        return $produtosVendasRepository;
    }


    public function testCreateSuccess()
    {

        $sut = new CreateRestService(
            produto: $this->makeHttpProdutos(),
            vendasRepository: $this->makeRepositoryVendaFind(),
            produtosVendasRepository: $this->makeRepositoryProdutosVendasFind(),
            pdvRepository: $this->makeRepositoryPdvFind()
        );
        $data = [];
        $data['produtos'] = self::PRODUTOS_REQUISICAO;
        $data['pdv_id'] = 1;
       $response = $sut->dispatch($data);

        $this->assertEquals(HttpResponses::CREATED->value, $response->getStatusCode());
        $this->assertEquals(self::VENDA_ARRAY, $response->getData(true));
    }

    public function testFailProductNotFound(){
        $sut = new CreateRestService(
            produto: $this->makeHttpProdutos(),
            vendasRepository: $this->makeRepositoryVendaFind(),
            produtosVendasRepository: $this->makeRepositoryProdutosVendasFind(),
            pdvRepository: $this->makeRepositoryPdvFind()
        );
        $data = [];
        $data['produtos'] = array_merge(self::PRODUTOS_REQUISICAO, [
            'id'=>3,
            'quantidade'=>5
        ]);
        $data['pdv_id'] = 1;
        $response = $sut->dispatch($data);

        $this->assertEquals(HttpResponses::UNPROCESSABLE_ENTITY->value, $response->getStatusCode());
    }

    public function testFailLimitBrokenOutFound(){
        $sut = new CreateRestService(
            produto: $this->makeHttpProdutos(),
            vendasRepository: $this->makeRepositoryVendaFind(),
            produtosVendasRepository: $this->makeRepositoryProdutosVendasFind(),
            pdvRepository: $this->makeRepositoryPdvFind(0.0)
        );
        $data = [];
        $data['produtos'] = self::PRODUTOS_REQUISICAO;
        $data['pdv_id'] = 1;
        $response = $sut->dispatch($data);

        $this->assertEquals(HttpResponses::UNPROCESSABLE_ENTITY->value, $response->getStatusCode());
    }
}
