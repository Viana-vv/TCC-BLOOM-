<?php

header("Content-Type: application/json");

// Conexão com banco de dados (MySQL)
$servername = "localhost";
$username = "root"; // Alterar conforme necessário
$password = "";
$dbname = "usuarios";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die(json_encode(["message" => "Erro na conexão com o banco."]));
}

// Recebendo os dados do formulário
$data = json_decode(file_get_contents("php://input"), true);
$email = $data["email"] ?? "";
$senha = $data["password"] ?? "";

// Validação básica do e-mail
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo json_encode(["message" => "E-mail inválido."]);
    exit();
}

// Verificando o e-mail no Hunter.io
$api_key = "04392711e4e7e92c6cfff2c71a4339afe9258cd0"; // Coloque sua chave da API do Hunter.io
$url = "https://api.hunter.io/v2/email-verifier?email={$email}&api_key={$api_key}";

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($ch);
curl_close($ch);

$data = json_decode($response, true);

// Se o Hunter.io indicar que o e-mail é inválido, cancelamos o cadastro
if ($data['data']['status'] === "invalid") {
    echo json_encode(["message" => "E-mail inválido de acordo com Hunter.io."]);
    exit();
}

// Criptografando a senha com password_hash()
$senha_hash = password_hash($senha, PASSWORD_DEFAULT);

// Salvando no banco de dados
$sql = "INSERT INTO userteste (email, senha) VALUES (?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $email, $senha_hash);

if ($stmt->execute()) {
    echo json_encode(["message" => "Cadastro realizado com sucesso!"]);
} else {
    echo json_encode(["message" => "Erro ao cadastrar usuário: " . $stmt->error]);
}

$stmt->close();
$conn->close();

?>
