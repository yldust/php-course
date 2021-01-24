<?php
interface ServiceInterface
{
    public function getInfo();
    public function apply (TariffAbstract $tariff);
}