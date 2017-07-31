<div class="participantes view large-9 medium-8 columns content">
    <h3><?= h($participante->nome).' ('.h($participante->id).')' ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Evento') ?></th>
            <td><?= $participante->has('evento') ? $this->Html->link($evento->nome, ['controller' => 'Eventos', 'action' => 'view', $evento->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($participante->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created') ?></th>
            <td><?= h($participante->created) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Modified') ?></th>
            <td><?= h($participante->modified) ?></td>
        </tr>
    </table>
</div>
