        <?php
            session_start();
header("Cache-Control: no-cache, must-revalidate");
header("Pragma: no-cache");

            $id_usuario = $_SESSION['id_usuario'];            
if(!isset($_SESSION['id_usuario'])){
header('Location:login.html');
  die("Acesso não autorizado. faça Login.");
}

try{
    $pdo = new PDO('mysql:host=localhost; dbname=bloom;charset=utf8mb4','root',"");
    $pdo->setAttribute (PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql="SELECT re.titulo, re.descricao, re.data_evento, re.rua, re.bairro, re.estado, re.id_evento
    FROM evento e
    JOIN registrar_eventos re ON e.id_evento = re.id_evento
    WHERE e.id_usuario = ?
    ";
$stmt = $pdo->prepare($sql);
$stmt->execute([$id_usuario]);
$eventos = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="tccestilo/estiloTelainicial.css">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">
      <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
   
   <link rel="icon" href="imgtcc/pet.jpeg">
    
    <title>Eventos participando Bloom</title>
</head>
<style>

.caixabtn{
    display: flex;
    width: 100%;
    justify-content:center;
    align-items:center;
    margin-top:20px;
    margin-left:10px
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
    width: 200px;

}

.btn:hover{
  color: #dce2b3;
  background-color:rgb(49, 6, 6);
}
h1{
    background-color:rgb(0, 0, 0);
        color:rgb(26, 188, 1);
}

button.comentarios{
  margin-bottom: 5px;
    width: auto;
    height: auto;
 font-size: 40px;
    border-radius: 20px;
    cursor: pointer;
    background-color: #ffffff;
    color: #128700;
    margin-bottom: 10px;
    border: none;
}

.comentarios:hover{
    background-color: #dce2b3;
    color: #412323;
 
}
@media(max-width:900px;){
   .btn{
        bottom: 10px;
      background-color:rgb(255, 0, 0);   
   color:rgb(255, 255, 255);
    font-weight: 500;
    
    display:flex;
justify-content:center ;
    text-transform: capitalize;
    text-decoration: none;
    margin-bottom: 10px;
    transition: 0.2s ease-out;
    margin-right:10px;
    width: 100%;

}

.btn:hover{
  color: #dce2b3;
  background-color:rgb(49, 6, 6);
}

}

</style>
<body>
    <div class="container text-center mt-4">
    <h1>Eventos que você está participando:</h1>
    <div class="row align-items-center">
  
   <?php
if($eventos){
    foreach($eventos as $evento){
    
 echo '<div class="col-md-4">';
          echo '<div class="card mb-3 " style="width: 18rem;">';
          echo '<div class="card-body">📌';
          echo '<h5 class="card-title">Evento: ' . $evento["titulo"] . '</h5>';
          echo '<p class="card-text"><strong>Rua: </strong>' . $evento["rua"] . '</p>';
          echo '<p class="card-text"><strong>Bairro: </strong>' . $evento["bairro"] . '</p>';
          echo '<p class="card-text"><strong>Estado: </strong>' . $evento["estado"] . '</p>';
               echo '<p class="card-text"><strong>Data: </strong>' . $evento["data_evento"] . '</p>';
               ?>
                 <div style="
    height: auto;
    display: flex;
    align-items: center;
    justify-content: center;">
                                <form action="comentarios.php" method="POST">
                                    <?php
                                echo '<input type="hidden" name="id_evento" value="' .  $evento['id_evento'] . '">';
                                ?>
                                <button class="comentarios" type="submit"><i class="bi bi-chat-dots-fill"></i></button> 
                                </form>
                                </div>
                                <?php 
               echo '  <form id="formSair" method="post" action="sair_evento.php" onsubmit="return confirm(\'Tem certeza que deseja sair do evento?\')">';
        echo '      <input type="hidden" name="id_evento" value="'. htmlspecialchars($evento['id_evento']) .'">';
     echo '   <button style="margin-left: 60px;" type="submit" class="btn btn-danger" alt="Botão para sair do evento">Sair do evento</button>';
        echo ' </form>';

          echo '</div>'; 
          echo '</div>'; 
          echo '</div>'; 

    }
}else{
         echo '<p class="text-center">Nenhum evento encontrado. </p>'; 
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
  <form  action="validarSairBtnOngs.php">
  <div class="caixabtn">  
    <button type="submit" class="btn">Voltar</button>    
  </div>
       </form>
    </body>
</html>
