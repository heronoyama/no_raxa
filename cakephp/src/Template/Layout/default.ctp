<!DOCTYPE html>
<html>
<head>
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        CakePHP: the rapid development php framework:
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
<body>
    <header class='header'>
        <!-- TODO logo -->
        <ul>
            <li> <?=$this->Html->link("Ver meu perfil",['controller'=>'Users','action'=>'view',$this->request->session()->read("Auth.User.id")])?> </li>
            <li> <?=$this->Html->link("Logout",['controller'=>'Users','action'=>'logout'])?> </li>
        </ul>
    </header>
    <nav class="menu" role="navigation">
        <?php 
            $session = $this->request->session();
            echo $this->element('menuEventos');
        ?>
    </nav>

    <?= $this->Flash->render() ?>
    <div class="container clearfix" id="container">
        <?= $this->fetch('content') ?>
    </div>
</body>
</html>
