<div class="eventos view large-9 medium-8 columns content">
    <h3><?= h($evento->nome).' ('.h($evento->id).')' ?></h3>
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
</div>
