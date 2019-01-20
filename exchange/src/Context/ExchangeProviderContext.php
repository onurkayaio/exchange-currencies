<?php

namespace App\Context;

use App\Service\Adapter\ExchangeProviderInterface;

class ExchangeProviderContext
{
    private $exchangeProviders = [];

    public function addExchangeProvider(ExchangeProviderInterface $exchangeProvider)
    {
        $this->exchangeProviders[] = $exchangeProvider;
    }

    public function getExchangeProviders()
    {
        return $this->exchangeProviders;
    }
}