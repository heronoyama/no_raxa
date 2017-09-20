
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Survey') ?></th>
                <th scope="col"><?= __('Usuário') ?></th>
            </tr>
            <?php foreach ($surveys  as $survey): ?>
            <tr>
                <td><?= $this->Html->link($survey->id,['action'=>'view',$survey->id]) ?></td>
                <td><?= h($survey->survey->nome) ?></td>
                <td><?= h($survey->user->nome) ?></td>
            </tr>
            <?php endforeach; ?>
        </table>
