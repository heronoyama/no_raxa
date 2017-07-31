<!--TODO Form templates? -->
<div class="eventos view large-9 medium-8 columns content">
    <h3 <?= 'data-id='.$evento->id?>> <?= h($evento->nome).' ('.h($evento->id).')' ?></h3>
        <?= $this->Html->link("Editar dados do evento",'/eventos/edit/'.$evento->id) ?>
    <div id='EventoModel'>
        
        <a class="editButton" data-bind="visible: !editing(), click:editing" > Edit </a>
        <a class="saveButton" data-bind="visible: editing, click:save" > Save </a>
        
        <table class="vertical-table">
            <?= $this->Form->hidden('id',[
                'value'=>$evento->id,
                'data-bind'=>'valueWithInit:"id"'
                    
                   ])?>
            <tr>
                <th scope="row"><?= __('Localizacao') ?></th>
                <td>
                    <?= $this->Form->text('localizacao',
                           ['value'=>$evento->localizacao,
                            'data-bind'=>'visible:editing, valueWithInit:\'localizacao\'']); ?>
                    <?="<span data-bind=\"visible: !editing(), text:localizacao\"></span>" ?>
                </td>
            </tr>
            <tr>
                <th scope="row"><?= __('Pessoas Previstas') ?></th>
                <td>
                    <?= $this->Form->text('pessoas_previstas', ['value' => $evento->pessoas_previstas,
                        'data-bind' => 'visible:editing, valueWithInit:\'pessoasPrevistas\'']);
                    ?>
                    <?= "<span data-bind=\"visible: !editing(), text:pessoasPrevistas\"></span>" ?>
                </td>
            </tr>
            <tr>
                <th scope="row"><?= __('Data') ?></th>
                <td>
                     <?= $this->Form->text('data', ['value' => $evento->data,
                        'data-bind' => 'visible:editing, valueWithInit:\'dataEvento\'']);
                    ?>
                    <?= "<span data-bind=\"visible: !editing(), text:dataEvento\"></span>" ?>
                    
                </td>
            </tr>
        </table>
    </div> 
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
<?php
    echo $this->Html->script('/js/Eventos/view');
?>