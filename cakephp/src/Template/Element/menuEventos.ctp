<?php $idEvento = $this->request->session()->read('Evento.id'); ?>

<ul class="side-nav">
    <li class="heading"><i class="fa fa-bars fa-2x"></i> <p>Menu</p> </li>
    <li><?= $this->Html->link(__('Ver Todos Eventos'), ['controller'=>'Eventos','action' => 'index']) ?></li>
    <?php if ($this->request->session()->check('Evento.id')) { ?>
    <li><?= $this->Html->link(__('Dados do Evento'), '/eventos/view/'.$idEvento) ?> </li>
    <li><?= $this->Html->link(__('Consumíveis'), '/eventos/'.$idEvento.'/consumables') ?> </li>
    <li><?= $this->Html->link(__('Participantes'), '/eventos/'.$idEvento.'/participantes') ?> </li>
    <li><?= $this->Html->link(__('Colaborações'), '/eventos/'.$idEvento.'/collaborations') ?> </li>
    <li><?= $this->Html->link(__('Consumos'), '/eventos/'.$idEvento.'/consumptions') ?> </li>
    <li><?= $this->Html->link(__('Divisor de Despesas'), '/eventos/'.$idEvento.'/divisorDespesas') ?> </li>
    <?php } ?>
</ul>