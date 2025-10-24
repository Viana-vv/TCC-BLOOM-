<?php 
session_start();
if (!isset($_SESSION['id_usuario'])) {
    header('Location:login.html');
    die("Acesso não autorizado. faça Login.");
}else{
    $id_usuario = $_SESSION['id_usuario'];
    header('Location:telaOngs.php');
}
?>