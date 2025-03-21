<?php

namespace App\Entity;

use App\Repository\CurrencyRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CurrencyRepository::class)
 */
class Currency
{
    /**
    *@ORM\Id
    *@ORM\GeneratedValue
    *@ORM\Column(type="integer")
    */
    private $id;

    /**
    *@ORM\Column(type="string", length=30)
    */
    private $name;

    /**
    *@ORM\Column(type="string", length=3)
    */
    private $currency_code;
    /**
     *@ORM\Column(type="decimal", precision=5, scale=2) 
     */
    private $exchange_rate;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getCurrencyCode(): ?string
    {
        return $this->currency_code;
    }

    public function setCurrencyCode(string $currency_code): self
    {
        $this->currency_code = $currency_code;

        return $this;
    }

    public function getExchangeRate(): ?string
    {
        return $this->exchange_rate;
    }

    public function setExchangeRate(string $exchange_rate): self
    {
        $this->exchange_rate = $exchange_rate;

        return $this;
    }
}
