# API do NewMovies

Uma API RESTful baseada em Laravel para gerenciar contas de usuários e filmes favoritos.

## Requisitos

-   [Docker](https://www.docker.com/get-started)
-   [Docker Compose](https://docs.docker.com/compose/install/)

## Instalação

1. Clone o repositório:

```bash
git clone https://github.com/mrjonas151/filmes-favoritos-back
cd projeto2_jonas_back
```

2. Copie o arquivo de ambiente de exemplo e ajuste conforme necessário:

```bash
cp backend/.env.example backend/.env
```

3. Construa e inicie os containers Docker:

```bash
docker-compose up -d
```

4. Instale as dependências PHP:

```bash
docker-compose exec app composer install
```

5. Gere a chave da aplicação:

```bash
docker-compose exec app php artisan key:generate
```

6. Gere a chave secreta JWT:

```bash
docker-compose exec app php artisan jwt:secret
```

## Configuração do Banco de Dados

A aplicação utiliza SQL Server. O arquivo Docker Compose configura o container do banco de dados com as seguintes credenciais:

-   **Host**: sqlserver
-   **Porta**: 1433
-   **Banco de Dados**: laravel
-   **Usuário**: Seu usuario
-   **Senha**: Sua senha

Essas informações estão configuradas no arquivo `.env`. Caso necessário, atualize tanto o `.env` quanto o `docker-compose.yml`.

## Executando as Migrations

Para configurar o esquema do banco de dados:

```bash
docker-compose exec app php artisan migrate
```

## Endpoints da API

### Autenticação

-   **POST /api/register** - Registrar novo usuário

```json
{
    "name": "Seu Nome",
    "email": "seu.email@example.com",
    "password": "sua_senha"
}
```

-   **POST /api/login** - Fazer login e obter token JWT

```json
{
    "email": "seu.email@example.com",
    "password": "sua_senha"
}
```

### Gerenciamento de Usuários (Requer Autenticação)

-   **GET /api/users** - Buscar perfil do usuário atual
-   **GET /api/users/{id}** - Buscar usuário pelo ID (somente o próprio)
-   **PUT /api/users/{id}** - Atualizar perfil (somente o próprio)
-   **DELETE /api/users/{id}** - Deletar conta (somente o próprio)

### Gerenciamento de Favoritos (Requer Autenticação)

-   **GET /api/favorites** - Buscar todos os filmes favoritos do usuário
-   **GET /api/favorites/{id}** - Buscar um favorito específico pelo ID
-   **POST /api/favorites** - Adicionar um filme aos favoritos

```json
{
    "movie_id": 1,
    "title": "Título do Filme",
    "poster_path": "/caminho/para/poster.jpg",
    "overview": "Descrição do filme...",
    "release_date": "2023-01-01",
    "vote_average": 8.5,
    "genre": "Ação",
    "duration": 120
}
```

-   **DELETE /api/favorites/{id}** - Remover um filme dos favoritos
-   **GET /api/favorites/check/{movieId}** - Verificar se um filme está nos favoritos

## Autenticação

Todos os endpoints protegidos exigem um token JWT válido. Inclua o token no cabeçalho da requisição:

```
Authorization: Bearer seu_token_jwt
```

## Acessando a Aplicação

A API estará disponível em:

```
http://localhost:8000/api
```

## Parando a Aplicação

Para parar os containers Docker:

```bash
docker-compose down
```
