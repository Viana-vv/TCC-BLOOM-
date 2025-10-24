<?php
session_start();

include'config.php';
$id_usuario = $_SESSION['id_usuario'];


$rua = $_POST['rua']?? null;
$bairro = $_POST['bairro'] ?? null;
$estado = $_POST['estado']?? null; 
$telefone = preg_replace('/\D/','',$_POST['telefone'])?? null;



if(!is_numeric($telefone)){
}

if (!isset($_SESSION['id_usuario'])) {
    header('Location:login.html');
    die("Acesso não autorizado. faça Login.");
}


if(!isset($_FILES['imagens']) || $_FILES['imagens']['error'] !==UPLOAD_ERR_OK){
header('Location:telaUser.php');
}
$imagensBinaria = file_get_contents($_FILES['imagens']['tmp_name']);




$sql = "SELECT rua, bairro, estado, telefone, imagens FROM usuarios WHERE id_usuario = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id_usuario);
$stmt->execute();
$stmt->store_result();
$stmt->bind_result($rua_atual,$bairro_atual,$estado_atual ,$telefone_atual ,$imagens_atual);   
$stmt->fetch();
$stmt->close();

$houveAlteracao = false;
if(
    $imagensBinaria !== $imagens_atual ||
    $telefone !== $telefone_atual ||
    $rua !== $rua_atual ||
    $bairro !== $bairro_atual ||
$estado !== $estado_atual 
 ) {
    $houveAlteracao = true; 
}


$stmt = $conn->prepare("UPDATE usuarios SET imagens = ?, telefone = ?, rua = ?, bairro = ?, estado = ? WHERE id_usuario = ?");
$stmt->bind_param('sssssi', $imagensBinaria, $telefone, $rua, $bairro,$estado, $id_usuario);

if($stmt->execute()){
header('Location:telaUser.php');
    exit();
}
else{ 
   header('Location:perfil.php');
    exit();
}


$stmt->close();
$conn->close();
?>