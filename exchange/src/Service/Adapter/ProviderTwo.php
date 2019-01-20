<?php

namespace App\Service\Adapter;

use App\Enum\ExchangeProviderEnum;
use GuzzleHttp\ClientInterface;
use Symfony\Component\HttpFoundation\Request;

class ProviderTwo implements ExchangeProviderInterface
{
    /**
     * @var ClientInterface
     */
    private $client;

    public function __construct(ClientInterface $client)
    {
        $this->client = $client;
    }

    public function getCurrencies()
    {
        try {
            $response = $this->client->request(Request::METHOD_GET, '')->getBody()->getContents();

            $response = json_decode($response, true);

            return $this->convertData($response);
        } catch (\Exception $exception) {
            return false;
        }
    }

    public function convertData(array $data)
    {
        $exchangeProvider = [
            'provider' => ExchangeProviderEnum::PROVIDER_TWO,
            'currencies' => [],
        ];

        foreach ($data as $value) {
            $value['oran'] = floatval($value['oran']);

            switch ($value['kod']) {
                case 'DOLAR':
                    $exchangeProvider['currencies']['usd'] = $value['oran'];
                    break;
                case 'AVRO':
                    $exchangeProvider['currencies']['eur'] = $value['oran'];
                    break;
                case 'İNGİLİZ STERLİNİ':
                    $exchangeProvider['currencies']['gbp'] = $value['oran'];
                    break;
                default:
                    break;
            }
        }

        return $exchangeProvider;
    }
}