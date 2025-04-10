<p align="center">
  <a href="https://laravel.com" target="_blank">
    <img src="./image.png" width="400" alt="Laravel Logo">
  </a>
</p>

<p align="center">
  <a href="https://github.com/laravel/framework/actions">
    <img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status">
  </a>
  <a href="https://packagist.org/packages/laravel/framework">
    <img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads">
  </a>
  <a href="https://packagist.org/packages/laravel/framework">
    <img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version">
  </a>
  <a href="https://packagist.org/packages/laravel/framework">
    <img src="https://img.shields.io/packagist/l/laravel/framework" alt="License">
  </a>
</p>

---

# Laravel Project Setup Guide

Este projeto Laravel vem com uma estrutura completa, banco de dados Dockerizado e testes automatizados. Siga o passo a passo abaixo para colocar tudo no ar rapidamente.

---

## ✨ Primeiros Passos

**1.** Instale as dependências do Laravel:

> composer install

**2.** Instale as dependências do Node:

> npm install

**3.** Renomeie o arquivo `.env.example` para `.env`

---

## ⚙️ Configurações Iniciais

**4.** Gere a chave da aplicação:

> php artisan key:generate

**5.** Rode as migrations:

> php artisan migrate  
> php artisan migrate --env=testing

---

## 🚣 Docker

**6.** Suba os containers:

> docker-compose up -d --build

Você terá:
- Um container do **PostgreSQL**
- Um painel **PgAdmin4** para administrar o banco

---

## 📂 Acessando o Banco de Dados

### Via Navegador (PgAdmin4)

**7.** Acesse: [http://localhost:8080](http://localhost:8080)  
**Usuário:** root@gmail.com  
**Senha:** root

### Via Terminal

> docker exec -it postgres_laravel psql -U root -d laravel  
> \dt *(para listar as tabelas)*

---

## 🔧 Configuração do PgAdmin (opcional)

**8.** Caso opte por usar o PgAdmin:

- Clique com o botão direito em cima de "Servers" > Registrar > Servidor
- Aba **Geral**: Nome = `laravel`
- Aba **Conexão**:
  - Host name/address = `postgres`
  - Senha = `root`
  - Marque a opção "Salvar senha"
- Clique em **Salvar**

---

## 🚀 Executando o Projeto

**9.** Inicie o servidor:

> php artisan serve

Acesse a aplicação em: [http://127.0.0.1:8000](http://127.0.0.1:8000)

---

## 📃 Endpoints Disponíveis (CRUD - Places)

- **POST** `/api/place/create` — Cria um local
- **GET** `/api/place/places` — Lista todos os locais
- **PUT** `/api/place/edit/{placeID}` — Edita um local
- **DELETE** `/api/place/delete/{placeID}` — Remove um local

---

## 📊 Testes com Insomnia

**10.** Importar a coleção `Laravel12-ProjectAPI.yaml` que está na raiz do projeto no **Insomnia** para testar todos os endpoints.

---

## 🌟 Testes Unitários

**11.** Execute os testes do módulo `place` com:

> php artisan test --group=place

---

Tudo pronto! Agora é só codar ✨