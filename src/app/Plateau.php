<?php

namespace App;


class Plateau
{
    private $width;

    private $height;

    /**
     * @return mixed
     */
    public function getWidth()
    {
        return $this->width;
    }

    /**
     * @param mixed $width
     */
    public function setWidth($width): void
    {
        $this->width = $width;
    }

    /**
     * @return mixed
     */
    public function getHeight()
    {
        return $this->height;
    }

    /**
     * @param mixed $height
     */
    public function setHeight($height): void
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