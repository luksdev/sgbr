## Places API

Este projeto é uma API RESTful para gerenciar locais. Ele permite criar, listar, atualizar e deletar locais.

## Configurar o Ambiente

### Requisitos

-   [PHP](https://www.php.net/downloads.php) >= 8.1
-   [Composer](https://getcomposer.org/)
-   [Docker](https://www.docker.com/)
-   [Docker Compose](https://docs.docker.com/compose/)
-   [Git](https://git-scm.com/)
-   [Postman](https://www.postman.com/)

### Instalação

1. Clone o repositório

```sh
git clone https://github.com/luksdev/sgbr.git
```

2. Instale as dependências

```sh
composer install
```

3. Copie o arquivo .env.example para .env

```sh
cp .env.example .env
```

4. Gere a chave da aplicação

```sh
php artisan key:generate
```

5. Inicie os containers

```sh
docker-compose up -d
```

6. Execute as migrations

```sh
docker-compose exec app php artisan migrate
```

7. Execute os testes

```sh
docker-compose exec app php artisan test
```

8. Execute o servidor

```sh
docker-compose exec app php artisan serve --host 0.0.0.0 --port 8000
```

9. Seeders (opcional)

```sh
docker-compose exec app php artisan db:seed --class=PlaceSeeder
```

## Rotas

| Método | Rota                       | Descrição                                                             |
| ------ | -------------------------- | --------------------------------------------------------------------- |
| GET    | /api/places                | Retorna todos os locais cadastrados                                   |
| GET    | /api/places/{id}           | Retorna um local específico                                           |
| POST   | /api/places                | Cria um novo local                                                    |
| PUT    | /api/places/{id}           | Atualiza um local                                                     |
| DELETE | /api/places/{id}           | Deleta um local                                                       |
| GET    | /api/places?name=PlaceName | Retorna todos os locais que contém o nome informado no parâmetro name |

## Postman

Para facilitar o uso da API, foi criado um arquivo de coleção do Postman com todas as rotas. Para importar a coleção, basta clicar no botão abaixo:

[<img src="https://run.pstmn.io/button.svg" alt="Run In Postman" style="width: 128px; height: 32px;">](https://god.gw.postman.com/run-collection/27278226-8704ca2e-a189-43fa-a611-bc70ef31817b?action=collection%2Ffork&source=rip_markdown&collection-url=entityId%3D27278226-8704ca2e-a189-43fa-a611-bc70ef31817b%26entityType%3Dcollection%26workspaceId%3Db11120d6-7c11-4304-bfc2-f070bb01c753)
