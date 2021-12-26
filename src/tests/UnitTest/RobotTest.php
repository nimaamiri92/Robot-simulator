<?php

namespace Test\UnitTest;

use App\Actions\MovementActions;
use App\Actions\Movements\OneStepMovement;
use App\Actions\RotationActions;
use App\Actions\Rotations\RotateLeft;
use App\Actions\Rotations\RotateRight;
use App\Plateau;
use App\Robot;
use App\Simulator;
use Mockery;
use Mockery\Adapter\Phpunit\MockeryTestCase;

class RobotTest extends MockeryTestCase
{

    /**
     * @var Robot
     */
    private $robot;

    private $movementAction;

    private $rotateAction;

    private $plateau;

    public function setUp(): void
    {
        parent::setUp();
        $this->plateau        = Mockery::mock(Plateau::class);
        $this->movementAction = Mockery::mock(MovementActions::class);
        $this->rotateAction   = Mockery::mock(RotationActions::class);
        $this->robot          = Mockery::mock(Robot::class, [$this->plateau, $this->rotateAction, $this->movementAction])
                                       ->makePartial();
    }

    public function test_robot_can_not_land_outside_plateau()
    {
        $landData = '1 2 N';
        $commands = 'LM';

        $this->plateau->shouldReceive('isInPlanetBorders')->with(1, 2)->andReturnTrue();

        $this->expectException(\InvalidArgumentException::class);
        $this->robot->run($landData, $commands);
    }

    public function test_robot_has_correct_land_direction()
    {
        $landData = '1 2 Q';
        $commands = 'LM';

        $this->plateau->shouldReceive('isInPlanetBorders')->with(1, 2)->andReturnFalse();

        $this->expectException(\InvalidArgumentException::class);

        $this->robot->run($landData, $commands);
    }

    public function test_robot_land_correctly()
    {
        $landData = '1 2 W';

        $this->plateau->shouldReceive('isInPlanetBorders')->with(1, 2)->andReturnFalse();

        $this->robot->land($landData);

        $this->assertEquals($this->robot->getY(), 2);
        $this->assertEquals($this->robot->getX(), 1);
        $this->assertEquals($this->robot->getDirection(), 'W');
    }

    public function test_robot_can_get_move_command()
    {
        $commands = 'MM';

        $this->landRobot();

        $this->movementAction->shouldReceive('makeMovement')
                             ->with('M')->twice()->andReturn(OneStepMovement::MOVE_FORWARD);

        $this->rotateAction->shouldReceive('makeRotation')
                           ->with('M')->twice()->andReturn(RotationActions::DO_NOT_ROTATE);

        $this->robot->doActions($commands);

        $this->assertEquals($this->robot->getY(), 4);
        $this->assertEquals($this->robot->getX(), 1);
        $this->assertEquals($this->robot->getDirection(), 'N');
    }

    public function test_robot_can_get_rotate_left_command()
    {
        $commands = 'LL';

        $this->landRobot();

        $this->movementAction->shouldReceive('makeMovement')
                             ->with('L')->twice()->andReturn(MovementActions::DO_NOT_MOVE);

        $this->rotateAction->shouldReceive('makeRotation')
                           ->with('L')->twice()->andReturn(RotateLeft::ROTATE);

        $this->robot->doActions($commands);

        $this->assertEquals($this->robot->getY(), 2);
        $this->assertEquals($this->robot->getX(), 1);
        $this->assertEquals($this->robot->getDirection(), 'S');
    }

    public function test_robot_can_get_rotate_right_command()
    {
        $commands = 'RRR';

        $this->landRobot();

        $this->movementAction->shouldReceive('makeMovement')
                             ->with('R')->times(3)->andReturn(MovementActions::DO_NOT_MOVE);

        $this->rotateAction->shouldReceive('makeRotation')
                           ->with('R')->times(3)->andReturn(RotateRight::ROTATE);

        $this->robot->doActions($commands);

        $this->assertEquals($this->robot->getY(), 2);
        $this->assertEquals($this->robot->getX(), 1);
        $this->assertEquals($this->robot->getDirection(), 'W');
    }

    public function test_robot_can_move_and_rotate()
    {
        $commands = 'RM';

        $this->landRobot();

        $this->movementAction->shouldReceive('makeMovement')
                             ->with('R')->andReturn(MovementActions::DO_NOT_MOVE);
        $this->movementAction->shouldReceive('makeMovement')
                             ->with('M')->andReturn(OneStepMovement::MOVE_FORWARD);

        $this->rotateAction->shouldReceive('makeRotation')
                           ->with('R')->andReturn(RotateRight::ROTATE);
        $this->rotateAction->shouldReceive('makeRotation')
                           ->with('M')->andReturn(MovementActions::DO_NOT_MOVE);

        $this->robot->doActions($commands);

        $this->assertEquals($this->robot->getY(), 2);
        $this->assertEquals($this->robot->getX(), 2);
        $this->assertEquals($this->robot->getDirection(), 'E');
    }

    public function test_user_can_get_report()
    {
        $commands = 'RM';

        $this->landRobot();

        $this->movementAction->shouldReceive('makeMovement')
                             ->with('R')->andReturn(MovementActions::DO_NOT_MOVE);
        $this->movementAction->shouldReceive('makeMovement')
                             ->with('M')->andReturn(OneStepMovement::MOVE_FORWARD);

        $this->rotateAction->shouldReceive('makeRotation')
                           ->with('R')->andReturn(RotateRight::ROTATE);
        $this->rotateAction->shouldReceive('makeRotation')
                           ->with('M')->andReturn(MovementActions::DO_NOT_MOVE);

        $this->robot->doActions($commands);

        $expect = [
            $this->robot->getX(),
            $this->robot->getY(),
            $this->robot->getDirection(),
        ];

        $actual = [
            $this->robot->getX(),
            $this->robot->getY(),
            $this->robot->getDirection(),
        ];

        $this->assertEquals($expect, $actual);
    }

    public function test_get_string_directions()
    {
        $this->assertEquals('NESW',$this->robot->getDirections(''));
    }

    /**
     * @return void
     */
    protected function landRobot(): void
    {
        $this->robot->setX(1);
        $this->robot->setY(2);
        $this->robot->setDirection('N');
    }

}
