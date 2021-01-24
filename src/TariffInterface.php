<?php

interface TariffInterface
{
    public function getKilometers();
    public function getMinutes();
    public function getInfo();
    public function addService(ServiceInterface $service):self;
    public function increaseExtraPrice($price);
    public function calcPriceOfTrip();
}
