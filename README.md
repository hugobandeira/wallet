# Wallet

### Etapas para configuração do projeto

Environment

```bash
cp .env.example .env
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

Executar migrations e seeds

```bash
make seed
```

Instalar hooks pre-push

```bash
make install-hooks
```

Documentação Postman do projeto

- [Postman Collection](https://github.com/hugobandeira/wallet/blob/master/Wallet.postman_collection.json)

![alt text](https://github.com/hugobandeira/wallet/blob/master/img.png)
