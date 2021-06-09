# Multitenancy Extensions
---

[Versão em Inglês](README.md)

Este pacote foi criado para uso com [Spatie's Laravel Multitenancy](https://spatie.be/docs/laravel-multitenancy/v1/introduction).

### Instalação

```shell
composer require rocketslab/laravel-multitenancy-extensions
```

### Configuração

Publicando o arquivo de configuração

```shell
php artisan vendor:publish --provider="RocketsLab\MultitenancyExtensions\MultitenancyExtensionsServiceProvider" --tag="config"
```

### Ativando o banco de dados padrão para o Tenant atual

Por padrão, o pacote **multitenancy** tem uma tarefa para efeutar
a troca do banco de dados em cada requisição. Porém ao fazer isso em
segundo plano (ao criar um novo Tenant), o banco `default` não é
atribuído. E desta forma ao tentar migrar as tabelas e popular o banco
com dados iniciais o novo banco não é encontrado pelo Laravel.

Para resolver isso adicione a tarefa `ActiveDefaultDatabase` no
array de tarefas no arquivo de configuração do `multitenancy` como primeiro
da lista.

```php
    //...
    'switch_tenant_tasks' => [
        \RocketsLab\MultitenancyExtensions\Tasks\ActivateDeafultDatabase::class,
        \Spatie\Multitenancy\Tasks\SwitchTenantDatabaseTask::class,
        // ... other tasks
    ],
    //...
```

### Criando banco de dados de Tenants

Após configurar o `spatie/laravel-tenancy` Tenant model. Você pode ativar
a criação automática do banco de dados. Pra isso, adicione a trait 
`ShoudCreateDatabase` ao seu Tenant model.

### Migração para o banco de dados Landlord

Este pacote vem com um comando para ajudar nas migrations para o
banco de dados **landlord**.

```shell
php artisan landlord:migrate
```

Este comando roda todas as migrations da pasta `database/migrations/landlord` por padrão.
Você pode customizar isso editando a seção `landlord` no arquivo de configuração
`multitenancy-extensions`.

Opcionalmente você pode adicionar a flag `--fresh` para remover todas as tabelas antes de migrar.

----

Created by [@jjsquady - Jorge Gonçalves](https://github.com/jjsquady)

Thanks to [Spatie](https://spatie.be) team.

License MIT
