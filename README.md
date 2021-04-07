# Wallet

### Etapas para configuração do projeto

Environment
```bash
cp .env.exemple .env
```

Construir projeto

```bash
make build
```

Levantar aplicação na porta :8000

```bash
make up
```

Executar os testes unitários/integração gerando cobertura de código `/coverage`

```bash
make test
```

Instalar hooks pre-push

```bash
make install-hooks
```

Documentação Postman do projeto

- [Postman Collection](https://github.com/hugobandeira/wallet/Wallet.postman_collection.json)
