<div class="users form">
<?= $this->Flash->render() ?>
<?= $this->Form->create() ?>
    <fieldset>
        <legend><?= __('Please enter your email and password') ?></legend>
        <?= $this->Form->control('email') ?>
        <?= $this->Form->control('password') ?>
    </fieldset>
<?= $this->Form->button(__('Login')); ?>
<?= $this->Form->end() ?>

<?php //echo $this->Html->link('Entre com o Facebook', '/loginfacebook', ['class' =>'button']) ?>
<?php echo $this->Html->link('Entre com o Google', '/logingoogle', ['class' =>'button']) ?>
</div>