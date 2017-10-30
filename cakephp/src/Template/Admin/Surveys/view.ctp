<h1> <?= $survey->nome ?></h1>

<h4> Perguntas </h4>

<table cellpadding="0" cellspacing="0">
    <tr>
        <th scope="col"><?= __('Pergunta') ?></th>
        <th scope="col"><?= __('Tipo') ?></th>
    </tr>
    <?php foreach ($survey->perguntas as $pergunta): ?>
    <tr>
        <td><?= h($pergunta->pergunta) ?></td>
        <td><?= $pergunta->tipoResposta ?></td>
    </tr>
    <?php endforeach; ?>
</table>