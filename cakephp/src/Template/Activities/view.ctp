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
            <th scope="row"><?= __('Concluded') ?></th>
            <td><?= ($activity->concluded)?'TRUE':'FALSE' ?></td>
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