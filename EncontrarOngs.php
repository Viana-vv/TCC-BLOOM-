<?php
session_start();
include'config.php';

if(!isset($_SESSION['tipo_usuario'] )){
    header('Location:login.html');
}

$sql = " SELECT id_ongs, nome,telefone, email, rua, bairro, estado,data_criacao  FROM ongs ORDER BY data_criacao DESC";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>  Bloom-Ongs Cadastradas </title>
     <link rel="stylesheet" href="tccestilo/estiloTelainicial.css">
      <link rel="icon" href="imgtcc/pet.jpeg">
         <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">
</head>
<style>
  body{
    display: flex;
    flex-direction:column;
    align-items:center;
    justify-content:center;
  }
.btn{
  margin-top:10px;
  margin-bottom: 5px;
    width: 350px;
    height: 50px;
 font-size: large;
    border-radius: 20px;
    cursor: pointer;
    background-color: #3f9142;
    color:rgb(255, 255, 255);
}

.btn:hover{
    background-color: #dce2b3;
    color: #234124;
}

</style>
<body>

  <div class="container text-center mt-4">
    <h1> Ongs Cadastradas: </h1>
              <img src="imgtcc/pet.jpeg" style="width: 200px; height: 200px;">
  
       <form  action="validarSairBtnOngs.php">
    <div class="row align-items-center">
       <?php
      if($result->num_rows > 0){
        while($row = $result->fetch_assoc()){
          echo '<div class="col-md-4 mb-4">';
          echo '<div class="card mb-3 " style="width: 18rem;">';
          echo '<div class="card-body"> 📌';
          echo '<h5 class="card-title"> Ong: ' . $row["nome"] . '</h5>';
            echo '<p class="card-text"><strong>E-mail: </strong>' . $row["email"] . '</p>';
          echo '<p class="card-text"><strong>Telefone: </strong>' . $row["telefone"] . '</p>';
           echo '<p class="card-text"><strong>Rua: </strong>' . $row["rua"] . '</p>';
          echo '<p class="card-text"><strong>Bairro: </strong>' . $row["bairro"] . '</p>';
          echo '<p class="card-text"><strong>Estado: </strong>' . $row["estado"] . '</p>';        
          echo '</div>'; 
          echo '</div>'; 
          echo '</div>'; 
        }
      } else { 
       echo '<p class="text-center">Nenhuma ong encontrado.</p>';
      }
      $conn ->close();
      ?>
      </div>
    </div>
 <!-- Adicionando Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

 <button type="submit" class="btn" >Sair</button>
    </form>              
</body>
</html>
