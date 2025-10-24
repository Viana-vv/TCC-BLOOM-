<?php
// Iniciar a sessão e exibir os dados recebidos via POST 
session_start();

include'config.php';


// Dados recebidos via POST
$nome = trim(htmlspecialchars($_POST['nome']));
$cnpj = preg_replace('/\D/','', $_POST['cnpj']);
$rua = $_POST['rua'];
$bairro = $_POST['bairro'];
$estado = $_POST['estado'];
$telefone = preg_replace('/\D/','',$_POST['telefone']);
$email = $_POST['email'];
$estatuto = $_POST['estatuto'];
$data_fundacao = $_POST['data_fundacao'];
$data_registro = $_POST['data_registro'];
$senha = $_POST['senha'];

$senha_hash = password_hash($senha, PASSWORD_DEFAULT);



if(!is_numeric($telefone)){
   header('Location: cadastroOngs.html');
      exit();
}

if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
echo json_encode(["message" => "Email invalido"]);
header("location: cadastroOngs.html");
exit();
}
/*
$api_key = "00cbf1c0c8fa4d5554408e4a3770ee17d720affa";
$url = "https://api.hunter.io/v2/email-verifier?email=" . urlencode($email) . "&api_key=" . $api_key;
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($ch);
curl_close($ch);

$api_result =json_decode($response, true);

if(!$api_result||!isset($api_result['data']['result'])){
 $_SESSION['erro_cadastro'] ="Formato de E-mail inválido";
header("location: cadastro.html");
exit();
}

if (isset($api_result['data']['result']) && $api_result['data']['result']!=="valid"){
  header("location: cadastro.html");
   die(json_encode(["message" => "O E-mail informado é invalido"]));
exit();
  }*/


$sql = " SELECT nome,cnpj ,telefone, email FROM ongs WHERE nome = ? AND cnpj = ? AND telefone = ?  AND  email = ?  ";
$stmt = $conn->prepare($sql);

$stmt->bind_param("ssss", $nome, $cnpj, $telefone, $email );
$stmt->execute();
$result = $stmt->get_result();

if( $result->num_rows > 0 ){
    $_SESSION['erro_cadastro'] = "Erro";
    header('Location: cadastroOngs.html');
 exit();

}
else{
// SQL para inserir os dados na tabela
$sql = "INSERT INTO ongs (nome, cnpj , telefone , email , rua , bairro , estado , estatuto, data_fundacao, data_registro, senha) VALUES
(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);

if(!$stmt){
  die("ERRO" . $stmt->error);
}

$stmt->bind_param("sssssssssss", $nome, $cnpj,$telefone, $email, $rua , $bairro , $estado , $estatuto, $data_fundacao, $data_registro,  $senha_hash);
$sucesso = $stmt->execute();

if($sucesso) {
    header('Location: login.html');
    exit();

} else {
  $_SESSION['erro_cadastro'] = "Erro ao cadastrar usuário!." . $stmt->error;
  header('Location: cadastroOngs.html');
  exit();
  }
}



// Fechar conexões

?>