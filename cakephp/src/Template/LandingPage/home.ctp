<?php
$this->layout = false;
?>
<!DOCTYPE html>
<html>
<head>
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        No Raxa!
    </title>

    <?= $this->Html->meta('icon') ?>
    <?= $this->Html->css('base.css') ?>
    <?= $this->Html->css('cake.css') ?>
    <?= $this->Html->css('home.css') ?>
    <?= $this->Html->css('landingPage.css') ?>
    <?= $this->Html->css("vendor/font-awesome.css")?>
    <link href="https://fonts.googleapis.com/css?family=Raleway:500i|Roboto:300,400,700|Roboto+Mono" rel="stylesheet">

    <?= $this->Html->script('vendor/scroll.js')?>
    <?= $this->fetch('script') ?>
</head>
<body class="home">

<header>
    <div class='logo'>
        <i class='fa fa-calculator fa-fw'></i>
    </div>
    <nav class="menu">
        <ul>
            <li> <a class='button scroll'  href="#banner"> Home </a> </li>
            <li> <a class='button scroll'  href="#about"> Sobre  </a></li>
            <li> <a class='button scroll'  href="#contato"> Contato </a> </li>
            <li> <a class='button' href="/users/login"> Entrar </a> </li>
        </ul>
    </nav>
</header>

<div class='body'>
    <div id='flash'>
        <?=$this->Flash->render()?>
    </div>
    <section id='banner'>  
            <h1>No Raxa!</h1>
            <div>
            <a class='button' href="/users/login">Acesse! </a>
            <?php echo $this->Html->link('Entre com o Facebook', '/loginfacebook', ['class' =>'loginBtn loginBtn--facebook']) ?>
            <?php echo $this->Html->link('Entre com o Google', '/logingoogle', ['class' =>'loginBtn loginBtn--google']) ?>
            </div>
    </section>

    <section id='about'> 
        <div class='box'>
            <div class='info fleft'>
                <h2> O que é? </h2>
                <p> O No Raxa é um sistema para te facilitar a gerenciar as despesas
                    de seu evento, principalmente quando for um evento colaborativo, ou seja, "no raxa".
                </p>
                <p> Ao cadastrar um novo evento, você poderá preencher: Quem participou, o que foi consumido e, principalmente, 
                    a relação de quem pagou pelos recursos e quem efetivamente consumiu os recursos.
                </p>
                <p>
                    Desse modo, você poderá saber exatamente quanto que deve cobrar daquele colega que bebeu todas, e daquele colega que não bebeu nada,
                    pois os valores serão calculados de forma justa - Só paga por algo aqueles que consumiram!.
                </p>
                <p>
                    Após cadastras os dados do evento, você poderá retirar diversos relatóriso mostrando o valor final da divisão de despesas,
                    além de verificar quais foram as informaçẽos usadas pelo sistema para chegar aquele valor, assim, todos que participaram poderão ver o quanto foi gasto.
                </p>
                <p> <b> TODO melhorar texto!</b></p>
            </div>
            <div class='iconHome fright'>
                <i class='fa fa-exclamation fa-fw extra-large'></i>
            </div>
        </div>
    </section>
    <section id='contato'> 
        <div class='box'>
            <div class='iconHome fleft'>
                <i class='fa fa-envelope-o fa-fw extra-large'></i>
            </div>
            <div class='info fright'>
                <h2> Contate-nos !</h2>
                <?php 
                echo $this->Form->create(null,['url'=>['controller'=>'LandingPage','action'=>'contact']]);
                echo $this->Form->control('email',['required'=>true]);
                echo $this->Form->control('body',['type'=>'textArea','required'=>true]);
                echo $this->Form->button('Submit');
                echo $this->Form->end();
                ?>
            </div>
        </div>

    </section>
</div>

<footer class='footer'>
    <p> Um produto Agile Devs</p>
    <p> Conheça nosso <a href='http://agiledevs.com.br'> site</a> </p>
</footer>
</body>
</html>