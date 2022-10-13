<?php
namespace App\DomainModel\Contracts;

abstract class AbstractDomainModel
{

    public abstract function toArray(): array;

    protected function autoPopulate($data){
        $reflection = new \ReflectionClass(get_class($this));
        foreach ($reflection->getProperties() as $attribute){
            if(!isset($data[$this->camelToSnake($attribute->getName())])){
                continue;
            }
            $set = "set".ucfirst($this->snakeToCamel($attribute->getName()));
            $this->$set($data[$this->camelToSnake($attribute->getName())]);
        }
    }

    private function camelToSnake($input)
    {
        return strtolower(preg_replace('/(?<!^)[A-Z]/', '_$0', $input));
    }

    private function snakeToCamel($input)
    {
        return lcfirst(str_replace(' ', '', ucwords(str_replace('_', ' ', $input))));
    }
}
