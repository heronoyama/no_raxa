<div class="eventos view large-9 medium-8 columns content"  id="DivisorDeDespesas">
<h3> <?= h($evento->nome).' ('.h($evento->id).')' ?> > Divisor</h3>

<div class='large-4 column' data-bind='component:{name:"participante-data-set", params:{ idEvento :<?=$evento->id?>}}'>
</div>

</div>

<script>
    requirejs(['/js/init.js'],function(){
       requirejs(['/js/app/Controllers/DivisorDeDespesasIndex.js']);
    });
</script>