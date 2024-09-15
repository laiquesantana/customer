# Projeto Yii2 API com Docker

Este projeto é uma API RESTful desenvolvida com o **Yii2 Framework**, contendo autenticação JWT e operações CRUD para clientes e livros. A aplicação é containerizada com Docker, utilizando **Nginx**, **MySQL**, e **Redis**.

---

## Requisitos

Antes de rodar o projeto, é necessário ter instalado:

- **Docker** (versão 24.04 ou superior)
- **Docker Compose** (versão 1.29.0 ou superior)
- **Make** (para rodar comandos via `Makefile`)

---

## Material de apoio
- ** api-tech.postman_collection.json collection postman

## Instalação

### 1. Clone o Repositório

```bash
git clone https://github.com/seu-usuario/seu-repositorio.git
cd seu-repositorio
```

### 2. Arquivo .env
Crie um arquivo .env na raiz do projeto copiado o arquivo .env.example:


## 3 Rodando o projeto
#### 3.1 Build da Imagem:
Execute o comando para construir a imagem Docker:

```bash

make build
```
Ou, caso prefira, use o docker-compose diretamente:

```bash

docker-compose build
```
#### 3.2 Subir os Contêineres:
Suba o ambiente com os serviços definidos no docker-compose:

```bash

make up
```
Ou:

```bash

docker-compose up -d
```

#### 3.3 Execute as migrações para configurar o banco de dados:

Verifique se dependencias estão instaladas corretamente(já é feito no build) entre dentro do container usando make bash
e rode
```bash
make update
```

Para executar as migrações necessárias para preparar o banco de dados, rode o seguinte comando:

```bash

make migrate
```
Ou diretamente com Docker:

```bash

docker exec -it my-api-app php yii migrate --interactive=0
```
### 4    Estrutura do Projeto
Abaixo está uma visão geral da estrutura do projeto:
```

├── adapters/
│   └── ConfigAdapter.php      # Adapta as configurações do .env
│   └── Http/ClientAdapter.php # Adapta a biblioteca Guzzle para fazer requisições HTTP
├── core/
│   └── Modules/
│       └── Book/
│           └── Create/        # Módulo de criação de livros
│           └── List/          # Módulo de listagem de livros
│       └── Customer/          # Módulo de clientes
│       └── Generics/          # Módulo de componentes genericos
│       └── Login/             # Módulo de Autenticação
├── controllers/
│   └── BookController.php     # Controlador para API de livros
│   └── CustomerController.php # Controlador para API de clientes
├── models/
│   └── Book.php               # Model de livro
│   └── Customer.php           # Model de cliente
```
### 5   Apis

## Autenticação:
Parâmetros:
username (string) - Nome de usuário
password (string) - Senha

Exemplo de requisição:
```bash

curl -X POST http://localhost:8080/login \
-H "Content-Type: application/json" \
-d '{"username": "laiquesantana", "password": "1234"}'
```
```bash
Exemplo de resposta:
{
    "status": 200,
    "message": "Login successful",
    "data": {
        "token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9...",
        "expires_in": 3600
    },
    "error": "",
    "meta": []
}
```

## Cadastro de Livros:
Parâmetros:
isbn (string) - ISBN do livro
title (string) - Título do livro
author (string) - Autor do livro
price (float) - Preço do livro
stock (int) - Quantidade de estoque

Exemplo de requisição:
```bash
curl -X POST http://localhost:8080/book \
-H "Authorization: Bearer <token>" \
-H "Content-Type: application/json" \
-d '{"isbn": "9788535902777", "title": "Clean Code", "author": "Robert C. Martin", "price": 45.99, "stock": 100}'
```
```bash
Exemplo de resposta:
{
    "status": 201,
    "message": "Book created successfully",
    "data": [
        {
            "id": 8,
            "isbn": "9788535902777",
            "title": "Clean Code",
            "author": "Robert C. Martin",
            "price": "45.99",
            "stock": 100
        }
    ],
    "error": "",
    "meta": []
}

```

## Listagem de Livros:
Parâmetros:
limit (int) - Quantidade de itens por página
offset (int) - Número de itens a serem ignorados para paginação

Exemplo de requisição:
```bash
curl -X GET "http://localhost:8080/book?limit=10&offset=0" \
-H "Authorization: Bearer <token>"
```
```bash
Exemplo de resposta:
{
    "status": 200,
    "message": "Books retrieved successfully",
    "data": [
        {
            "id": 1,
            "isbn": "9788535902777",
            "title": "Clean Code",
            "author": "Robert C. Martin",
            "price": "45.99",
            "stock": 100
        }
    ],
    "error": "",
    "meta": {
        "total": 1
    }
}

```

## Cadastro de Clientes:
Parâmetros:
name (string) - Nome do cliente
cpf (string) - CPF do cliente
cep (string) - CEP do cliente
address (string) - Endereço do cliente
number (int) - Número do endereço
city (string) - Cidade
state (string) - Estado
gender (string) - Gênero ("M" para masculino, "F" para feminino)

Exemplo de requisição:
```bash
curl -X POST http://localhost:8080/customer \
-H "Authorization: Bearer <token>" \
-H "Content-Type: application/json" \
-d '{
"name": "John Doe",
"cpf": "87305291587",
"cep": "40231230",
"address": "Rua do Trilho",
"number": 123,
"city": "Salvador",
"state": "BA",
"gender": "M"
"image": (Upload File)
}'
```
```bash
Exemplo de resposta:
{  
    "status": 201,  
    "message": "Customer created successfully",  
    "data": [  
        {  
            "id": 8,  
            "name": "John Doe",  
            "cpf": "87305291587",  
            "cep": "40231230",  
            "address": "Rua do Trilho",  
            "number": 123,  
            "city": "Salvador",  
            "state": "BA",  
            "complement": "Apartment 12",  
            "gender": "M"  
        }  
    ],  
    "error": "",  
    "meta": []  
}  

```

## Listagem de Clientes:
Parâmetros:
limit (int) - Quantidade de itens por página
offset (int) - Número de itens a serem ignorados para paginação

Exemplo de requisição:
```bash
curl -X GET "http://localhost:8080/customer?limit=10&offset=0" \
-H "Authorization: Bearer <token>"
```
```bash
Exemplo de resposta:
{
  "status": 200,
  "message": "Customers retrieved successfully",
  "data": [
    {
      "id": 1,
      "name": "John Doe",
      "cpf": "87305291587",
      "cep": "40231230",
      "address": "Rua do Trilho",
      "number": 123,
      "city": "Salvador",
      "state": "BA",
      "gender": "M"
    }
  ],
  "error": "",
  "meta": {
    "total": 1
  }
}

```