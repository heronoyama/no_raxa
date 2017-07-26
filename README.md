# No Raxa!

For now, just ask me :)

1) Up and running

A partir da pasta 'Docker', docker-compose up :)

2)DB Migrations

Acesse a máquina que está rodando o cake (docker exec -it no_raxa-php-fpm bash)
Acesse a pasta /bin/
Siga [esse tutorial](https://book.cakephp.org/3.0/en/migrations.html)

3)DB para testes
Para rodar os testes, é necessário fazer um 'instala' na base de testes.
Acesse a máquina que está rodando o cake (docker exec -it no_raxa-php-fpm bash)
Acesse a pasta /bin/
Execute './cake migrations migrate -c test'

4) Rodar testes
Acesse a máquina que está rodando o cake (docker exec -it no_raxa-php-fpm bash)
Execute 'php vendor/bin/phpunit'


Heron Oyama
