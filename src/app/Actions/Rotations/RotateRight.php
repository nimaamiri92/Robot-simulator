<?php

namespace App\Actions\Rotations;

class RotateRight implements RotateInterface
{
    private const ROTATION_SYMBOL = 'R';

    public const ROTATE = 1;

    /**
     * @param $rotateSymbol
     *
     * @return bool
     */
    public function support($rotateSymbol): bool
    {
        return $rotateSymbol === self::ROTATION_SYMBOL;
    }

    /**
     * @return int
     */
    public function rotate(): int
    {
        return self::ROTATE;
    }
}