<?php
session_start();

include'config.php';
$novaSenha = password_hash($_POST["senha"], PASSWORD_DEFAULT);
if(!isset($_SESSION['cpf'])){
  die("Acesso não autorizado. faça Login.");
}

$cpf = $_SESSION['cpf'];




$sql_check = "SELECT cpf FROM usuarios WHERE cpf = ?";
$stmt_check = $conn->prepare($sql_check);
$stmt_check->bind_param("s", $cpf);
$stmt_check->execute();
$resultado = $stmt_check->get_result();

if ($resultado->num_rows > 0) {
    $sql = ("UPDATE usuarios set senha = ? WHERE cpf = ? ");
    $stmt_update = $conn->prepare($sql);
    $stmt_update->bind_param("ss", $novaSenha, $cpf);
    if ($stmt_update->execute()) {
        $stmt_update->close();
        header("Location:login.html");
    } else {
        $stmt_update->close();
        header("Location:trocarSenha.html");
    }
    exit();
}else{
          header("Location:trocarSenha.html");
}

$stmt_check->close();
$conn->close();

?>