<?php
/**
  * @var \App\View\AppView $this
  * @var \App\Model\Entity\TodoList $todoList
  */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Todo List'), ['action' => 'edit', $todoList->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Todo List'), ['action' => 'delete', $todoList->id], ['confirm' => __('Are you sure you want to delete # {0}?', $todoList->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Todo Lists'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Todo List'), ['action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="todoLists view large-9 medium-8 columns content">
    <h3><?= h($todoList->nome) ?></h3>
    
    <h4>Atividades</h4>

    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('nome') ?></th>
                <th scope="col"><?= $this->Paginator->sort('created') ?></th>
                <th scope="col"><?= $this->Paginator->sort('modified') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($todoList->activities as $activity): ?>
            <tr>
                <td><?= $this->Number->format($activity->id) ?></td>
                <td><?= h($activity->nome) ?></td>
                <td><?= h($activity->created) ?></td>
                <td><?= h($activity->modified) ?></td>
                <td class="actions">
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <?= $this->Form->create($activity,['url'=>['action' =>'addActivity']]) ?>
    <fieldset>
        <legend><?= __('Add Activity') ?></legend>
        <?php
            echo $this->Form->control('activity.nome');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>

</div>
