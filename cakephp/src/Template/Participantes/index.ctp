<div class="participantes index large-9 medium-8 columns content" id="ParticipantesModel">
    <h3 <?= 'data-id='.$evento->id?>> <?= h($evento->nome).' ('.h($evento->id).')' ?> > Participantes</h3>
    
    <table cellpadding="0" cellspacing="0">
    <thead>
            <tr>
                <th>Nome</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
        <!-- ko with: evento -->
        <!-- ko foreach: participantes -->
            <tr class='participante'>
                <td>
                    <b data-bind="visible: !editing(), text: nome, click: edit">&nbsp;</b>
                    <input data-bind="visible: editing, value: nome, hasFocus: editing"/>
                </td>    
                <td>
                    <input type='hidden' data-bind='value:id'/>
                    <a data-bind='click: $root.delete.bind(this,$data)'>Deletar</a>
                </td>
            </tr>
        <!-- /ko -->
        <!-- /ko -->
        </tbody>
    </table>
    
    <form data-bind='submit: criaParticipante' method="POST">
        <label>Nome</label>
        <input type='text' name='nomeParticipante' data-bind='value: nomeParticipante' required/>
        <button type='submit'> Criar </button>
    </form>
    
</div>
<script>
    requirejs(['/js/init.js'],function(){
       requirejs(['/js/app/Controllers/ParticipantesIndex.js']);
    });
</script>