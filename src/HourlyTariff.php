<?php
class HourlyTariff extends TariffAbstract
{
    protected $name = "Почасовой тариф";
    protected $pricePerKilometer = 0;
    protected $pricePerMinute = 200/60;

    public function __construct(int $kilometers, int $minutes)
    {
        parent::__construct($kilometers, $minutes);
        $this->minutes = $this->minutes - $this->minutes % 60 + 60;
    }
}