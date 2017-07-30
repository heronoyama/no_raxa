<div class="consumables view large-9 medium-8 columns content">
    <h3><?= h($consumable->nome).' ('.h($consumable->id).')' ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Evento') ?></th>
            <td><?= $consumable->has('evento') ? $this->Html->link($evento->nome, ['controller' => 'Eventos', 'action' => 'view', $evento->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created') ?></th>
            <td><?= h($consumable->created) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Modified') ?></th>
            <td><?= h($consumable->modified) ?></td>
        </tr>
    </table>
</div>
