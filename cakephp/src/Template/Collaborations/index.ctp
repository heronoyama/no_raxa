<div class="eventos view large-9 medium-8 columns content"  id="EventoModel">
    <h3 <?= 'data-id='.$evento->id?>> <?= h($evento->nome).' ('.h($evento->id).')' ?> > Colaborações</h3>
    
    <table cellpadding="0" cellspacing="0">
    <thead>
            <tr>
                <th>Nome</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
        <!-- ko foreach: colaboracoes-->
            <tr class='colaboracoes'>
                <td>
                    <b data-bind="visible: !editing(), text: nome, click: edit">&nbsp;</b>
                    <input data-bind="visible: editing, value: nome, hasFocus: editing"/>
                </td>
                <td>
                    <!--<b data-bind="visible: !editing(), text: nome, click: edit">&nbsp;</b>-->
                    <!--<input data-bind="visible: editing, value: nome, hasFocus: editing"/>-->
                    <span> Valor </span>
                </td>
                <td>
                    <input type='hidden' data-bind='value:id'/>
                    <a data-bind='click: deletar'>Deletar</a>
                </td>
            </tr>
        <!-- /ko -->
        </tbody>
    </table>

    <form data-bind='submit: criaColaboracao' method="POST">
        <label>Nome</label>
        <input type='text' name='valorColaboracao' data-bind='value: nomeConsumivel' required/>
        <button type='submit'> Criar </button>
    </form>

</div>
