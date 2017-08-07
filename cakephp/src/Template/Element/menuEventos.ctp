<?php $idEvento = $this->request->session()->read('Evento.id'); ?>

<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Ver Todos Eventos'), ['controller'=>'Eventos','action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('Dados do Evento'), '/eventos/view/'.$idEvento) ?> </li>
        <li><?= $this->Html->link(__('Consumíveis'), '/eventos/'.$idEvento.'/consumables') ?> </li>
        <li><?= $this->Html->link(__('Participantes'), '/eventos/'.$idEvento.'/participantes') ?> </li>
        <li><?= $this->Html->link(__('Colaborações'), '/eventos/'.$idEvento.'/collaborations') ?> </li>
        <li><?= $this->Html->link(__('Consumos'), '/eventos/'.$idEvento.'/consumptions') ?> </li>
    </ul>
</nav>