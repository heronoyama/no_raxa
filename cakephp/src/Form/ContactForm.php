<?php
namespace App\Form;

use Cake\Form\Form;
use Cake\Form\Schema;
use Cake\Validation\Validator;
use Cake\Mailer\Email;

use Cake\Log\LogTrait;

class ContactForm extends Form {

    use LogTrait;

    protected function _buildSchema(Schema $schema)
    {
        return $schema
            ->addField('email', ['type' => 'string'])
            ->addField('body', ['type' => 'text']);
    }

    protected function _buildValidator(Validator $validator) {
        return $validator->add('email', 'format', [
                'rule' => 'email',
                'message' => 'A valid email address is required',
            ]);
    }

    protected function _execute(array $data) {
        $email = new Email();
        $email->profile('default');
        $email->from([$data['email']])
                ->to('heron.oyama@gmail.com')
                ->subject('Novo contato - No Raxa')
                ->send([$data['body']]);
        return true;
    }
}