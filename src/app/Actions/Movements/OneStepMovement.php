<?php

namespace App\Actions\Movements;

class OneStepMovement implements MovementInterface
{
    private const MOVEMENT_SYMBOL = 'M';

    public const MOVE_FORWARD = 1;

    /**
     * @param $movementName
     *
     * @return bool
     */
    public function support($movementName): bool
    {
        return $movementName === self::MOVEMENT_SYMBOL;
    }

    /**
     * @return int
     */
    public function move(): int
    {
        return self::MOVE_FORWARD;
    }
}