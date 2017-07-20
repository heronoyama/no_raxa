<?php
/**
  * @var \App\View\AppView $this
  * @var \App\Model\Entity\TodoList[]|\Cake\Collection\CollectionInterface $todoLists
  */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Todo List'), ['action' => 'add']) ?></li>
    </ul>
</nav>
<div class="todoLists index large-9 medium-8 columns content">
    <h3><?= __('Todo Lists') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('nome') ?></th>
                <th scope="col"><?= $this->Paginator->sort('created') ?></th>
                <th scope="col"><?= $this->Paginator->sort('modified') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($todoLists as $todoList): ?>
            <tr>
                <td><?= $this->Number->format($todoList->id) ?></td>
                <td><?= h($todoList->nome) ?></td>
                <td><?= h($todoList->created) ?></td>
                <td><?= h($todoList->modified) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $todoList->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $todoList->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $todoList->id], ['confirm' => __('Are you sure you want to delete # {0}?', $todoList->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->first('<< ' . __('first')) ?>
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
            <?= $this->Paginator->last(__('last') . ' >>') ?>
        </ul>
        <p><?= $this->Paginator->counter(['format' => __('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')]) ?></p>
    </div>
</div>
