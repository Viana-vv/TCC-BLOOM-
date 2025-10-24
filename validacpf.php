<?php
session_start();
$cpfpass = $_POST['cpf'];


include'config.php';
$sql = "SELECT cpf FROM usuarios WHERE cpf = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $cpfpass);
if($stmt->execute()){
    $result = $stmt->get_result();

if(mysqli_num_rows($result) > 0){
 $_SESSION['cpf'] = $cpfpass;
    header("Location:trocarSenha.html");
exit();

}else{
  header("Location:verificacpf.html");
 exit();
}
}
?>