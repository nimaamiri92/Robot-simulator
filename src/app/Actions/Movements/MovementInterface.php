<?php

namespace App\Actions\Movements;

interface MovementInterface
{
    public function support($movementName): bool;

    public function move(): int;
}