<div class="eventos view large-9 medium-8 columns content"  id="CollaborationsModel">
    <h3> <?= h($evento->nome).' ('.h($evento->id).')' ?> > Colaborações</h3>
    
    <table cellpadding="0" cellspacing="0">
    <thead>
            <tr>
                <th data-bind='click:sortByConsumiveis'>Consumível</th>
                <th data-bind='click:sortByParticipantes'>Participante</th>
                <th data-bind='click:sortByValores'>Valor</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <!-- ko foreach: colaboracoes -->
            <tr class='colaboracoes'>
                <td data-bind="text:consumable().nome"></td>
                <td data-bind="text:participante().nome"></td>
                <td>
                    <b data-bind="visible: !editing(), text: valor, click: edit">&nbsp;</b>
                    <input data-bind="visible: editing, value: valor, hasFocus: editing"/>
                </td>
                <td>
                    <input type='hidden' data-bind="value:id" />
                    <a data-bind='click: $root.delete.bind(this,$data)'>Deletar</a>
                </td>
            </tr>
            <!-- /ko -->
        </tbody>
    </table>
    
    <a data-bind='click:clearFilter, visible:isFiltered'>Limpar Filtros</a>
    
  <?= $this->Html->link(__('Relatório todas colaborações'), '/csv/eventos/'.$evento->id.'/divisorDespesas/matrizColaboracao.csv') ?> 

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

      <form data-bind='submit:novaColaboracao'>
      <legend>Nova Colaboração</legend>
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
          <label for='novoValor'>Valor</label>
          <input type='text'  name='novoValor', data-bind='value:novoValor'/>
          <input type='submit' text="Criar">
          </div>
      </form>

   </div>
    

</div>

<script>
    requirejs(['/js/init.js'],function(){
       requirejs(['/js/app/Controllers/CollaborationsIndex.js']);
    });
</script>