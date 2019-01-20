<?php

namespace App\Service\Adapter;

use App\Enum\ExchangeProviderEnum;
use GuzzleHttp\ClientInterface;
use Symfony\Component\HttpFoundation\Request;

class ProviderOne implements ExchangeProviderInterface
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
            'provider' => ExchangeProviderEnum::PROVIDER_ONE,
            'currencies' => [],
        ];

        foreach ($data['result'] as $value) {
            switch ($value['symbol']) {
                case 'USDTRY':
                    $exchangeProvider['currencies']['usd'] = $value['amount'];
                    break;
                case 'EURTRY':
                    $exchangeProvider['currencies']['eur'] = $value['amount'];
                    break;
                case 'GBPTRY':
                    $exchangeProvider['currencies']['gbp'] = $value['amount'];
                    break;
                default:
                    break;
            }
        }

        return $exchangeProvider;
    }
}