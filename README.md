# Laravel Sail README

Este arquivo README fornece instruções passo a passo sobre como configurar e executar uma aplicação Laravel usando Laravel Sail. Laravel Sail é um ambiente de desenvolvimento para Laravel baseado em contêineres Docker.

## Pré-requisitos

Certifique-se de ter o Docker e o Docker Compose instalados no seu sistema antes de prosseguir.

- Docker: [Instalação do Docker](https://docs.docker.com/get-docker/)
- Docker Compose: [Instalação do Docker Compose](https://docs.docker.com/compose/install/)

## Configuração Inicial

1. Clone o repositório da sua aplicação Laravel:

```bash
git clone <URL_DO_SEU_REPOSITORIO>
cd <NOME_DO_SEU_PROJETO>
```

2. Copie o arquivo .env.example para .env:

```bash
cp .env.example .env
```

3- Configure as variáveis de ambiente no arquivo .env conforme necessário, especialmente as relacionadas ao banco de dados.

## Inicializando o Laravel Sail

1- Execute o seguinte comando para buildar e criar o ambiente Sail:

```bash
./vendor/bin/sail build
./vendor/bin/sail up -d
```

## Configurando o banco de dados

1- Execute as migrations para criar as tabelas do banco de dados e as seeders para popular o banco:

```bash
./vendor/bin/sail artisan migrate
./vendor/bin/sail artisan db:seed
```

## Rodando os testes

1- Utilize o seguinte comando para rodar os testes: 

```bash
./vendor/bin/sail artisan test
```

## Acessando a Aplicação

1- Abra seu navegador e acesse http://localhost para ver sua aplicação Laravel em execução.


## Importando em massa

Para realizar a importacao é necessario que esteja com a fila funcionando, para isso rode o seguinte comando: 

```bash
./vendor/bin/sail artisan queue:work
```
A rota de importacao exige que esteja autenticado para que seja possivel mandar os resultados da importacao por email da pessoa que chamou a requisicao. Para isso, tem um user de teste com email "teste@example.com"e senha "qweqwe123".

Após isso, acesse a rota de importacao com o usuario autenticado e envie o arquivo import.csv localizado na pasta raiz. Os Jobs irao rodar e ao final sera enviado um email para esse usuario autenticado, avisando sobre o status da importacao.
