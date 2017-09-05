<div id='dashboard'>
<section id='entidades' data-bind='component:{name:"dashboard-entidade"}'>
</section>

<section id='relatorios' data-bind='component:{name:"painel-relatorio",params:{ idEvento :<?=$evento->id?>}}'>
</section>

<section id='divisor'>
<div class='fleft half-size' data-bind='component:{name:"participante-data-set", params:{ idEvento :<?=$evento->id?>}}'></div>
<div class='fright half-size' data-bind='component:{name:"consumiveis-data-set", params:{ idEvento :<?=$evento->id?>}}'></div>

</section>


<script>
    requirejs(['/js/init.js'],function(){
       requirejs(['/js/app/Controllers/DashboardIndex.js']);
    });
</script>