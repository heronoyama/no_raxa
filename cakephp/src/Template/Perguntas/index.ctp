<div class="perguntas index large-9 medium-8 columns content">
    <h3><?= __('Perguntas') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('survey') ?></th>
                <th scope="col"><?= $this->Paginator->sort('pergunta') ?></th>
                <th scope="col"><?= $this->Paginator->sort('tipoResposta') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($perguntas as $pergunta): ?>
            <tr>
                <td><?= $this->Number->format($pergunta->id) ?></td>
                <td><?= h($pergunta->survey->nome) ?></td>
                <td><?= h($pergunta->pergunta) ?></td>
                <td><?= h($pergunta->tipoResposta) ?></td>
               
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
