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
    public function run($data)
    {
        $inputs = $this->parseInputs($data);

        $this->buildPlateau($inputs);
        $robots  = $this->dispatchRobots($inputs);
        $reports = $this->parseRobotsReport($robots);

        echo $reports;
    }


    /**
     * @param $data
     * @param array $inputs
     *
     * @return void
     */
    private function parseInputs($data): array
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
    private function buildPlateau(&$inputs): void
    {
        $planetData = trim(array_shift($inputs));
        $this->plateau->setWidth($planetData[0]);
        $this->plateau->setHeight($planetData[1]);
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
            $robots[] = (new Robot($this->plateau, $this->rotate, $this->movement))->run(
                trim(array_shift($inputs)),
                trim(array_shift($inputs))
            );
        }

        return $robots;
    }

    private function parseRobotsReport(array $robots)
    {
        $reports = '';
        foreach ($robots as $robot) {
            $reports .= implode(' ', $robot) . PHP_EOL;
        }

        return trim($reports,PHP_EOL);
    }
}