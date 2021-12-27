<?php

namespace App;

use App\Actions\MovementActions;
use App\Actions\RotationActions;

class Simulator
{
    private Plateau $plateau;

    private MovementActions $movement;

    private RotationActions $rotate;

    public function __construct(Plateau $plateau, MovementActions $movement, RotationActions $rotate)
    {
        $this->plateau  = $plateau;
        $this->movement = $movement;
        $this->rotate   = $rotate;
    }

    /**
     * @param $data
     *
     * @return void
     */
    public function run($data): void
    {
        $inputs = $this->parseInputs($data);

        $this->setPlateauCoordinate($inputs);
        $robots  = $this->dispatchRobots($inputs);


        echo $this->getRobotsReport($robots);
    }

    /**
     * @param string $data
     *
     * @return array
     */
    private function parseInputs(string $data): array
    {
        $inputs = [];
        $handle = fopen($data, 'rb');

        while (($command = fgets($handle))) {
            $inputs[] = $command;
        }

        fclose($handle);

        return $inputs;
    }

    /**
     * @param $inputs
     *
     * @return void
     */
    private function setPlateauCoordinate(&$inputs): void
    {
        $planetData = trim(array_shift($inputs));
        $this->plateau->setWidth((int) $planetData[0]);
        $this->plateau->setHeight((int) $planetData[1]);
    }

    /**
     * @param array $inputs
     *
     * @return array
     */
    private function dispatchRobots(array &$inputs): array
    {
        $robots = [];
        while ($inputs) {
            $robot    = new Robot($this->plateau, $this->rotate, $this->movement);
            $landData = trim(array_shift($inputs));
            $command  = trim(array_shift($inputs));

            $robots[] = $robot->run($landData, $command);
        }

        return $robots;
    }

    /**
     * @param array $robots
     *
     * @return string
     */
    private function getRobotsReport(array $robots): string
    {
        $reports = '';
        foreach ($robots as $robot) {
            $reports .= implode(' ', $robot) . PHP_EOL;
        }

        return trim($reports);
    }
}