<?php

namespace App\Actions\Rotations;

class RotateLeft implements RotateInterface
{

    private const ROTATION_SYMBOL = 'L';

    public const ROTATE = -1;

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