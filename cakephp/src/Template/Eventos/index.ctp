<div class="eventos index" id='eventoIndex'>
    <h3><?= __('Eventos') ?></h3>
    
    <?php foreach ($eventos as $evento): ?>
        <div class='evento'>
            <?= $this->Html->link($evento->nome, ['controller'=>'Dashboard', 'action' => 'index', $evento->id]) ?>
            <p class='date'><?= $evento->data->format('d/m/Y'); ?></p>
            <?=$this->Form->postLink($this->Html->tag('i','',['class'=>'fa fa-trash fa-1x']),
                 '/eventos/delete/'.$evento->id, ['escape'=>false, 'confirm' => __('Are you sure you want to delete # {0}?', $evento->id)])?>
        </div>
    <?php endforeach; ?>

    <?php 
        $cssClass = $quantidadeEventos >0 ? 'naoPodeCriar' : 'podeCriar';
        $baseClass = 'evento novoEvento '.$cssClass;
    ?>
    <div class='<?=$baseClass?>'>
        <?= $this->Html->link($this->Html->tag('i','',['class'=>'fa fa-plus fa-fw ']), ['action' => 'add'],['escape'=>false]) ?>
    </div>

</div>

<div id='survey' title="Cota preenchida!"></div>

<div id="dialog-message" title="Cota preenchida!" class='hidden'>
  <p>
      Você já atingiu o máximo de eventos gratuitos disponíveis, e já nos informou se tem desejo de continuar usando o sistema ou não.
   </p>
   <p>
      Qualquer dúvida, por favor, envie um e-mail para heron.oyama@gmail.com e responderei o mais rápido que puder :).
   </p>
</div>

<script>
    requirejs(['/js/init.js'],function(){
       requirejs(['/js/app/Controllers/EventosIndex.js']);
    });
</script>