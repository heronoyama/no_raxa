<div class="consumables form large-9 medium-8 columns content">
    <?= $this->Form->create($consumable) ?>
    <fieldset>
        <legend><?= __('Add Consumable') ?></legend>
        <?php
            echo $this->Form->control('nome');
            echo $this->Form->hidden('eventos_id', ['value' => $evento->id]);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
