<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Eventos'), ['action' => 'index']) ?></li>
    </ul>
</nav>
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
