<div class="surveys view large-9 medium-8 columns content">
    <h3><?= h($survey->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Nome') ?></th>
            <td><?= h($survey->nome) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($survey->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created') ?></th>
            <td><?= h($survey->created) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Modified') ?></th>
            <td><?= h($survey->modified) ?></td>
        </tr>
    </table>
    <div class="related">
        <h4><?= __('Related Perguntas') ?></h4>
        <?php if (!empty($survey->perguntas)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Pergunta') ?></th>
                <th scope="col"><?= __('TipoResposta') ?></th>
                <th scope="col"><?= __('Created') ?></th>
                <th scope="col"><?= __('Modified') ?></th>
                <th scope="col"><?= __('Surveys Id') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($survey->perguntas as $perguntas): ?>
            <tr>
                <td><?= h($perguntas->id) ?></td>
                <td><?= h($perguntas->pergunta) ?></td>
                <td><?= h($perguntas->tipoResposta) ?></td>
                <td><?= h($perguntas->created) ?></td>
                <td><?= h($perguntas->modified) ?></td>
                <td><?= h($perguntas->surveys_id) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'Perguntas', 'action' => 'view', $perguntas->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'Perguntas', 'action' => 'edit', $perguntas->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'Perguntas', 'action' => 'delete', $perguntas->id], ['confirm' => __('Are you sure you want to delete # {0}?', $perguntas->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
</div>
