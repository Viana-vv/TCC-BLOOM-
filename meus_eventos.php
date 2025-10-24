<?php
// Iniciar a sessão e exibir os dados recebidos via POST 
session_start();
include'config.php';

if(!isset($_SESSION['id_usuario'])){
      header('Location:login.html');
    exit();
}
$id_ongs = $_SESSION['id_usuario'];



$sql = " SELECT * FROM registrar_Eventos WHERE id_ongs = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id_ongs);
$stmt->execute();
$result = $stmt->get_result();


?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title> Ongs Bloom </title>
     <link rel="stylesheet" href="tccestilo/estiloTelainicial.css">
     <link rel="icon" href="imgtcc/pet.jpeg">
         <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">
</head>
<style>
  body{
    display:flex;
    flex-direction:column;
    justify-content:center;
    align-items:center;
  }

.btn{
  margin-bottom: 5px;
   margin-top: 10px;
    width: 350px;
    height: 50px;
 font-size: large;
    border-radius: 20px;
    cursor: pointer;
    background-color:rgb(255, 0, 0);
    color:rgb(215, 201, 201);
}

.btn:hover{
    background-color: #dce2b3;
    color: #234124;
}
h1{
    background-color:rgb(0, 0, 0);
     color:rgb(118, 254, 68);
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
</style>
<body>
  
  <div class="container text-center mt-4">
    <h1>Seus eventos registrados </h1>
    <div class="row align-items-center">
      <?php
      if($result->num_rows > 0){
        while($row = $result->fetch_assoc()){
          echo '<div class="col-md-4">';
          echo '<div class="card mb-3 " style"width: 18rem;">';
          echo '<div class="card-body">📌';
          echo '<h5 class="card-title"> Evento: ' . $row["titulo"] . '</h5>';
          echo '<p class="card-text">' .$row["descricao"] . '</p>';
          echo '<p class="card-text"><strong>Rua: </strong>' . $row["rua"] . '</p>';
          echo '<p class="card-text"><strong>Bairro: </strong>' . $row["bairro"] . '</p>';
          echo '<p class="card-text"><strong>Estado: </strong>' . $row["estado"] . '</p>';
          echo '<p class="card-text"><strong>Data: </strong>' . $row["data_evento"] . '</p>';
        ?>
                 <div style="
    height: auto;
    display: flex;
    align-items: center;
    justify-content: center;">
                                <form action="chatOngs.php" method="POST">
                                    <?php
                                echo '<input type="hidden" name="id_evento" value="' .  $row['id_evento'] . '">';
                                ?>
                                <button class="comentarios" type="submit"><i class="bi bi-chat-dots-fill"></i></button> 
                                </form>
                                </div>
                                <?php 
          echo '  <form id="formCancelar" method="post" action="cancelar_evento.php" onsubmit="return confirm(\'Tem certeza que deseja cancelar o evento?\')">';
        echo '      <input type="hidden" name="id_evento" value="'. htmlspecialchars($row['id_evento']) .'">';
     echo '   <button type="submit" class="btn btn-danger" alt="Botão para fazer o cancelamento">Cancelar Evento</button>';
        echo ' </form>';
          echo '</div>'; 
          echo '</div>'; 
          echo '</div>'; 
        }

      } else { 
       echo '<p class="text-center">Nenhum evento encontrado. </p>';
      }
      $conn ->close();

?>
      </div>
    </div>
 <!-- Adicionando Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<a href="telaOngs.php" class="btn" >Sair</a>
     
</body>
</html>
