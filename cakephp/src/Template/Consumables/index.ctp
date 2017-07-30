<div class="eventos view large-9 medium-8 columns content"  id="EventoModel">
    <h3 <?= 'data-id='.$evento->id?>> <?= h($evento->nome).' ('.h($evento->id).')' ?> > Consumíveis</h3>
    
    <table cellpadding="0" cellspacing="0">
    <thead>
            <tr>
                <th>Nome</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
        <!-- ko foreach: consumiveis -->
            <tr class='consumables'>
                <td>
                    <b data-bind="visible: !editing(), text: nome, click: edit">&nbsp;</b>
                    <input data-bind="visible: editing, value: nome, hasFocus: editing"/>
                </td>    
                <td>
                    <input type='hidden' data-bind='value:id'/>
                    <a data-bind='click: deletar'>Deletar</a>
                </td>
            </tr>
        <!-- /ko -->
        </tbody>
    </table>

    <form data-bind='submit: criaConsumable' method="POST">
        <label>Nome</label>
        <input type='text' name='nomeConsumivel' data-bind='value: nomeConsumivel' required/>
        <button type='submit'> Criar </button>
    </form>

</div>

<?php
    echo $this->Html->script('/js/Consumables/index');
?>