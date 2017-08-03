<div class="eventos view large-9 medium-8 columns content"  id="CollaborationsModel">
    <h3> <?= h($evento->nome).' ('.h($evento->id).')' ?> > Colaborações</h3>
    
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
            <!-- ko foreach: colaboracoes -->
            <tr class='colaboracoes'>
                <td data-bind="text:consumable().nome"></td>
                <td data-bind="text:participante().nome"></td>
                <td data-bind="text:valor"></td>
                <td>
                    <input type='hidden' data-bind="id" />
                </td>
            </tr>
            <!-- /ko -->
        </tbody>
    </table>
    
    <a data-bind='click:clearFilter, visible:isFiltered'>Limpar Filtros</a>
    
    <div id='filtro'>
    <legend><?= __('Filtrar') ?></legend>
      <fieldset>
        <div class="large-6 columns">
        <label for="participantes">Participante</label>
        <select name='participantes' 
                data-bind="
                      options: participantes,
                      optionsText: 'nome',
                      selectedOptions: selectedParticipantes,
                      optionsCaption: 'selecione...'"
                multiple="true">
                        
                      </select>
        </div>
        <div class="large-6 columns">
        <label for="consumables">Consumível</label>
        <select name='consumables' 
                data-bind="
                      options: consumiveis,
                      optionsText: 'nome',
                      selectedOptions: selectedConsumiveis,
                      optionsCaption: 'selecione...'"
                multiple="true">
                        
                      </select>
        </div>
        <button data-bind='click: filtrar'> Filtrar </button>
      </fieldset>

   </div>
    

</div>

<script>
    requirejs(['/js/init.js'],function(){
       requirejs(['/js/app/Controllers/CollaborationsIndex.js']);
    });
</script>