
<div class="activities form large-9 medium-8 columns content">
    <?= $this->Form->create($activity) ?>
    <fieldset>
        <legend><?= __('Edit Activity') ?></legend>
        <?php
            echo $this->Form->control('nome');
            echo $this->Form->control('todo_lists_id', ['options' => $todoLists]);
            echo $this->Form->label('Concluído');
            echo $this->Form->checkbox('concluded');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
