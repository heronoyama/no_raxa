<?php
use Migrations\AbstractMigration;

class CreatePerguntas extends AbstractMigration {

    public function change() {
        $table = $this->table('perguntas');
        
        $table->addColumn('pergunta', 'string', [
            'default' => null,
            'limit' => 255,
            'null' => false,
        ]);

        $table->addColumn('tipoResposta', 'string', [
            'default' => null,
            'limit' => 255,
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
        $table->create();
    }
}
