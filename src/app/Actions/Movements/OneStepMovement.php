<?php

namespace App\Actions\Movements;

class OneStepMovement implements MovementInterface
{
    private const MOVEMENT_SYMBOL = 'M';

    public const MOVE_FORWARD = 1;

    public function support($movementName): bool
    {
        return $movementName === self::MOVEMENT_SYMBOL;
    }

    public function move(): int
    {
        return self::MOVE_FORWARD;
    }
}