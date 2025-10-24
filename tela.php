<?php
error_reporting(0);
ini_set('display_errors', 0);

// Iniciar a sessão e exibir os dados recebidos via POST 
session_start();
include'config.php';


$sql = " SELECT id_evento, id_ongs, data_evento, descricao,rua,bairro, estado FROM registrar_Eventos ORDER BY data_evento ";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title> Home Bloom </title>
     <link rel="stylesheet" href="tccestilo/estiloTelainicial.css">
        <link rel="icon" href="imgtcc/pet.jpeg">
    
         <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">
</head>
<style>
  
.btn{
  margin-bottom: 5px;
    width: 350px;
    height: 50px;
 font-size: large;
    border-radius: 20px;
    cursor: pointer;
    background-color: #3f9142;
    color: #000000;
}

.btn:hover{
    background-color: #dce2b3;
    color: #234124;
}
</style>
<body>
  <div class="navBar">
<div class="pesquisar">
<input type="search" name="pesquisar" class="pesq" placeholder="Pesquisar..." >
</div>


      <div class="nav1">
    <input type="checkbox" id="toggle">
    <label for="toggle" class="toggle">
<img src="imgtcc/fotodeuser.jpg" alt="foto do usuario aqui">        
<span class="top_line common"></span>
<span class="middle_line common" ></span>
<span class="bottom_line common"></span>
    </label>
    
        <div class="slide">
            <ul>
                <li><img src="img tcc/fotodeuser.jpg" alt="" style="width: 50px; height: 50px; border-radius: 50%;"></li>
                <li><a href="login.html"> <i class="bi bi-person"></i> Login</a></li>
                 <li><a href="login.html"> <i class="bi bi-person-vcard-fill"></i> Login Ongs</a></li>
                <li><a href="comofunciona.html"> <i class="bi bi-person-raised-hand"></i> Como Funciona?</a></li>
                <li><a href="apresentação.html"> <i class="bi bi-people-fill"></i> Sobre nós</a></li>
                <li><a href="Suporte.html"> <i class="bi bi-chat-left-dots"></i> Suporte</a></li>
            <li><a href="" style="font-size: x-small;"> <i class="bi bi-book-half"></i> Termos de politica de privacidade</a></li>
         </ul>
        </div>
    </label>
    </div>

    <!--Lado esquerdo-->
    <div class="nav2">
  <input type="checkbox" id="toggle2">
    <label for="toggle2" class="toggle2">
<span class="top_line common"></span>
<span class="middle_line common" ></span>
<span class="bottom_line common"></span>
    </label>
    
        <div class="slide-left">
            <h2>MENU:</h2>
            <ul>
                <li><a href="telaInicial.html"><i class="bi bi-house"></i> Inicio</a></li>
                <li><a href="EncontrarOngs.php"><i class="bi bi-search-heart"></i> Encontrar Ongs</a></li>
                <li><a href="cadastro.html"><i class="bi bi-person-plus-fill"></i> Fazer Cadastro</a></li>
                <li><a href="cadastroOngs.html"><i class="bi bi-pencil-square"></i> Cadastrar Ongs</a></li>
                <li><a href="comofunciona.html"><i class="bi bi-person-raised-hand"></i> Como Funciona?</a></li>
                <li><a href="apresentação.html"><i class="bi bi-people-fill"></i> Sobre nós</a></li>
                <li><a href="Suporte"><i class="bi bi-chat-left-dots"></i> Suporte</a></li>
                <li><a href="" style="font-size: x-small;"><i class="bi bi-book-half"></i> Termos de politica de privacidade</a></li>
            </ul>
        </div>
    </label>
    </div>
  </div>  

  <div class="container text-center mt-4">
    <h1>Eventos Registrados </h1>
    <div class="row align-items-center">
      <?php
      if($result->num_rows > 0){
        while($row = $result->fetch_assoc()){
          echo '<div class="col-md-4">';
          echo '<div class="card mb-3 " style"width: 18rem;">';
          echo '<div class="card-body"> 📌';
          echo '<h5 class="card-title"> Evento: ' . $row["id_evento"] . '</h5>';
           echo '<p class="card-text"><strong>Rua: </strong>' . $row["rua"] . '</p>';
          echo '<p class="card-text"><strong>Bairro: </strong>' . $row["bairro"] . '</p>';
          echo '<p class="card-text"><strong>Estado: </strong>' . $row["estado"] . '</p>';
        
        
          echo '</div>'; 
          echo '</div>'; 
          echo '</div>'; 
        }
      } else { 
       echo '<p class="text-center">Nenhum evento encontrado.</p>';
      }
      $conn ->close();
      ?>
      </div>
    </div>
 <!-- Adicionando Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>


</body>
</html>
