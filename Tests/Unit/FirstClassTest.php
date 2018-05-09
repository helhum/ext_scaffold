<?php
namespace Helhum\ExtScaffold\Tests\Unit;

use Helhum\ExtScaffold\Tests\Unit\Fixtures\LoadableClass;
use Nimut\TestingFramework\TestCase\UnitTestCase;

class FirstClassTest extends UnitTestCase
{
    /**
     * @test
     */
    public function methodReturnsTrue()
    {
        $firstClassObject = new LoadableClass();
        $this->assertTrue($firstClassObject->returnsTrue());
    }
}
