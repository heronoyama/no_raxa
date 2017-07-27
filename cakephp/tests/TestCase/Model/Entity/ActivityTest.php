<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ActivitiesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

class ActivityTest extends TestCase {

	public $Activities;

    public $fixtures = [
        'app.todo_lists',
        'app.activities'
    ];

    public function setUp() {
        parent::setUp();
        $config = TableRegistry::exists('Activities') ? [] : ['className' => ActivitiesTable::class];
        $this->Activities = TableRegistry::get('Activities', $config);
    }

    public function tearDown() {
        unset($this->Activities);

        parent::tearDown();
    }

    public function testLabel(){
	
    	$activity = $this->Activities->get(1);
    	$this->assertFalse($activity->concluded);
    	$this->AssertEquals($activity->isConcludedLabel(),"FALSE");

    	$activity->concluded = true;
    	$this->Activities->save($activity);
    	$this->assertTrue($activity->concluded);
    	$this->AssertEquals($activity->isConcludedLabel(),"TRUE");

    }

    public function testToggleStatus(){
    	$activity = $this->Activities->get(1);
    	$this->assertFalse($activity->concluded);
    	$this->AssertEquals($activity->isConcludedLabel(),"FALSE");

    	$activity->toggleStatus();
    	$this->Activities->save($activity);
    	$this->assertTrue($activity->concluded);
    	$this->AssertEquals($activity->isConcludedLabel(),"TRUE");

    }

}
