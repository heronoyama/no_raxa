<?php
use Cake\Cache\Cache;
use Cake\Core\Configure;
use Cake\Core\Plugin;
use Cake\Datasource\ConnectionManager;
use Cake\Error\Debugger;
use Cake\Network\Exception\NotFoundException;

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
</head>
<body class="home">

<header>
    <div class='logo'>
        <i class='fa fa-calculator fa-fw'></i>
    </div>
    <nav class="menu">
        <ul>
            <li> <a class='button' href="#banner"> Home </a> </li>
            <li> <a class='button' href="#about"> Sobre  </a></li>
            <li> <a class='button' href="#contato"> Contato </a> </li>
            <li> <a class='button' href="/users/login"> Entrar </a> </li>
        </ul>
    </nav>
</header>

<div class='body'>
    <section id='banner'>  
            <h1>No Raxa!</h1>
            <a class='button' href="/users/login">Acesse! </a>
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
                <h2> bah </h2>
                <p> Lorem ipsun dolor sit amet</p>
            </div>
        </div>

    </section>
</div>

<footer class='footer'>
</footer>
</body>
</html>
