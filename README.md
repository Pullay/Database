Pullay Database
===============

Lite Query Builder for PHP

[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg)](LICENSE)
[![Packagist](https://img.shields.io/packagist/dt/pullay/database)](https://packagist.org/packages/pullay/database)

## Installation

```
composer require pullay/database dev-master
```

## Get Starting

```

use Pullay\Database\Driver\PdoMysql;
use Pullay\Database\Connection;

$driver = PdoMysql::connection('localhost', 'test', 'user', 'password');
$connection = new Connection($driver);
$lastInsertId = $connection->batchInsert('user', ['username' => 'user', 'password' => 'password']);
```

## Insert

```
$lastInsertId = $connection->getQueryBuilder()
    ->insert('user')
    ->values(['username' => 'user', 'password' => 'password'])
    ->execute();

$query->set('username', 'user')
    ->set('password', 'password');
```

## Select

```
$row = $connection->getQueryBuilder()
    ->select('user')
    ->where('id = :id', ['id' => 1])
    ->limit(1)
    ->fetchOne();

$query = $connection->getQueryBuilder()
    ->select('user');

$rows = $query->fetchAll();

foreach ($query as $row) {
    echo $row['username'];
}

```

## Where conditions

```

$query->where('id = :id', ['id' => 1]);

$query->where('id = :id', ['id' => 1])
    ->andWhere('username = :username', ['username' => 'user']);

$query->where(['id = :id' => ['id' => 1], 'username = :username' => ['username' => 'user']]);
```

```

use Pullay\Database\Query\Predicate\Operator;

$query->where(Operator::equalTo('id', ':id'), ['id' => 1]);
```

## Update

```
$connection->getQueryBuilder()
    ->update('user')
    ->sets(['password' => '123456'])
    ->where('id = :id', ['id' => 1])
    ->execute();

$query->set('password', '123456');
```

## Delete

```
$connection->getQueryBuilder()
    ->delete('user')
    ->where('id = :id', ['id' => 1])
    ->execute();
```
