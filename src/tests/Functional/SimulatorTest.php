<?php

namespace Tests\Functional;

use App\Actions\MovementActions;
use App\Actions\Movements\OneStepMovement;
use App\Actions\RotationActions;
use App\Actions\Rotations\RotateLeft;
use App\Actions\Rotations\RotateRight;
use App\Plateau;
use App\Simulator;
use PHPUnit\Framework\TestCase;
use \Mockery;

class SimulatorTest extends TestCase
{
    private $movementAction;

    private $rotateAction;

    private $plateau;

    public function setUp(): void
    {
        parent::setUp();
        $this->plateau        = new Plateau();
        $this->movementAction = new MovementActions([new OneStepMovement()]);
        $this->rotateAction   = new RotationActions([new RotateRight(),new RotateLeft()]);
    }

    public function test_simulator_with_data_1()
    {
        $this->plateau->setWidth(5);
        $this->plateau->setHeight(5);


        (new Simulator($this->plateau, $this->movementAction, $this->rotateAction))->run('src/tests/data/test-1.txt');
        $this->expectOutputString("1 3 N\n5 1 E");

    }
    public function test_simulator_with_data_2()
    {
        $this->plateau->setWidth(5);
        $this->plateau->setHeight(5);


        (new Simulator($this->plateau, $this->movementAction, $this->rotateAction))->run('src/tests/data/test-2.txt');
        $this->expectOutputString("5 7 N\n5 3 S");

    }
}