<?php

enum TariffType {
    case Actual;
    case Archive;
    case System;

    public function getString(): string
    {
        return match($this)
        {
            TariffType::Actual => 'Актуальный',
            TariffType::Archive => 'Архивный',
            TariffType::System => 'Системный',
        };
    }
}

class TariffDTO
{
    public function __construct(
        protected string $name = '',
        protected float $price = 0,
        protected int $period = 0,
        protected int $speed = 0,
        protected TariffType $type = TariffType::Actual,
    )
    { }

    public function getName(): string
    {
        return $this->name;
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    public function getPeriod(): int
    {
        return $this->period;
    }

    public function getSpeed(): int
    {
        return $this->speed;
    }

    public function getType(): string
    {
        return $this->type->getString();
    }

    public function setName(string $name)
    {
        if (strlen($name) > 0) $this->name = $name;
    }

    public function setPrice(float $price)
    {
        $this->setUnsigned('price', $price);
    }

    public function setPeriod(int $period)
    {
        $this->setUnsigned('period', $period);
    }

    public function setSpeed(int $speed)
    {
        $this->setUnsigned('speed', $speed);
    }

    private function setUnsigned(string $key, int|float $value)
    {
        if ($value >= 0) $this->$key = $value;
    }

    public function setType(TariffType $type)
    {
        $this->type = $type;
    }

    public function getAttributes(): array
    {
        $vars = array_keys(get_class_vars(static::class));
        $result = [];

        foreach ($vars as $elem) {
            $method = 'get' . ucfirst($elem);
            if (!method_exists(static::class, $method)) {
                $result[$elem] = $this->$elem;
                continue;
            }

            $result[$elem] = $this->$method();
        }

        return $result;
    }

    public function __toString(): string
    {
        return json_encode($this->getAttributes());
    }
}
