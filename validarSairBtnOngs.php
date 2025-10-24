<?php
session_start(); 

if(!isset($_SESSION['tipo_usuario'] )){
    header('Location:telaInicial.php');
  die("Acesso não autorizado. faça Login.");
}
switch($_SESSION['tipo_usuario']){
case 'ongs':
    header('Location:telaOngs.php');
    exit();
case'usuario': 
    header('Location:telaUser.php');
    exit();
case 'adm': 
    header('Location:telaAdm.php');
    exit();
default:
    header('Location:telaInicial.php');
    exit();
}
?>
