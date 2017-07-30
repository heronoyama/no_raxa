<div class="todoLists form large-9 medium-8 columns content">
    <?= $this->Form->create($todoList) ?>
    <fieldset>
        <legend><?= __('Edit Todo List') ?></legend>
        <?php
            echo $this->Form->control('nome');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
