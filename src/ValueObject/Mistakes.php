<?php

namespace App\ValueObject;

use App\Exception\GameEndedException;

final class Mistakes
{
    private readonly int $quantity;

    /**
     * @param int $mistakesQuantity
     */
    private function __construct(int $mistakesQuantity)
    {
        $this->quantity = $mistakesQuantity;
    }

    public static function createNew(): self
    {
        return new self(6);
    }

    /**
     * @return $this
     */
    public function subtractOne(): self
    {
        return new self($this->quantity - 1);
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }
}
