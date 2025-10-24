<?php
session_start();

include'config.php';
if (!isset($_SESSION['id_usuario'])) {
    header('Location:login.html');
    die("Acesso não autorizado. faça Login.");
}
$id_ongs = $_SESSION['id_usuario'];

$rua = $_POST['rua']?? null;
$bairro = $_POST['bairro'] ?? null;
$estado = $_POST['estado']?? null; 
$telefone = preg_replace('/\D/','',$_POST['telefone'])?? null;



if(!is_numeric($telefone)){
}


if(!isset($_FILES['imagens']) || $_FILES['imagens']['error'] !==UPLOAD_ERR_OK){
   header( 'Location:telaOngs.php') ;
}
$imagensBinaria = file_get_contents($_FILES['imagens']['tmp_name']);




$sql = "SELECT  rua , bairro , estado ,telefone, imagens FROM ongs WHERE id_ongs = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id_ongs);
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


$stmt = $conn->prepare("UPDATE ongs SET imagens = ?, telefone = ?, rua = ?, bairro = ?, estado = ? WHERE id_ongs = ?");
$stmt->bind_param('sssssi', $imagensBinaria, $telefone, $rua, $bairro,$estado, $id_ongs);

if($stmt->execute()){
header('Location:telaOngs.php');
    exit();
}
else{ 
   header('Location:perfil.php');
    exit();
}


$stmt->close();
$conn->close();
?>