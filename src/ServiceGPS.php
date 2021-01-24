<?php
class ServiceGPS extends ServiceAbstract
{
    protected $name = "Gps";

    public function apply(TariffAbstract $tariff)
    {
        $hours = ceil($tariff->getMinutes() / 60);
        $tariff->increaseExtraPrice($hours *  $this->price);
    }
}