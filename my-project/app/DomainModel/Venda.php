<?php

namespace App\DomainModel;

use App\DomainModel\Contracts\AbstractDomainModel;
use App\Enum\StatusVenda;

class Venda extends AbstractDomainModel
{
    private int $id;
    private int $pdvId;
    private float $valor;
    private string $status;

    public function __construct(array $data = null)
    {
        $this->id = 0;
        $this->pdvId = 0;
        $this->valor = 0.0;
        $this->status = StatusVenda::AGUARDANDO->value;
        if(!is_null($data)){
            $this->autoPopulate($data);
        }
    }
    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'pdv_id' => $this->pdvId,
            'valor' => $this->valor,
            'status' => $this->status,
        ];
    }

    /**
     * @return int
     */
    public function getPdvId(): int
    {
        return $this->pdvId;
    }

    /**
     * @param int $pdvId
     * @return Venda
     */
    public function setPdvId(int $pdvId): Venda
    {
        $this->pdvId = $pdvId;
        return $this;
    }



    /**
     * @return float
     */
    public function getValor(): float
    {
        return $this->valor;
    }

    /**
     * @param float $valor
     * @return Venda
     */
    public function setValor(float $valor): Venda
    {
        $this->valor = $valor;
        return $this;
    }

    /**
     * @return string
     */
    public function getStatus(): string
    {
        return $this->status;
    }

    /**
     * @param string $status
     * @return Venda
     */
    public function setStatus(string $status): Venda
    {
        $this->status = $status;
        return $this;
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
     * @return Venda
     */
    public function setId(int $id): Venda
    {
        $this->id = $id;
        return $this;
    }


}
