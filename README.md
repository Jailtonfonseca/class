# QuickAd Classified Ads Script

Este repositório contém o script QuickAd para anúncios classificados, configurado para execução em containers Docker com código de compra removido.

## Funcionalidades

- Sistema completo de anúncios classificados
- Interface administrativa
- Suporte a múltiplos idiomas
- Integração com gateways de pagamento
- Sistema de usuários e perfis

## Pré-requisitos

- Docker
- Docker Compose

## Instalação e Execução

1. Clone este repositório:
   ```bash
   git clone <url-do-repositorio>
   cd quickad-docker
   ```

2. Execute os containers:
   ```bash
   docker-compose up --build -d
   ```

3. Acesse a aplicação:
   - Frontend: http://localhost:8000
   - Durante a instalação, siga os passos no navegador

## Configuração do Banco de Dados

O Docker Compose inclui um container MySQL com as seguintes configurações padrão:
- Banco: `quickad`
- Usuário: `quickad`
- Senha: `password`
- Root Password: `rootpassword`

Você pode alterar essas configurações no arquivo `docker-compose.yml`.

## Estrutura do Projeto

- `script/`: Código fonte da aplicação
- `nginx/`: Configuração do Nginx
- `docker-compose.yml`: Configuração dos containers
- `Dockerfile`: Build da aplicação PHP

## Desenvolvimento

Para desenvolvimento, você pode montar volumes para alterações em tempo real:

```yaml
volumes:
  - ./script:/var/www
```

## Suporte

Este script foi modificado para remover verificações de código de compra. Para suporte técnico, consulte a documentação original ou a comunidade.

## Licença

Consulte os termos da licença original do QuickAd.