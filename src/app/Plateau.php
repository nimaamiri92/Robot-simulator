<?php

namespace App;

class Plateau
{
    private int $width;

    private int $height;

    /**
     * @return int
     */
    public function getWidth(): int
    {
        return $this->width;
    }

    /**
     * @param $width
     *
     * @return void
     */
    public function setWidth(int $width): void
    {
        $this->width = $width;
    }

    private function getHeight(): int
    {
        return $this->height;
    }

    /**
     * @param $height
     *
     * @return void
     */
    public function setHeight(int $height): void
    {
        $this->height = $height;
    }

    /**
     * @param $x
     * @param $y
     *
     * @return bool
     */
    public function isInPlanetBorders($x, $y): bool
    {
        if ($x < 0 || $y < 0) {
            return false;
        }

        return $this->getWidth() >= $x && $this->getHeight() >= $y;
    }
}