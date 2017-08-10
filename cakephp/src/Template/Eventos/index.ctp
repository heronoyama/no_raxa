<div class="eventos index large-9 medium-8 columns content">
    <h3><?= __('Eventos') ?></h3>
    <div><?= $this->Html->link(__('New Evento'), ['action' => 'add']) ?></div>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('nome') ?></th>
                <th scope="col"><?= $this->Paginator->sort('data') ?></th>
                <th scope="col"><?= $this->Paginator->sort('localizacao') ?></th>
                <th scope="col"><?= $this->Paginator->sort('pessoas_previstas') ?></th>
                <th scope="col"><?= $this->Paginator->sort('created') ?></th>
                <th scope="col"><?= $this->Paginator->sort('modified') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($eventos as $evento): ?>
            <tr>
                <td><?= $this->Number->format($evento->id) ?></td>
                <td><?= h($evento->nome) ?></td>
                <td><?= h($evento->data) ?></td>
                <td><?= h($evento->localizacao) ?></td>
                <td><?= $this->Number->format($evento->pessoas_previstas) ?></td>
                <td><?= h($evento->created) ?></td>
                <td><?= h($evento->modified) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $evento->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), '/eventos/delete/'.$evento->id, ['confirm' => __('Are you sure you want to delete # {0}?', $evento->id)]) ?>
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


