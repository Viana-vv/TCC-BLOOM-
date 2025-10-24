<?php
session_start();

include'config.php';
$novaSenha = password_hash($_POST["senha"], PASSWORD_DEFAULT);
if(!isset($_SESSION['cnpj'])){
  die("Acesso não autorizado. faça Login.");
}

$cnpj = $_SESSION['cnpj'];



$sql_check = "SELECT cnpj FROM ongs WHERE cnpj = ?";
$stmt_check = $conn->prepare($sql_check);
$stmt_check->bind_param("s", $cnpj);
$stmt_check->execute();
$resultado = $stmt_check->get_result();

if ($resultado->num_rows > 0) {
    $sql = ("UPDATE ongs set senha = ? WHERE cnpj = ? ");
    $stmt_update = $conn->prepare($sql);
    $stmt_update->bind_param("ss", $novaSenha, $cnpj);
    if ($stmt_update->execute()) {
        $stmt_update->close();
        header("Location:login.html");
    } else {
        $stmt_update->close();
        header("Location:trocarSenhaOngs.html");
    }
    exit();
}else{
          header("Location:trocarSenha.html");
}

$stmt_check->close();
$conn->close();

?>