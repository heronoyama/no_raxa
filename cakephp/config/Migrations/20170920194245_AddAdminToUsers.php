<?php
use Migrations\AbstractMigration;

class AddAdminToUsers extends AbstractMigration
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
        $table = $this->table('users');
        $table->addColumn('isAdmin', 'boolean', [
            'default' => false,
            'null' => false,
        ]);
        $table->update();
    }
}
