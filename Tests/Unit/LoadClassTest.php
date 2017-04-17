<?php
namespace Helhum\ExtScaffold\Tests\Unit;

use TYPO3\CMS\Core\Tests\UnitTestCase;
use TYPO3\CMS\Core\Utility\GeneralUtility;

class LoadClassTest extends UnitTestCase
{

	/**
	 * @test
	 */
	public function loadCustomClassWithObjectManager() {
		$objectManager = GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\Object\\ObjectManager');
		$classBuilder = $objectManager->get('EBT\\ExtensionBuilder\\Service\\ClassBuilder');
		$this->assertTrue(is_object($classBuilder));
	}
}