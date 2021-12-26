<?php

namespace Test\UnitTest\Actions;

use App\Actions\Movements\OneStepMovement;
use PHPUnit\Framework\TestCase;
use App\Actions\MovementActions;

class MovementActionsTest extends TestCase
{
    public function test_make_successfull_movement()
    {
        $move   = 'M';
        $result = (new MovementActions([new OneStepMovement()]))->makeMovement($move);

        $this->assertEquals(OneStepMovement::MOVE_FORWARD, $result);
    }

    public function test_make_unsuccessfull_movement()
    {
        $move   = 'Q';
        $result = (new MovementActions([new OneStepMovement()]))->makeMovement($move);

        $this->assertEquals(MovementActions::DO_NOT_MOVE, $result);
    }
}