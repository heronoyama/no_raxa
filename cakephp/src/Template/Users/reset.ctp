<div class="users form">
    <?= $this->Form->create() ?>
    <?php
        echo $this->Form->control('password',['type'=>'password']);
    ?>
    <?= $this->Form->button('Salvar nova senha',['class'=>'button button-block']) ?>
    <?= $this->Form->end() ?>
</div>
