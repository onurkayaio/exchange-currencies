<?php

namespace App\Tests\Command;

use App\Command\FetchCurrenciesCommand;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Console\Tester\CommandTester;

class FetchCurrenciesTest extends KernelTestCase
{
    public function testFetchCurrencies()
    {
        self::bootKernel();;

        $application = new Application(self::$kernel);

        $application->add(
            new FetchCurrenciesCommand(
                self::$container,
                self::$container->get('doctrine.orm.default_entity_manager'),
                self::$container->get('App\Repository\CurrencyRepository')
            )
        );

        $command = $application->find('fetch:currencies');

        $commandTester = new CommandTester($command);
        $commandTester->execute(
            [
                'command' => $command->getName(),
            ]
        );

        $output = $commandTester->getDisplay();

        $this->assertContains('providerOne currencies updated successfully.', $output);
        $this->assertContains('providerTwo currencies updated successfully.', $output);
    }
}