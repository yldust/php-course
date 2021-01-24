<?php
class ServiceDriver extends ServiceAbstract
{
    protected $name = "Личный водитель";

    public function apply(TariffAbstract $tariff)
    {
        $tariff->increaseExtraPrice($this->price);
    }
}