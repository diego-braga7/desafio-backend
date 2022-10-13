<?php
namespace App\DomainModel;

use App\DomainModel\Contracts\AbstractDomainModel;

class ProdutoVenda extends  AbstractDomainModel
{
    private int $id;
    private int $vendaId;
    private int $produtoId;
    private string $descricao;
    private int $quantidade;
    private float $valorUnitario;
    private float $valorTotal;

    public function __construct(array $data = null)
    {
        $this->id = 0;
        $this->vendaId = 0;
        $this->produtoId = 0;
        $this->descricao = '';
        $this->quantidade = 0;
        $this->valorUnitario = 0;
        $this->valorTotal = 0;
        if(!is_null($data)){
            $this->autoPopulate($data);
        }
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'venda_id' => $this->vendaId,
            'produto_id' => $this->produtoId,
            'descricao' => $this->descricao,
            'quantidade' => $this->quantidade,
            'valor_unitario' => $this->valorUnitario,
            'valor_total' => $this->valorTotal,
        ];
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return ProdutoVenda
     */
    public function setId(int $id): ProdutoVenda
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return int
     */
    public function getVendaId(): int
    {
        return $this->vendaId;
    }

    /**
     * @param int $vendaId
     * @return ProdutoVenda
     */
    public function setVendaId(int $vendaId): ProdutoVenda
    {
        $this->vendaId = $vendaId;
        return $this;
    }

    /**
     * @return int
     */
    public function getProdutoId(): int
    {
        return $this->produtoId;
    }

    /**
     * @param int $produtoId
     * @return ProdutoVenda
     */
    public function setProdutoId(int $produtoId): ProdutoVenda
    {
        $this->produtoId = $produtoId;
        return $this;
    }

    /**
     * @return int
     */
    public function getQuantidade(): int
    {
        return $this->quantidade;
    }

    /**
     * @param int $quantidade
     * @return ProdutoVenda
     */
    public function setQuantidade(int $quantidade): ProdutoVenda
    {
        $this->quantidade = $quantidade;
        return $this;
    }

    /**
     * @return float
     */
    public function getValorUnitario(): float
    {
        return $this->valorUnitario;
    }

    /**
     * @param float $valorUnitario
     * @return ProdutoVenda
     */
    public function setValorUnitario(float $valorUnitario): ProdutoVenda
    {
        $this->valorUnitario = $valorUnitario;
        return $this;
    }

    /**
     * @return float
     */
    public function getValorTotal(): float
    {
        return $this->valorTotal;
    }

    /**
     * @param float $valorTotal
     * @return ProdutoVenda
     */
    public function setValorTotal(float $valorTotal): ProdutoVenda
    {
        $this->valorTotal = $valorTotal;
        return $this;
    }

    /**
     * @return string
     */
    public function getDescricao(): string
    {
        return $this->descricao;
    }

    /**
     * @param string $descricao
     * @return ProdutoVenda
     */
    public function setDescricao(string $descricao): ProdutoVenda
    {
        $this->descricao = $descricao;
        return $this;
    }



}
