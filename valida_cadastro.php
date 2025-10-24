<?php
// Iniciar a sessão e exibir os dados recebidos via POST 
session_start();

include'config.php';

// Dados recebidos via POST
$nome = $_POST['nome'];
$cpf = $_POST['cpf'];
$rua = $_POST['rua'];
$bairro = $_POST['bairro'];
$estado = $_POST['estado'];
$data = $_POST['data'];
$telefone =preg_replace('/\D/','', $_POST['telefone']);
$email = $_POST['email'];
$senha = $_POST['senha'];

$senha_hash = password_hash($senha, PASSWORD_DEFAULT);




$hoje = new DateTime();
$nascimento = new DateTime($data);
$idade = $hoje->diff($nascimento)->y;

if($idade <18|| $idade > 100){
  $_SESSION['erro_cadastro'] = "Cadastro não permitido para menores de 18 anos.";
header("location: cadastro.html");
exit();
}


if(!is_numeric($telefone)){
   header('Location: cadastroOngs.html');
      exit();
}


if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
echo json_encode(["message" => "Email invalido"]);
header("location: cadastro.html");
exit();
}

$sql = " SELECT nome,telefone, email FROM usuarios WHERE nome = ? AND telefone = ?  AND  email = ?  ";
$stmt = $conn->prepare($sql);

$stmt->bind_param("sss", $nome, $telefone, $email );
$stmt->execute();
$result = $stmt->get_result();

if( $result->num_rows > 0 ){
    $_SESSION['erro_cadastro'] = "Erro";
    header('Location: cadastro.html');
 exit();

}
else{
// SQL para inserir os dados na tabela
$sql = "INSERT INTO usuarios (nome, rua, bairro, estado, data , telefone,email, senha, cpf) VALUES
(?, ?, ?, ?, ?, ?, ?,?,?)";
$stmt = $conn->prepare($sql);

if(!$stmt){
  die("ERRO" . $stmt->error);
}

$stmt->bind_param("sssssssss", $nome, $rua , $bairro , $estado , $data, $telefone, $email, $senha_hash, $cpf);
$sucesso = $stmt->execute();

if($sucesso) {
    header('Location: login.html');
    exit();

} else {
  $_SESSION['erro_cadastro'] = "Erro ao cadastrar usuário!." . $stmt->error;
  header('Location: cadastro.html');
  exit();
  }
}

// Fechar conexões
$stmt->close();
$conn->close();
?>