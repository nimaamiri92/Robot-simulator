<?php

namespace App;

use App\Actions\MovementActions;
use App\Actions\RotationActions;
use InvalidArgumentException;

class Robot
{
    private Plateau $planet;

    private const NORTH_DIRECTION = 'N';
    private const EAST_DIRECTION = 'E';
    private const SOUTH_DIRECTION = 'S';
    private const WEST_DIRECTION = 'W';

    private const COUNT_OF_DIRECTIONS = 4;

    private string $direction;

    private int $x = 0;

    private int $y = 0;

    private RotationActions $rotateBuilder;

    private MovementActions $movementBuilder;

    public function __construct(Plateau $planet, RotationActions $rotateBuilder, MovementActions $movementBuilder)
    {
        $this->planet          = $planet;
        $this->rotateBuilder   = $rotateBuilder;
        $this->movementBuilder = $movementBuilder;
    }

    /**
     * @return int
     */
    public function getX(): int
    {
        return $this->x;
    }

    /**
     * @param int $x
     *
     * @return void
     */
    public function setX(int $x): void
    {
        $this->x = $x;
    }

    /**
     * @return int
     */
    public function getY(): int
    {
        return $this->y;
    }

    /**
     * @param int $y
     *
     * @return void
     */
    public function setY(int $y): void
    {
        $this->y = $y;
    }

    /**
     * @return string
     */
    public function getDirection(): string
    {
        return $this->direction;
    }

    /**
     * @param string $direction
     *
     * @return void
     */
    public function setDirection(string $direction): void
    {
        $this->direction = $direction;
    }

    /**
     * @param string $landData
     * @param string $actions
     *
     * @return array
     */
    public function run(string $landData, string $actions): array
    {
        $this->land($landData);
        $this->doActions($actions);

        return $this->getReports();
    }

    /**
     * @param string $landData
     *
     * @return void
     */
    public function land(string $landData): void
    {
        [$x, $y, $direction] = explode(' ', $landData);

        if ($this->planet->isInPlanetBorders($x, $y)) {
            throw new InvalidArgumentException('Robot can not land on this coordinate');
        }

        if (! $this->directionExist($direction)) {
            throw new InvalidArgumentException('Robot does not support this direction');
        }

        $this->setX($x);
        $this->setY($y);
        $this->setDirection($direction);
    }

    /**
     * @param string $command
     *
     * @return void
     */
    public function doActions(string $command): void
    {
        $actions = str_split($command);
        foreach ($actions as $action) {
            $this->move($action);
            $this->rotate($action);
        }
    }

    /**
     * @return array
     */
    public function getReports(): array
    {
        return [
            $this->getX(),
            $this->getY(),
            $this->getDirection(),
        ];
    }

    /**
     * @param $action
     *
     * @return void
     */
    public function move($action): void
    {
        $move = $this->movementBuilder->makeMovement($action);

        switch ($this->getDirection()) {
            case self::NORTH_DIRECTION;
                $this->y += $move;
                break;

            case self::SOUTH_DIRECTION;
                $this->y -= $move;
                break;

            case self::EAST_DIRECTION;
                $this->x += $move;
                break;

            case self::WEST_DIRECTION;
                $this->x -= $move;
                break;
        }
    }

    /**
     * @param $action
     *
     * @return void
     */
    public function rotate($action): void
    {
        $rotate = $this->rotateBuilder->makeRotation($action);

        //convert compose directions to string (`NESW`) because we can easily access to -1 index for example
        $stringDirection = $this->getDirections('');

        $position = strpos($stringDirection, $this->direction);
        $position += $rotate;

        if ($position >= self::COUNT_OF_DIRECTIONS) {
            $position = self::COUNT_OF_DIRECTIONS - $position;
        }

        $this->direction = $stringDirection[$position];
    }

    /**
     * @param $separator
     *
     * @return string|string[]
     */
    public function getDirections($separator = null)
    {
        $rotations = [
            self::NORTH_DIRECTION,
            self::EAST_DIRECTION,
            self::SOUTH_DIRECTION,
            self::WEST_DIRECTION,
        ];

        return is_null($separator) ? $rotations : implode($separator, $rotations);
    }

    /**
     * @param string $direction
     *
     * @return bool
     */
    public function directionExist(string $direction): bool
    {
        return in_array($direction, $this->getDirections(), true);
    }

}