<div class="divisor index content"  id="DivisorDeDespesas">
<h3> <?= h($evento->nome).' ('.h($evento->id).')' ?> > Divisor</h3>

<div class='large-12 panel'>
<?= $this->Html->link(__('Relatório balanço final'), '/csv/eventos/'.$evento->id.'/divisorDespesas/balancoFinalParticipantes.csv') ?> 
<div data-bind='component:{name:"participante-data-set", params:{ idEvento :<?=$evento->id?>}}'>
</div>
</div>


<div  class='large-12 panel'>
	<?= $this->Html->link(__('Relatório custo por recurso'), '/csv/eventos/'.$evento->id.'/divisorDespesas/valorPorRecursoAnalitico.csv') ?> 
	<div data-bind='component:{name:"consumiveis-data-set", params:{ idEvento :<?=$evento->id?>}}'>
	</div>
</div>

</div>

<script>
    requirejs(['/js/init.js'],function(){
       requirejs(['/js/app/Controllers/DivisorDeDespesasIndex.js']);
    });
</script>