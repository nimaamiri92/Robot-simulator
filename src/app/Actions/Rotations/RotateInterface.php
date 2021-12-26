<?php

namespace App\Actions\Rotations;

interface RotateInterface
{
    public function support($rotateSymbol):bool;

    public function rotate():int;
}