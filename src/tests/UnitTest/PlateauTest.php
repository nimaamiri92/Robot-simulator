<?php

namespace Test\UnitTest;


use App\Plateau;
use Mockery\Adapter\Phpunit\MockeryTestCase;

class PlateauTest extends MockeryTestCase
{

    public function test_coordination_outside_of_plateau()
    {
        $plateau = $this->definePlateau();

        $this->assertFalse($plateau->isInPlanetBorders(6,6));
        $this->assertFalse($plateau->isInPlanetBorders(7,1));
        $this->assertFalse($plateau->isInPlanetBorders(2,8));
        $this->assertFalse($plateau->isInPlanetBorders(2,-1));
    }
    public function test_coordination_inside_of_plateau()
    {
        $plateau = $this->definePlateau();

        $this->assertTrue($plateau->isInPlanetBorders(0,5));
        $this->assertTrue($plateau->isInPlanetBorders(1,2));
        $this->assertTrue($plateau->isInPlanetBorders(3,3));
    }

    /**
     * @return Plateau
     */
    protected function definePlateau(): Plateau
    {
        $plateau = new Plateau();
        $plateau->setWidth(5);
        $plateau->setHeight(5);

        return $plateau;
    }
}
