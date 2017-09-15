<div class="eventos form large-9 medium-8 columns content">
    <?= $this->Form->create($evento) ?>
    <fieldset>
        <legend><?= __('Add Evento') ?></legend>
        <?php
            echo $this->Form->control('nome');
            echo $this->Form->control('data');
            echo $this->Form->control('localizacao');
            echo $this->Form->control('pessoas_previstas');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
