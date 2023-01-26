Pullay Database
===============

Lite Query Builder for PHP

[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg)](LICENSE)
[![Packagist](https://img.shields.io/packagist/dt/pullay/database)](https://packagist.org/packages/pullay/database)

## Installation

```
composer require pullay/database dev-master
```

## Get starting

```
use Pullay\Database\Driver\Mysql;
use Pullay\Database\Connection;

$driver = Mysql::connect('localhost', 'test', 'user', 'password');
$connection = new Connection($driver);
$query = $connection->getQueryBuilder()
    ->select('user')
    ->where(['id' => 1])
    ->limit(1);

$row = $query->fethOne();
```

## CRUD Query

## Insert

```
$values = ['username' => 'alex', 'password' => 'qwerty'];
$query = $connection->getQueryBuilder()
    ->into('user')
    ->values($values);
$lastInsertId = $query->execute();
```

## Select

```
$query = $connection->getQueryBuilder()
    ->select('user')
    ->where(['id' => 1])
    ->limit(1);

// fetch
$row = $query->fetch();

// fetch all
$rows = $query->fetchAll();

// or
foreach ($query as $row) {
    echo $row['username'];
}

// count
$count = $query->count();
```

## Where conditions

## Join table

## Update

```
$query = $connection->getQueryBuilder()
    ->update('user')
    ->set('username', 'bob')
    ->where(['id' => 1]);
$rowCount = $query->execute();

```

## Delete

```
$query = $connection->getQueryBuilder()
    ->delete('user')
    ->where(['id' => 1]);
$rowCount = $query->execute();
```
