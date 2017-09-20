<?php
namespace App\Test\TestCase\View\Helper;

use App\View\Helper\PerguntaHelper;
use Cake\TestSuite\TestCase;
use Cake\View\View;

/**
 * App\View\Helper\PerguntaHelper Test Case
 */
class PerguntaHelperTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\View\Helper\PerguntaHelper
     */
    public $Pergunta;

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $view = new View();
        $this->Pergunta = new PerguntaHelper($view);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Pergunta);

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
