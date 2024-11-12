<?php

function getConnection()
{

  $host = '127.0.0.1';
  $dbname = 'test_database';
  $username = 'user';
  $password = 'passsword';

  try {
    $dsn = "mysql:host=$host;dbname=$dbname;charset=utf8mb4";

    $pdo = new PDO($dsn, $username, $password);

    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    return $pdo;
  } catch (PDOException $e) {
    echo "Erro na conexão: " . $e->getMessage();
  }
}
