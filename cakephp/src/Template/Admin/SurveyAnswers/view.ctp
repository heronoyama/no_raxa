<h1> <?= $survey->survey->nome . ' Respondido por '. $survey->user->nome?></h1>

<h4> Respostas </h4>

<table cellpadding="0" cellspacing="0">
    <tr>
        <th scope="col"><?= __('Pergunta') ?></th>
        <th scope="col"><?= __('Resposta') ?></th>
    </tr>
    <?php foreach ($survey->respostas as $resposta): ?>
    <tr>
        <td><?= h($resposta->pergunta->pergunta) ?></td>
        <td><?= $resposta->getResposta() ?></td>
    </tr>
    <?php endforeach; ?>
</table>