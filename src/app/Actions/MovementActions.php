<?php

namespace App\Actions;

use App\Actions\Movements\MovementInterface;

class MovementActions
{
    private iterable $movements;

    public const DO_NOT_MOVE = 0;

    /**
     * @param iterable|MovementInterface[] $movement
     */
    public function __construct(iterable $movement)
    {
        $this->movements = $movement;
    }

    public function makeMovement($action): int
    {
        foreach ($this->movements as $movement) {
            if ($movement->support($action)) {
                return $movement->move();
            }
        }

        return self::DO_NOT_MOVE;
    }
}