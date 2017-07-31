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
    <?= $this->Html->css('custom.css') ?>

    <?= $this->Html->script('https://code.jquery.com/jquery-3.2.1.min.js');?>
    
    <?= $this->Html->script('knockout-3.3.0'); ?>
    <?= $this->Html->script('custom-handlers'); ?>


    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>
    <?= $this->fetch('script') ?>
</head>
<body>
    <nav class="top-bar expanded" data-topbar role="navigation">
        <ul class="title-area large-3 medium-4 columns">
            <li class="name">
                <h1><a href=""><?= $this->fetch('title') ?></a></h1>
            </li>
        </ul>
    </nav>
    <?= $this->Flash->render() ?>
    <div class="container clearfix" id="container">
        <?php 
            $session = $this->request->session();
            if($session->check('Evento.id'))
                echo $this->element('menuEventos');
            else
                echo $this->element('menuLateral');

        ?>


        <?= $this->fetch('content') ?>

    </div>
   
    <footer>
    </footer>

</body>
</html>
