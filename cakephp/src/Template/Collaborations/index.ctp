<div class="eventos view large-9 medium-8 columns content"  id="EventoModel">
    <h3 <?= 'data-id='.$evento->id?>> <?= h($evento->nome).' ('.h($evento->id).')' ?> > Colaborações</h3>
    
    <table cellpadding="0" cellspacing="0">
    <thead>
            <tr>
                <th>Consumível</th>
                <th>Participante</th>
                <th>Valor</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
          <?php foreach($collaborations as $collaboration):?>
            <tr class='colaboracoes'>
                <td>
                    <?= $collaboration->consumable->nome ?>
                </td>
                <td>
                    <?= $collaboration->participante->nome ?>
                </td>
                <td>
                    <?= $collaboration->valor ?>
                </td>
                <td>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $collaboration->id], ['confirm' => __('Are you sure you want to delete # {0}?', $collaboration->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <?= $this->Form->create() ?>
    <fieldset>
        <legend><?= __('Nova colaboração') ?></legend>
        <?php
            echo $this->Form->control('valor');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>

</div>

<?php
    echo $this->Html->script('/js/Colaborations/index');
?>
