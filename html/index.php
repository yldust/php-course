<?php
include '../src/TariffInterface.php';
include '../src/TariffAbstract.php';
include '../src/BasicTariff.php';
include '../src/HourlyTariff.php';
include '../src/StudentTariff.php';
include '../src/ServiceInterface.php';
include '../src/ServiceAbstract.php';
include '../src/ServiceDriver.php';
include '../src/ServiceGPS.php';

/** @var TariffInterface $tariff */
$tariffBasic = new BasicTariff(20, 50);
$tariffBasic->addService(new ServiceDriver(100));

$tariffHourly = new HourlyTariff(10, 130);
$tariffHourly->addService(new ServiceGPS(15));

$tariffStudent = new StudentTariff(100, 200);
$tariffStudent->addService(new ServiceDriver(100))->addService(new ServiceGPS(15));

$arrayTariffs = [$tariffBasic, $tariffHourly, $tariffStudent];

foreach ($arrayTariffs as $tariff) {
    $tariff->getInfo();
    echo "Общая стоимость: " . $tariff->calcPriceOfTrip() . " руб.<br/><br/>";
}
