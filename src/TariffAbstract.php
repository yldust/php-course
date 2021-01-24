<?php
abstract class TariffAbstract implements TariffInterface
{
    protected $name;
    protected $pricePerKilometer;
    protected $pricePerMinute;
    protected $kilometers;
    protected $minutes;
    protected $extraPrice = 0;
    protected $services = [];


    public function __construct(int $kilometers, int $minutes)
    {
        $this->kilometers = $kilometers;
        $this->minutes = $minutes;
    }

    protected function getName()
    {
        return $this->name;
    }

    protected function getPricePerKilometer()
    {
        return $this->pricePerKilometer;
    }

    protected function getPricePerMinute()
    {
        return $this->pricePerMinute;
    }

    protected function setExtraPrice($price)
    {
        $this->extraPrice =  $price;
    }

    protected function getExtraPrice():float
    {
        return $this->extraPrice;
    }

    public function getKilometers():int
    {
        return $this->kilometers;
    }

    public function getMinutes():int
    {
        return $this->minutes;
    }

    public function increaseExtraPrice($price)
    {
        $this->setExtraPrice( $this->getExtraPrice() + $price);
    }

    public function addService(ServiceInterface $service): TariffInterface
    {
        array_push($this->services, $service);
        return $this;
    }

    public function calcPriceOfTrip()
    {
        $totalPrice = $this->getKilometers() * $this->getPricePerKilometer()
            + $this->getMinutes() * $this->getPricePerMinute();

        foreach ($this->services as $service) {
            $service->apply($this);
        }

        $totalPrice = $totalPrice + $this->getExtraPrice();
        return $totalPrice;
    }

    public function getInfo()
    {
        echo "Тариф \"" . $this->getName() .
            "\" (" . $this->getPricePerKilometer() . " руб/км, " . $this->getPricePerMinute() . " руб/мин)<br/>";
        echo "Выбрано " . $this->getKilometers() . " км. и " . $this->minutes . " мин.<br/>";

        if ($this->services) {
            echo "<b>Подключены услуги:</b><br/>";

            foreach ($this->services as $service) {
                echo $service->getInfo() . "</br>";
            }
        }
    }
}