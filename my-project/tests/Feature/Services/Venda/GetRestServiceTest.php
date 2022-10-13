<?php

namespace Tests\Feature\Services\Venda;

use App\DomainModel\Venda;
use App\Enum\HttpResponses;
use App\Repository\Contracts\IVendas;
use App\Services\Venda\GetRestService;
use Tests\TestCase;

class GetRestServiceTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_example()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    private const VENDA_ARRAY = [
        'id' => 1,
        'pdv_id' => 1,
        'valor' => 10.0,
        'status' => 'AGUARDANDO_PAGAMENTO',
    ];


    public function makeRepositoryFind(bool $find = true) : IVendas
    {
        $vendaRepository = $this->createStub(IVendas::class);

        $vendaRepository->method('find')->willReturn(
            $find ? (new Venda(self::VENDA_ARRAY)) : null
    );

        return $vendaRepository;
    }


    public function testFindVenda()
    {
        $sut = (new GetRestService($this->makeRepositoryFind(true)));
       $response = $sut->dispatch([],1);

        $this->assertEquals(HttpResponses::OK->value, $response->getStatusCode());

        $this->assertIsArray($response->getData(true));

        $this->assertEquals(self::VENDA_ARRAY, $response->getData(true));
    }
}
