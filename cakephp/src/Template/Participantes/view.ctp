<div class="participantes view  content">
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

<div data-bind='component:{name:"colaboracoes-data-set", params:{ idEvento :<?=$evento->id?>,idParticipante:<?=$participante->id?>}}'>
    </div>

<div data-bind='component:{name:"consumos-data-set", params:{ idEvento :<?=$evento->id?>,idParticipante:<?=$participante->id?>}}'>
    </div>

<script>
    requirejs(['/js/init.js'],function(){
        requirejs(['/js/app/Controllers/LoadComponents.js']);
    });
</script>
    
</div>
