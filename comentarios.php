<?php
session_start();
include'config.php';

if(!isset($_SESSION['id_usuario'])){
  die("Acesso não autorizado. faça Login.");
}

$id_usuario = intval($_SESSION['id_usuario']);


    $stmt = $conn->prepare("SELECT nome FROM usuarios WHERE 
    id_usuario = ?");
     $stmt->bind_param("i",$id_usuario );
    $stmt->execute();
    $result = $stmt->get_result();

    if( $result->num_rows === 0 ){
        header('location:Login.html');
    }

    $usuario_data = $result->fetch_assoc();
    
$id_evento = $_GET['id_evento'] ?? $_POST['id_evento'] ?? null;
if(!$id_evento){
           header('location:Login.html');
}

    $stmt = $conn->prepare("SELECT id_evento,titulo FROM registrar_eventos WHERE 
    id_evento = ?");
     $stmt->bind_param("i",$id_evento );
    $stmt->execute();
    $evento_result = $stmt->get_result();

$evento_data = $evento_result->fetch_assoc();
$titulo = $evento_data['titulo'];

if($evento_result->num_rows===0){
               header('location:Login.html');
}
if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['comentarios'])) {
$comentario = trim($_POST['comentarios']);

if(!empty($comentario)){
       $stmt = $conn->prepare("INSERT INTO comentarios (id_evento, id_usuario, comentario) VALUES (?,?,?) ");
     $stmt->bind_param("iis",$id_evento, $id_usuario,$comentario );
   $stmt->execute();
   
}else{
    echo"<p>Comentario está vazio</p>"; 
}
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Chat Bloom</title>
   <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
 <link rel="stylesheet" href="tccestilo/chat.css">
     <link rel="icon" href="imgtcc/pet.jpeg">
</head>
<body>
   <div class="localbtn">
    <button class="sair" type="submit" onclick="history.back()">Voltar</button>
    </div>
  <div class="localimg">
  <img src="imgtcc/pet.jpeg">
  </div>
  <div class="borda">

<h2> Chat do Evento: <?= htmlspecialchars($titulo)?> </h2>
    <hr>

    <h3>Comentarios Anteriores:</h3>

    <?php
    $sql = " SELECT
     c.comentario, c.data, COALESCE(u.nome,o.nome) AS nome_autor
    FROM comentarios c
LEFT JOIN usuarios u ON c.id_usuario = u.id_usuario
LEFT JOIN ongs o ON c.id_ongs = o.id_ongs

WHERE c.id_evento = ?
ORDER BY c.data";


    $stmt = $conn->prepare($sql);
     $stmt->bind_param("i",$id_evento );
    $stmt->execute();
    $result = $stmt->get_result();

    while($row = $result->fetch_assoc()){
        echo "<p><strong>". htmlspecialchars($row['nome_autor']) . ":  </strong>". 
    nl2br(htmlspecialchars($row['comentario'])) .
    "<br><small>".$row['data']."<small></p><hr>";

    }
?>


  <p class="n">Comentando como: <strong><?= htmlspecialchars($usuario_data['nome']) ?><i class="bi bi-arrow-down-short"></i></strong></p>

  &nbsp;
  <form method="post">
<input type="hidden" name="id_evento" value="<?= htmlspecialchars($id_evento)?>">
<textarea name="comentarios" required placeholder="Digite sua duvida..."></textarea> 
<button type="submit"><i class="bi bi-send"></i></button><br>
    </form>  
    </div>   
   
</body>
</html>
 