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

    <?= $this->Html->script('vendor/jquery.js')?>
    <?= $this->Html->script('vendor/jquery-ui.min.js')?>
    <?= $this->Html->script('vendor/require.js')?>


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
   
    

</body>
</html>
