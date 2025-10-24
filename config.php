<?php
$servidor = "localhost";
$dbnome = "root";
$password = "";
$db = "markzen";

// Criar conexão entre PHP e MySQL 
$conn = new mysqli($servidor, $dbnome, $password, $db);

if (!$conn) {
  die("Erro na conexão: " . $conn->connect_error);
}
date_default_timezone_set('America/Sao_paulo');

error_reporting(0);
ini_set('display_errors',0);

mysqli_set_charset($conn,"utf8mb4");


?>