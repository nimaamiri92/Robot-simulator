<?php

namespace App\Actions;

use App\Actions\Rotations\RotateInterface;

class RotationActions
{
    private iterable $rotates;

    public const DO_NOT_ROTATE = 0;
    /**
     * @param iterable|RotateInterface[] $rotate
     */
    public function __construct(iterable $rotate)
    {
        $this->rotates = $rotate;
    }

    /**
     * @param $action
     *
     * @return int
     */
    public function makeRotation($action): int
    {
        foreach ($this->rotates as $rotate){
            if ($rotate->support($action)) {
                 return $rotate->rotate();
            }
        }

        return self::DO_NOT_ROTATE;
    }
}