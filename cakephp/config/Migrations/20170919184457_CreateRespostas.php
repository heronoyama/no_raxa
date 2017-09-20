<?php
use Migrations\AbstractMigration;

class CreateRespostas extends AbstractMigration {
    
    public function change() {
        $table = $this->table('respostas');
        
        $table->addColumn('perguntas_id', 'integer', [
            'default' => null,
            'limit' => 11,
            'null' => false,
        ]);
        $table->addColumn('resposta', 'string', [
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
