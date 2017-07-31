<div class="participantes form large-9 medium-8 columns content">
    <?= $this->Form->create($participante) ?>
    <fieldset>
        <legend><?= __('Edit Participante') ?></legend>
        <?php
            echo $this->Form->control('nome');
            echo $this->Form->control('eventos_id', ['options' => $eventos]);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
