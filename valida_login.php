<?php

session_start();
include'config.php';
// Criar conexão entre PHP e MySQL 
$conn = new mysqli($servidor, $dbnome, $password, $db);

if ($conn->connect_error) {
    die(json_encode(["message" => "Erro na conexão com o banco"]));
}

$email = $_POST['email'] ??'';
$senha = $_POST['senha'] ??''; 

function salvaLogin($conn,$id_usuario, $tipo_usuario, $email){
    
  $id_ongs = ($tipo_usuario =='ongs') ? $id_usuario : NULL;
$id_adm = ($tipo_usuario =='adm') ? $id_usuario : NULL;
$id_user = ($tipo_usuario =='usuario') ? $id_usuario : NULL;

if($tipo_usuario == 'usuario' ){
$query_delete = "DELETE FROM login WHERE id_login  = (
SELECT id_login FROM(
SELECT id_login FROM login WHERE id_usuario = ? ORDER BY data_login ASC LIMIT 1)
AS temp_table
)";

$stmt_delete = $conn->prepare($query_delete);
$stmt_delete->bind_param("i", $id_usuario);
$stmt_delete->execute();

}elseif($tipo_usuario == 'ongs' ){
$query_delete = "DELETE FROM login WHERE id_login  = (
SELECT id_login FROM(
SELECT id_login FROM login WHERE id_ongs = ? ORDER BY data_login ASC LIMIT 1)
AS temp_table
)";

$stmt_delete = $conn->prepare($query_delete);
$stmt_delete->bind_param("i", $id_ongs);
$stmt_delete->execute();

}elseif($tipo_usuario == 'adm' ){
$query_delete = "DELETE FROM login WHERE id_login  = (
SELECT id_login FROM(
SELECT id_login FROM login WHERE id_adm = ? ORDER BY data_login ASC LIMIT 1)
AS temp_table
)";
$stmt_delete = $conn->prepare($query_delete);
$stmt_delete->bind_param("i", $id_adm);
$stmt_delete->execute();
}


    $query_insert = "INSERT INTO login (id_usuario, id_ongs, id_adm, email ) VALUES (?,?,?,?)";
    $stmt_insert = $conn->prepare($query_insert);

$id_ongs = ($tipo_usuario =='ongs') ? $id_usuario : NULL;
$id_adm = ($tipo_usuario =='adm') ? $id_usuario : NULL;
$id_user = ($tipo_usuario =='usuario') ? $id_usuario : NULL;

$stmt_insert->bind_param("iiis",$id_user,$id_ongs,$id_adm, $email );
$stmt_insert->execute();
}

$query = "SELECT id_adm, senha, email FROM adm WHERE email = ?";

$stmt = $conn->prepare($query);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();
$dados = $result->fetch_assoc();
if ($dados && password_verify($senha, $dados['senha'])) {
     $_SESSION['id_usuario'] = $dados['id_adm'];
$_SESSION['tipo_usuario'] = 'adm';
   salvaLogin($conn , $dados['id_adm'], 'adm', $email);
    
    header("Location: adm.php");
    exit();
}


$query = "SELECT id_ongs, senha, email FROM ongs WHERE email = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();
$dados = $result->fetch_assoc();
if ($dados && password_verify($senha, $dados['senha'])) {
  $_SESSION['id_usuario'] = $dados['id_ongs'];
$_SESSION['tipo_usuario'] = 'ongs';
salvaLogin($conn,$dados['id_ongs'],'ongs', $email);
    
    header("Location: telaOngs.php");
    exit();
}

$query = "SELECT id_usuario, senha, email FROM usuarios WHERE email = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();
$dados = $result->fetch_assoc();
if ($dados && password_verify($senha, $dados['senha'])) {
   $_SESSION['id_usuario'] = $dados['id_usuario'];
$_SESSION['tipo_usuario'] = 'usuario';
salvaLogin($conn,$dados['id_usuario'],'usuario', $email);
    
    header("Location: telaUser.php");
    exit();
}

$_SESSION['erro_login'] = "Email ou senha incorretos";
header("Location: login.html");
exit();



?>