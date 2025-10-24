<?php
// Iniciar a sessão e exibir os dados recebidos via POST 
session_start();

include'config.php';

if(!isset($_SESSION['id_usuario'])){
      header('Location:login.html');
    exit();
}




// Dados recebidos via POST
$data_evento = $_POST['data_evento'];
$descricao  = $_POST['descricao'];
$rua = $_POST['rua'];
$bairro = $_POST['bairro'];
$estado = $_POST['estado'];
$titulo = $_POST['titulo'];
$horas = $_POST['horas'];

if($idSair = $_POST['sair']){
  header('Location: telaOngs.php');
}

$id_ongs = $_SESSION['id_usuario'];
if(!isset($_SESSION['id_usuario'])){
  header('Location:login.html');
}
try{
$sql = "INSERT INTO registrar_eventos (id_ongs, data_evento, descricao ,rua , bairro , estado , titulo, horas) VALUES
(?, ?, ?, ?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("isssssss", $id_ongs, $data_evento, $descricao , $rua, $bairro, $estado, $titulo, $horas);
if($stmt->execute()) {
    header('Location: telaOngs.php');
    echo 'Parabéns Evento Criado';
    exit();
} else {
  $_SESSION['erro_criar'] = "Erro ao criar evento!.";
  header('Location: RegistrarEvento.html');
  exit();
  }
} catch (Exception $e){
error_log($e->getMessage());
 $_SESSION['erro_criar'] = "Erro ao criar evento!.";
  header('Location: RegistrarEvento.html');
  exit();
}

// Fechar conexões
$stmt->close();
$conn->close();
?>