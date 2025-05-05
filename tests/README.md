# Configuração de Testes

Este projeto utiliza o PHPUnit para testes automatizados com MySQL.

## Configuração do Ambiente de Testes

1. **Criar Banco de Dados de Teste**

   O projeto está configurado para usar o mesmo banco de dados definido no seu ambiente normal, 
   mas com o sufixo "_test" adicionado. Por exemplo, se o banco normal é "projeto", o banco de teste será "projeto_test".

   ```sql
   CREATE DATABASE seu_banco_test;
   ```

2. **Verificar Credenciais**

   As credenciais do banco de dados para os testes são as mesmas do ambiente normal.
   Verifique se está tudo correto no arquivo `.env.testing` (se existir) ou `.env`.

3. **Executar Migrações para o Ambiente de Teste**

   É recomendado executar as migrações no ambiente de teste:

   ```bash
   php artisan migrate:fresh --env=testing
   ```

## Executando os Testes

Para executar todos os testes:

```bash
php artisan test
```

Para executar testes de unidade:

```bash
php artisan test --testsuite=Unit
```

Para executar testes de feature:

```bash
php artisan test --testsuite=Feature
```

Para executar um arquivo específico:

```bash
php artisan test tests/Unit/AuthorTest.php
```

## Estrutura dos Testes

- `tests/Unit/`: Testes unitários (modelos, serviços, etc.)
- `tests/Feature/`: Testes de feature (APIs, controllers, etc.)
- `tests/TestCase.php`: Classe base para todos os testes

## Notas Importantes

1. Os testes de API exigem autenticação, que é feita automaticamente no método `autenticarUsuario()` da classe TestCase.
2. Os testes unitários testam apenas os modelos e seus relacionamentos, sem precisar de autenticação.
3. Os testes usam o trait `RefreshDatabase` para garantir um banco de dados limpo entre os testes.
4. Os testes esperam que as APIs retornem respostas JSON no formato que está implementado nos controllers. 