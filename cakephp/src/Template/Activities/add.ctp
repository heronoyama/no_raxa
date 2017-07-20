<?php
/**
  * @var \App\View\AppView $this
  */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Activities'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Todo Lists'), ['controller' => 'TodoLists', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Todo List'), ['controller' => 'TodoLists', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="activities form large-9 medium-8 columns content">
    <?= $this->Form->create($activity) ?>
    <fieldset>
        <legend><?= __('Add Activity') ?></legend>
        <?php
            echo $this->Form->control('nome');
            echo $this->Form->control('todo_lists_id', ['options' => $todoLists]);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
