<?php 
session_start();
header("Cache-Control: no-cache, must-revalidate");
header("Pragma: no-cache");


if(!isset($_SESSION['id_usuario'])){
    header('Location:login.html');
    exit();
}

$id_ongs = $_SESSION['id_usuario'];
if(!isset($_SESSION['id_usuario'])){
  header('Location:login.html');
  die("Acesso não autorizado. faça Login.");
}
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="tccestilo/estiloTelainicial.css">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">
   <link rel="icon" href="imgtcc/pet.jpeg">
    
    <title>Eventos e Participantes</title>
</head>
<style>

.caixabtn{
    display: flex;
    width: 100%;
    justify-content:center;
    align-items:center;
    margin-top:20px
}

     .btn{
        bottom: 10px;
      background-color:rgb(255, 0, 0);   
   color:rgb(255, 255, 255);
    font-weight: 500;
    padding: 5px 0;
    display:flex;
justify-content:center ;
    text-transform: capitalize;
    text-decoration: none;
    margin-bottom: 10px;
    transition: 0.2s ease-out;
    width: 400px;

}

.btn:hover{
  color: #dce2b3;
  background-color:rgb(49, 6, 6);
}
h1{
    display:flex;
    justify-content:center;
    align-items:center;
    background-color:rgb(0, 0, 0);
       color:rgb(118, 254, 68);
}
.card-body{
    overflow:auto;
}

</style>
<body>
    <h1>Eventos e Participantes</h1>
<?php

try{
    $pdo = new PDO('mysql:host=localhost; dbname=bloom;charset=utf8mb4','root',"");
    $pdo->setAttribute (PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql="SELECT re.titulo, e.data_registro, u.nome, u.email, u.telefone
    FROM usuarios u
    JOIN  evento e ON u.id_usuario = u.id_usuario
    JOIN registrar_eventos re ON e.id_evento = re.id_evento
    WHERE re.id_ongs = ?
    ";
$stmt = $pdo->prepare($sql);
$stmt->execute([$id_ongs]);
$eventos = $stmt->fetchAll();
?>

   <?php
if($eventos){
$eventosCriados = [];
    foreach($eventos as $evento){
    $chave = $evento['titulo'];
    $eventosCriados[$chave][] = $evento;
    }
   echo '<div class="container mt-4">';
 echo '<div class="row">'; 
foreach($eventosCriados as $titulo =>$participantes){
 echo '<div class="col-md-4">';
 echo '<div class="card mb-3 " style="width: 18rem;">';
  echo '<div class="card-body">';
          echo '<h5 class="card-title">Evento: ' . htmlspecialchars($titulo) . '</h5>';
                  echo '<p class="card-text">';
                  echo '<table class="table table-sm">';
                   echo '<thead><tr>';
   echo ' <th scope="col">#</th>';
      echo ' <th scope="col">Nome</th>';
    echo '<th scope="col">Telefone</th>';
     echo ' <th scope="col">Email</th>';
   echo ' </tr></thead>';
  echo'<tbody>';
  $i = 1;
  foreach($participantes as $p){
    echo'<tr>';
    echo '<th scope="row">' . $i++ . '</th>';
      echo '<td>' . $p["nome"] . '</td>';
     echo ' <td>' . $p["telefone"] . '</td>';
      echo '<td>' . $p["email"] . '</td>';
echo '</tr>';
  }
 echo '</tbody>';
echo '</table>';
echo '</p>';

          echo '</div>'; 
          echo '</div>'; 
          echo '</div>'; 

}      echo '</div>'; 
          echo '</div>'; 

}else{
         echo '<p class="text-center">Nenhuma pessoa ainda se inscreveu nos seus eventos. </p>'; 
}
}catch(PDOException $e){
          
  echo'<div class="navBar">';
  echo '<div class="container text-center mt-4">';
  echo ' <h1>Aconteceu algum erro ao verificar usuario, faça login novamente</h1>';
  echo '<a href="login.html" class="btn" >Sair</a>';
  echo'</div>';
 
}
  ?>
  </div>
  <div class="caixabtn">  <a href="telaOngs.php" class="btn" >Voltar</a>
      </div>
       
    </body>
</html>
