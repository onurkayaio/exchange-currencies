<?php

namespace App\Service\Adapter;

interface ExchangeProviderInterface
{
    public function getCurrencies();

    public function convertData(array $data);
}