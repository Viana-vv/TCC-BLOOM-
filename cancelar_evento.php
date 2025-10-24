<?php
// Iniciar a sessão e exibir os dados recebidos via POST 
session_start();


if(!isset($_SESSION['id_usuario'])){
 header('Location:login.html');
  die("Acesso não autorizado. faça Login.");
}
$id_ongs = $_SESSION['id_usuario'];

if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_evento'])){
    $id_evento = $_POST['id_evento'];
    $id_ongs = $_SESSION['id_usuario'];


try{
    $pdo = new PDO('mysql:host=localhost; dbname=bloom;charset=utf8mb4','root',"");
    $pdo->setAttribute (PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $pdo->prepare("SELECT * FROM registrar_eventos WHERE id_evento = ? AND id_ongs = ?");
    $stmt->execute([$id_evento, $id_ongs]);
    if($stmt->rowCount() > 0 ){
        $deleteStmt = $pdo->prepare("DELETE FROM registrar_eventos  WHERE id_evento = ? ");
        $deleteStmt->execute([$id_evento]);
    header('Location: telaOngs.php');
exit();   
}else{
    echo 'Evento não encontrado ou você não pode apagar esse evento';
}
}
catch(PDOException $e){
          
  echo'<div class="navBar">';
  echo '<div class="container text-center mt-4">';
  echo ' <h1>Aconteceu algum erro ao verificar usuario, faça login novamente</h1>';
  echo '<a href="login.html" class="btn" >Sair</a>';
  echo'</div>';
}
}
else{
echo'Requisição Invalida';
}