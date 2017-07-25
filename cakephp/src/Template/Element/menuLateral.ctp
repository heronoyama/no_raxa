<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Activities'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Activity'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Todo Lists'), ['controller' => 'TodoLists', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Todo List'), ['controller' => 'TodoLists', 'action' => 'add']) ?> </li>
    </ul>
</nav>