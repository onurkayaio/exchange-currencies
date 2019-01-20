<?php

namespace App\Entity;

use App\Entity\Utility\TimestampTrait;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CurrencyRepository")
 * @ORM\HasLifecycleCallbacks()
 * @ORM\Table(name="currencies")
 */
class Currency
{
    use TimestampTrait;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(name="eur", type="float")
     *
     * @var float
     */
    private $eur;

    /**
     * @ORM\Column(name="usd", type="float")
     *
     * @var float
     */
    private $usd;

    /**
     * @ORM\Column(name="gbp", type="float")
     *
     * @var float
     */
    private $gbp;

    /**
     * @ORM\Column(name="provider", type="string")
     *
     * @var string
     */
    private $provider;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param integer $id
     *
     * @return Currency
     */
    public function setId($id): Currency
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return float
     */
    public function getEur()
    {
        return $this->eur;
    }

    /**
     * @param float $eur
     *
     * @return Currency
     */
    public function setEur($eur): Currency
    {
        $this->eur = $eur;

        return $this;
    }

    /**
     * @return float
     */
    public function getUsd()
    {
        return $this->usd;
    }

    /**
     * @param float $usd
     *
     * @return Currency
     */
    public function setUsd($usd): Currency
    {
        $this->usd = $usd;

        return $this;
    }

    /**
     * @return float
     */
    public function getGbp()
    {
        return $this->gbp;
    }

    /**
     * @param float $gbp
     *
     * @return Currency
     */
    public function setGbp($gbp): Currency
    {
        $this->gbp = $gbp;

        return $this;
    }

    /**
     * @return string
     */
    public function getProvider(): string
    {
        return $this->provider;
    }

    /**
     * @param string $provider
     *
     * @return Currency
     */
    public function setProvider(string $provider): Currency
    {
        $this->provider = $provider;

        return $this;
    }
}