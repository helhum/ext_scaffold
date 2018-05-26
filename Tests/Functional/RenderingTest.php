<?php
namespace Helhum\ExtScaffold\Tests\Functional;

use Nimut\TestingFramework\Http\Response;
use Nimut\TestingFramework\TestCase\FunctionalTestCase;
use PHPUnit\Util\PHP\AbstractPhpProcess;
use TYPO3\CMS\Core\Utility\GeneralUtility;

class RenderingTest extends FunctionalTestCase
{
    /**
     * @var string[]
     */
    protected $testExtensionsToLoad = ['typo3conf/ext/ext_scaffold'];

    /**
     * @var string[]
     */
    protected $coreExtensionsToLoad = ['fluid'];

    protected function setUp()
    {
        parent::setUp();
        $this->importDataSet(__DIR__ . '/Fixtures/Database/pages.xml');
        $this->setUpFrontendRootPage(1, ['EXT:ext_scaffold/Tests/Functional/Fixtures/Frontend/Basic.ts']);
    }

    /**
     * @test
     */
    public function emailViewHelperWorksWithSpamProtection()
    {
        $expectedContent = '<a href="javascript:linkTo_UnCryptMailto(\'ocknvq,kphqBjgnjwo0kq\');">info(AT)helhum(DOT)io</a>' . chr(10);
        $this->assertSame($expectedContent, $this->getFrontendResponse(1)->getContent());
    }
}
