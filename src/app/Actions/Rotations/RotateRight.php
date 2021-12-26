<?php

namespace App\Actions\Rotations;

class RotateRight implements RotateInterface
{
    private const ROTATION_SYMBOL = 'R';

    public const ROTATE = 1;

    public function support($rotateSymbol): bool
    {
        return $rotateSymbol === self::ROTATION_SYMBOL;
    }

    public function rotate(): int
    {
        return self::ROTATE;
    }
}