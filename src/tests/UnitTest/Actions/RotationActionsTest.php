<?php

namespace Test\UnitTest\Actions;

use App\Actions\Movements\OneStepMovement;
use App\Actions\RotationActions;
use App\Actions\Rotations\RotateLeft;
use App\Actions\Rotations\RotateRight;
use PHPUnit\Framework\TestCase;
use App\Actions\MovementActions;

class RotationActionsTest extends TestCase
{
    public function test_make_successfull_right_rotation()
    {
        $rotate = 'R';
        $result = $this->getRotationBuilder($rotate);

        $this->assertEquals(RotateRight::ROTATE, $result);
    }

    public function test_make_successfull_left_rotation()
    {
        $rotate = 'L';
        $result = $this->getRotationBuilder($rotate);

        $this->assertEquals(RotateLeft::ROTATE, $result);
    }

    public function test_make_unsuccessfull_rotation()
    {
        $rotate = 'Q';
        $result = $this->getRotationBuilder($rotate);

        $this->assertEquals(RotationActions::DO_NOT_ROTATE, $result);
    }

    /**
     * @param string $rotate
     *
     * @return int
     */
    protected function getRotationBuilder(string $rotate): int
    {
        return (new RotationActions([new RotateLeft(), new RotateRight()]))->makeRotation($rotate);
    }
}