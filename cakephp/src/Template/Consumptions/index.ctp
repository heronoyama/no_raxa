<div class="consumptions index content"  id="ConsumosModel">
    <h3> <?= h($evento->nome).' ('.h($evento->id).')' ?> > Consumos</h3>
    
    <table cellpadding="0" cellspacing="0">
    <thead>
            <tr>
                <th data-bind='click:sortByConsumiveis'>Consumível</th>
                <th data-bind='click:sortByParticipantes'>Participante</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <!-- ko with: controller -->
            <!-- ko foreach: consumos -->
            <tr class='Consumos'>
                <td data-bind="text:consumivel().nome"></td>
                <td data-bind="text:participante().nome"></td>
                
                <td>
                    <input type='hidden' data-bind="value:id" />
                    <a data-bind='click: $parent.delete.bind(this,$data)'>Deletar</a>
                </td>
            </tr>
            <!-- /ko -->
            <!-- /ko -->
        </tbody>
    </table>
    
  <?= $this->Html->link(__('Relatório todos os consumos'), '/csv/eventos/'.$evento->id.'/divisorDespesas/matrizConsumo.csv') ?> 

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

      <form data-bind='submit:novoConsumo'>
      <legend>Novo Consumo</legend>
      <div class="large-4 columns">
        <label for="participantes">Participante</label>
          <select name='participantes' 
                  data-bind="
                        options: participantes,
                        optionsText: 'nome',
                        value: novoParticipante,
                        optionsCaption: 'selecione...'">                  >
                          
          </select>
      </div>
          <div class="large-4 columns">
          <label for="consumables">Consumível</label>
          <select name='consumables' 
                  data-bind="
                        options: consumiveis,
                        optionsText: 'nome',
                        value: novoConsumivel,
                        optionsCaption: 'selecione...'">
                          
                        </select>
          </div>
          <div class="large-4 columns">
          <input type='submit' text="Criar">
          </div>
      </form>

   </div>
    

</div>

<script>
    requirejs(['/js/init.js'],function(){
       requirejs(['/js/app/Controllers/ConsumosIndex.js']);
    });
</script>