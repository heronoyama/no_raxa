<div class="users form">
    
    <?= $this->Form->create($user) ?>
    <?php
        echo $this->Form->control('nome');
        echo $this->Form->control('email',['type'=>'email']);
        echo $this->Form->control('password');
    ?>
    <?= $this->Form->button('Criar',['class'=>'button button-block']) ?>
    <?= $this->Form->end() ?>
</div>
