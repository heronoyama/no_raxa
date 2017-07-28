<div class="consumables index large-9 medium-8 columns content">
    <h3><?= __('Consumables') ?></h3>
    <div><?= $this->Html->link(__('New Consumable'), ['action' => 'add']) ?></div>
    
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('nome') ?></th>
                <th scope="col"><?= $this->Paginator->sort('eventos_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('created') ?></th>
                <th scope="col"><?= $this->Paginator->sort('modified') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($consumables as $consumable): ?>
            <tr>
                <td><?= $this->Number->format($consumable->id) ?></td>
                <td><?= h($consumable->nome) ?></td>
                <td><?= $consumable->has('evento') ? $this->Html->link($consumable->evento->nome, ['controller' => 'Eventos', 'action' => 'view', $consumable->evento->id]) : '' ?></td>
                <td><?= h($consumable->created) ?></td>
                <td><?= h($consumable->modified) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $consumable->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $consumable->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $consumable->id], ['confirm' => __('Are you sure you want to delete # {0}?', $consumable->id)]) ?>
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
