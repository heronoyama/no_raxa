<div class="todoLists view large-9 medium-8 columns content">
    <h3><?= h($todoList->nome) ?></h3>
    
    <h4>Atividades</h4>

    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('nome') ?></th>
                <th scope="col"><?= $this->Paginator->sort('concluded') ?></th>
                <th scope="col"><?= $this->Paginator->sort('created') ?></th>
                <th scope="col"><?= $this->Paginator->sort('modified') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($todoList->activities as $activity): ?>
            <tr <?= $activity->concluded? 'class="concludedActivity"' : ''?>
                <?= "id=activity-".$activity->id?> >
                <td><?= $this->Number->format($activity->id) ?></td>
                <td><?= h($activity->nome) ?></td>
                <td><?= $this->Form->checkbox('concluded',['checked'=>$activity->concluded,'onclick'=>'toggleActivity('.$activity->id.')']) ?></td>
                <td><?= h($activity->created) ?></td>
                <td><?= h($activity->modified) ?></td>
                <td class="actions">
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <?= $this->Form->create('Activities',['url'=>['action' =>'addActivity',$todoList->id],'method'=>'post']) ?>
    <fieldset>
        <legend><?= __('Add Activity') ?></legend>
        <?php
            echo $this->Form->control('nome');
            echo $this->Form->hidden('todo_lists_id',['value'=>$todoList->id]);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>

</div>
<?php
    echo $this->Html->script('/js/TodoLists/edit');
?>