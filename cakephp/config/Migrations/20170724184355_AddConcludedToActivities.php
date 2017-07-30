<?php
use Migrations\AbstractMigration;

class AddConcludedToActivities extends AbstractMigration
{
    /**
     * Change Method.
     *
     * More information on this method is available here:
     * http://docs.phinx.org/en/latest/migrations.html#the-change-method
     * @return void
     */
    public function change()
    {
        $table = $this->table('activities');
        $table->addColumn('concluded', 'boolean', [
            'default' => false,
            'null' => false,
        ]);
        $table->update();
    }
}
