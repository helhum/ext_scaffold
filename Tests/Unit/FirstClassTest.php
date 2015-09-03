<?php
namespace Helhum\ExtScaffold\Tests\Unit;

use TYPO3\CMS\Core\Tests\UnitTestCase;
use Helhum\ExtScaffold\FirstClass;

class FirstClassTest extends UnitTestCase
{
	/**
	 * @test
	 */
	public function methodReturnsTrue() {
		$firstClassObject = new FirstClass();
		$this->assertTrue($firstClassObject->returnsTrue());
	}
}