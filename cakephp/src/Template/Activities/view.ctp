<?php
/**
  * @var \App\View\AppView $this
  * @var \App\Model\Entity\Activity $activity
  */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Activity'), ['action' => 'edit', $activity->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Activity'), ['action' => 'delete', $activity->id], ['confirm' => __('Are you sure you want to delete # {0}?', $activity->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Activities'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Activity'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Todo Lists'), ['controller' => 'TodoLists', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Todo List'), ['controller' => 'TodoLists', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="activities view large-9 medium-8 columns content">
    <h3><?= h($activity->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Nome') ?></th>
            <td><?= h($activity->nome) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Todo List') ?></th>
            <td><?= $activity->has('todo_list') ? $this->Html->link($activity->todo_list->id, ['controller' => 'TodoLists', 'action' => 'view', $activity->todo_list->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($activity->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created') ?></th>
            <td><?= h($activity->created) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Modified') ?></th>
            <td><?= h($activity->modified) ?></td>
        </tr>
    </table>
</div>
