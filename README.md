# DevLog CeoPag

Mini-aplicação de gerenciamento de artigos e desenvolvedores, construída com **Laravel 12 + Livewire** como desafio técnico para a LT Cloud.

🚀 **[Acessar deploy](https://lt-cloude-ceopag-challenge-production.up.railway.app/)**

---

## Funcionalidades

- Autenticação completa (login, registro, reset de senha)
- CRUD de **Desenvolvedores** com campos de nome, e-mail, senioridade (Jr/Pl/Sr) e skills em tags
- CRUD de **Artigos** com título, slug automático, conteúdo, data de publicação e imagem de capa
- Relação **N:N** entre Artigos e Desenvolvedores
- Filtros em tempo real via Livewire (busca, skill, senioridade)
- Isolamento de dados por usuário via **Policies**
- Tema claro/escuro persistente
- Layout responsivo com Bootstrap

---

## Stack

- PHP 8.3 + Laravel 12
- Livewire 4
- Bootstrap 5
- PostgreSQL (produção) / SQLite (local)
- Docker

---

## Instalação

### Pré-requisitos

- Docker e Docker Compose instalados

### Passo a passo

```bash
# 1. Clone o repositório
git clone https://github.com/ppathasbeen21/lt-cloude-ceopag-challenge
cd lt-cloude-ceopag-challenge

# 2. Suba os containers
docker compose up -d

# 3. Instale as dependências PHP
docker compose exec lt-cloud-challenge.local composer install

# 4. Configure o ambiente
docker compose exec lt-cloud-challenge.local cp .env.example .env
docker compose exec lt-cloud-challenge.local php artisan key:generate

# 5. Rode as migrations e seeds
docker compose exec lt-cloud-challenge.local php artisan migrate --seed

# 6. Compile os assets
docker compose exec lt-cloud-challenge.local npm install
docker compose exec lt-cloud-challenge.local npm run build
```

---

## Credenciais demo

| Campo | Valor |
|-------|-------|
| E-mail | `patrick@ceopag.com` |
| Senha | `password` |

---

## Comandos úteis

```bash
# Subir os containers
docker compose up -d

# Derrubar os containers
docker compose down

# Rodar migrations + seeds do zero
docker compose exec lt-cloud-challenge.local php artisan migrate:fresh --seed

# Assets em modo desenvolvimento
docker compose exec lt-cloud-challenge.local npm run dev

# Limpar caches
docker compose exec lt-cloud-challenge.local php artisan cache:clear
docker compose exec lt-cloud-challenge.local php artisan view:clear
```

---

## Diferenciais implementados

- **Factories e Seeders** com Faker para geração de dados fake
- **Policies** garantindo que cada usuário veja apenas seus próprios dados
- **Slug automático** gerado a partir do título do artigo
- **Upload de imagem de capa** com preview e remoção
- **Tema claro/escuro** persistido no localStorage
- **Deploy em produção** no Railway com PostgreSQL e proxy reverso configurado
