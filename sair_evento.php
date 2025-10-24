 <?php
            session_start();
$id_usuario = $_SESSION['id_usuario'];            
if(!isset($_SESSION['id_usuario'])){
header('Location:login.html');
  die("Acesso não autorizado. faça Login.");
}


if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_evento'])){
    $id_evento = $_POST['id_evento'];
    $id_usuario = $_SESSION['id_usuario'];

try{
    $pdo = new PDO('mysql:host=localhost; dbname=bloom;charset=utf8mb4','root',"");
    $pdo->setAttribute (PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $stmt = $pdo->prepare("DELETE FROM evento  WHERE id_evento = ? AND id_usuario =? ");
        $stmt->execute([$id_evento, $id_usuario]);
    header('Location: telaUser.php');
exit();   

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