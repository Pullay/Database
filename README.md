Pullay Database
===============

Lite Query Builder for PHP

## Installation

```
composer require pullay/database dev-master
```

## Get Starting

```

use Pullay\Database\Connection;

$pdo = new PDO('mysql:dbname=test', 'user', 'password');
$connection = new Connection($pdo);
$query = $connection->getQueryBuilder()
    ->select('user')
    ->where('id = :id', ['id' => 1])
    ->limit(1);
$query->getSql(); // SELECT * FROM user WHERE id = :id LIMIT 1
$query->fetchOne(); // ["id" => 1, "username" => 'user', 'password']
```

## Insert

```
$query = $connection->getQueryBuilder()
    ->insert('user')
    ->values(['username' => 'user', 'password' => 'password'])
    ->execute();
$query->getSql(); // INSERT INTO user (username,password) VALUES (?,?)
$connection->getLastInsertId(); // 1
```

## Update

```
$query = $connection->getQueryBuilder()
    ->update('user')
    ->set(['password' => '123456'])
    ->where('id = :id', ['id' => 1])
    ->execute();
$query->getSql(); // UPDATE user SET password = :password WHERE id = :id
```

## Delete

```
$query = $connection->getQueryBuilder()
    ->delete('user')
    ->where('id = :id', ['id' => 1])
    ->execute();
$query->getSql(); // DELETE FROM user WHERE id = :id
```
