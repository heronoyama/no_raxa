<?php
namespace App\Test\TestCase\View\Helper;

use App\View\Helper\SurveyHelper;
use Cake\TestSuite\TestCase;
use Cake\View\View;

/**
 * App\View\Helper\SurveyHelper Test Case
 */
class SurveyHelperTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\View\Helper\SurveyHelper
     */
    public $Survey;

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $view = new View();
        $this->Survey = new SurveyHelper($view);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Survey);

        parent::tearDown();
    }

    /**
     * Test initial setup
     *
     * @return void
     */
    public function testInitialization()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
