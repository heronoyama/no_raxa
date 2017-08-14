<div class="users form">

<?= $this->Form->create() ?>
<?= $this->Form->control('email') ?>
<?= $this->Form->control('password') ?>
<p class='forgot'>
    <?php echo $this->Html->link('Equeci minha senha', ['controller'=>'Users','action'=>'requestNewPassword'],[]) ?>
</p>
<?= $this->Form->button('Login',['class'=>'button button-block']); ?>
<?= $this->Form->end() ?>

<?php echo $this->Html->link('Entre com o Facebook', '/loginfacebook', ['class' =>'button social-button']) ?>
<?php echo $this->Html->link('Entre com o Google', '/logingoogle', ['class' =>'button social-button']) ?>
</div>