<div class="users form">
    <?= $this->Form->create() ?>
        <?php
            echo $this->Form->control('email',['type'=>'email']);
        ?>
    <?= $this->Form->button('Solicitar nova senha',['class'=>'button button-block']) ?>
    <?= $this->Form->end() ?>
</div>
