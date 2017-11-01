<div class="eventos form large-9 medium-8 columns content">
    <?= $this->Form->create($pergunta) ?>
    <fieldset>
        <legend><?= __('Nova Pergunta') ?></legend>
        <?php
            echo $this->Form->control('surveys_id', ['options' => $surveys]);
            echo $this->Form->control('pergunta');
            echo $this->Form->select('tipoResposta',[
                ['value'=>'Booleano','text'=>'Booleano'],
                ['value'=>'Numerico','text'=>'Numerico'],
                ['value'=>'Texto','text'=>'Texto']]);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
