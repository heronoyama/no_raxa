<div class="eventos view large-9 medium-8 columns content"  id="EventoModel">
    <h3 <?= 'data-id='.$evento->id?>> <?= h($evento->nome).' ('.h($evento->id).')' ?></h3>
    <?= $this->Html->link("Editar dados do evento",'/eventos/edit/'.$evento->id) ?>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Localizacao') ?></th>
            <td><?= h($evento->localizacao) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Pessoas Previstas') ?></th>
            <td><?= $this->Number->format($evento->pessoas_previstas) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Data') ?></th>
            <td><?= h($evento->data) ?></td>
        </tr>
    </table>
       
    <div class='medium-6 column'>
    <h5>Consumiveis</h5>
    <table cellpadding="0" cellspacing="0">
    <thead>
            <tr>
                <th>Nome</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($consumables as $consumable): ?>
            <tr class='consumables'>
                <td><?= h($consumable->nome) ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
    </div>
    <div class='medium-6 column'>
    <h5>Participantes</h5>
    <table cellpadding="0" cellspacing="0">
    <thead>
            <tr>
                <th>Nome</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($consumables as $consumable): ?>
            <tr class='consumables'>
                <td><?= h($consumable->nome) ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
    </div>
    
</div>