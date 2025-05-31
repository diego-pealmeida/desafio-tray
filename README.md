# Desafio Técnico PHP Tray

Esse repositório visa armazenar o código referente ao desafio técnico para a vaga de Programado PHP da Tray

## Orientações para uso

Sigua as orientações abaixo para levantar o sistema corretamente!

### Backend

- Acesse a pasta `desafio-tray/backend`
- Faça uma cópia do arquivo `.env.example` para `.env`
- Depois execute `docker compose up -d --build`
- Em seguida execute o comando `docker compose exec app composer install` para instalar todas as dependência do projeto
- Gere uma chave para a placação executando `docker compose exec app php artisan key:generate`
- Execute as migration e seeders necessárias `docker compose exec app php artisan migrate --seed`
- Pronto o sistema já está pronto para uso

### Serviços disponíveis no backend

#### PHP My Admin

Acessando a url `http://localhost:8080` você acessa o painel administrativo do PHP My Admin para poder visualizar o banco de dados sem necessitar de uma instalação a parte. Você pode usar os dados de `DB_USERNAME` e `DB_PASSWORD` como usuário e senha, respectivamente.

#### RedisInsight

Acessando a url `http://localhost:5540` você terá acesso ao painel administrativo para o Redis (RedisInsight).

#### Mailpit

Há um servidor SMTP fake para teste de envio de emails, sem a necessidade de conectar a um SMTP real, para acessálo bata acessar a url `http://localhost:8025`

#### Supervisor

O sistema possui um supervisor entre seus serviços que ficará responsável por executar as filas, assim não será necessário inicia-las manualmente

#### Scheduler

Por alguns probleminha na configuração não foi possível adicionar um serviço que inicie o scheduler automaticamente, então caso queira testar os agendamentos (existem dois para 21:00 UTC) é necessário executar o comando manualmente

```shel
docker compose exec app php artisan schedule:work
```

_*Obs.: O sistema pode ser acessado com um usuário de teste:  email `teste@exemplo.com.br` senha `Mudar@123`*_

**Só vi no final que pode acontecer se dar erro de permissão ao acessar o horizon do container, pelo prazo preferir não focar muito nisso, então peco que se acontecer apenas de um `chmod -R 777` na pasta do backend! Sei que não é a melhor coisa a se fazer, então me perdoe rsrsrs :')**

### Frontend

- Após clonar o repositório basta acessar a pasta `desafio-tray/frontend` e executar o comando `docker compose up -d --build`
- Como isso todas as dependencias devem ser instaladas e será possível acesso o sistema pela url `http://localhost:3000`
