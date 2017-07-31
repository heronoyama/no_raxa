<?php
use Migrations\AbstractMigration;

class CreateCollaborations extends AbstractMigration
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
        $table = $this->table('collaborations');
        $table->addColumn('value', 'float', [
            'default' => null,
            'null' => false,
        ]);
        $table->addColumn('eventos_id', 'integer', [
            'default' => null,
            'limit' => 11,
            'null' => false,
        ]);
        $table->addColumn('participantes_id', 'integer', [
            'default' => null,
            'limit' => 11,
            'null' => false,
        ]);
        $table->addColumn('consumables_id', 'integer', [
            'default' => null,
            'limit' => 11,
            'null' => false,
        ]);
        $table->addColumn('created', 'datetime', [
            'default' => null,
            'null' => false,
        ]);
        $table->addColumn('modified', 'datetime', [
            'default' => null,
            'null' => false,
        ]);
        
        $table->addForeignKey('eventos_id','eventos','id');
        $table->addForeignKey('participantes_id','participantes','id');
        $table->addForeignKey('consumables_id','consumables','id');
        $table->create();
    }
}
