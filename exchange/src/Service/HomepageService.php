<?php

namespace App\Service;

use App\Repository\CurrencyRepository;

class HomepageService
{
    /**
     * @var CurrencyRepository
     */
    private $currencyRepository;

    public function __construct(CurrencyRepository $currencyRepository)
    {
        $this->currencyRepository = $currencyRepository;
    }

    public function getLowestCurrencies()
    {
        $currencies = $this->currencyRepository->findCurrencies();

        return $this->prepareCurrencies($currencies);
    }

    /**
     * prepare currencies to render.
     *
     * @param $currencies
     * @return array
     */
    private function prepareCurrencies(array $currencies)
    {
        $result = [];

        foreach ($currencies as $currency) {
            $currencies = [
                'usd' => $currency['usd'],
                'eur' => $currency['eur'],
                'gbp' => $currency['gbp'],
            ];

            $min = min($currencies);
            $key = array_keys($currencies, min($currencies));

            array_push(
                $result,
                [
                    'currencyType' => $key[0],
                    'value' => $min,
                    'provider' => $currency['provider'],
                    'time' => $currency['updatedAt']->format('Y-m-d H:i:s'),
                ]
            );
        }

        return $result;
    }
}