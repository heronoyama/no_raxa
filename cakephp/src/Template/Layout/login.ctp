<!DOCTYPE html>
<html>
<head>
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        No Raxa
        <?= $this->fetch('title') ?>
    </title>
    <?= $this->Html->meta('icon') ?>

    <?= $this->Html->css('base.css') ?>
    <?= $this->Html->css('cake.css') ?>
    <?= $this->Html->css('vendor/jquery-ui.css') ?>
    <?= $this->Html->css('custom.css') ?>

    <?= $this->Html->script('vendor/jquery.js')?>
    <?= $this->Html->script('vendor/jquery-ui.min.js')?>
    <?= $this->Html->script('vendor/require.js')?>


    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>
    <?= $this->fetch('script') ?>
</head>
<body class="login">
    <div class="container clearfix" id="container">
    <div class='login'>
    <ul class='loginController'>
        <li <?=$this->login->cssLogin()?>>
            <?= $this->Html->link("Login",['controller'=>'Users','action'=>'login'])?>
        </li>
        <li <?=$this->login->cssRegister()?>>
            <?= $this->Html->link("Registrar",['controller'=>'Users','action'=>'add'])?>
        </li>
    </ul>
        <?= $this->Flash->render() ?>
        <?= $this->fetch('content') ?>
    
    </div>
   
    </div>

</body>
</html>
