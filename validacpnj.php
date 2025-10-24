<?php
session_start();
$cnpjpass = $_POST['cnpj'];

include'config.php';

$sql = "SELECT cnpj FROM ongs WHERE cnpj = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $cnpjpass);
if($stmt->execute()){
    $result = $stmt->get_result();

if(mysqli_num_rows($result) > 0){
 $_SESSION['cnpj'] = $cnpjpass;
    header("Location:trocarSenhaOng.html");
exit();

}else{
  header("Location:verificacpf.html");
 exit();
}
}
?>