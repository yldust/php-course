<?php
abstract class ServiceAbstract implements ServiceInterface
{
    protected $price;
    protected $name = "";

    public function __construct(int $price)
    {
        $this->price = $price;
    }

    public function getInfo()
    {
        echo "$this->name, стоимость $this->price руб.";
    }
}