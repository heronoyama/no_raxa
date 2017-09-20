<?php
use Migrations\AbstractMigration;

class CreateSurveyRespostas extends AbstractMigration {
    
    public function change() {
        $table = $this->table('survey_respostas');
        $table->addColumn('surveys_id', 'integer', [
            'default' => null,
            'limit' => 11,
            'null' => false,
        ]);
        $table->addColumn('users_id', 'integer', [
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
        $table->create();
    }
}
