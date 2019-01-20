<?php

namespace App\Command;

use App\Entity\Currency;
use App\Enum\ExchangeProviderEnum;
use App\Repository\CurrencyRepository;
use App\Service\Adapter\ExchangeProviderInterface;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\DependencyInjection\Container;

class FetchCurrenciesCommand extends Command
{
    protected static $defaultName = 'fetch:currencies';

    /**
     * @var Container
     */
    private $container;

    /**
     * @var EntityManager
     */
    private $entityManager;

    /**
     * @var CurrencyRepository
     */
    private $currencyRepository;

    public function __construct(
        Container $container,
        EntityManager $entityManager,
        CurrencyRepository $currencyRepository
    ) {
        $this->container = $container;
        $this->entityManager = $entityManager;
        $this->currencyRepository = $currencyRepository;

        parent::__construct();
    }

    protected function configure()
    {
        $this->setDescription('this command allows you to fetch provider currencies.');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $providerContext = $this->container->get(ExchangeProviderEnum::PROVIDER_CONTEXT_ID);

        /** @var ExchangeProviderInterface $provider */
        foreach ($providerContext->getExchangeProviders() as $provider) {
            $result = $provider->getCurrencies();

            if (!empty($result)) {
                $currencies = $this->currencyRepository->getCurrenciesByProvider($result['provider']);

                $this->handleCurrencies($result, $currencies);

                $output->writeln(sprintf('%s currencies updated successfully.', $result['provider']));
            }
        }
    }

    private function handleCurrencies(array $result, $currencies)
    {
        $em = $this->entityManager;

        if (empty($currencies)) {
            $currencies = new Currency();

            $currencies->setProvider($result['provider']);
        }

        $currencies->setGbp($result['currencies']['gbp']);
        $currencies->setEur($result['currencies']['eur']);
        $currencies->setUsd($result['currencies']['usd']);

        $em->persist($currencies);
        $em->flush();
    }
}