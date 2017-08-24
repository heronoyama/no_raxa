<div id='dashboard'>
<section id='entidades' data-bind='component:{name:"dashboard-entidade"}'>
</section>

<section id='relatorios'>
</section>

<section id='divisor'>
</section>
</dashboard>

<script>
    requirejs(['/js/init.js'],function(){
       requirejs(['/js/app/Controllers/DashboardIndex.js']);
    });
</script>