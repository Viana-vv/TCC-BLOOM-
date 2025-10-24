<?php

header("Content-Type: application/json");

// Conexão com banco de dados
$conn = new mysqli("localhost", "root", "", "usuarios");

if ($conn->connect_error) {
    die(json_encode(["message" => "Erro de conexão com o banco."]));
}

// Recebendo dados do formulário
$data = json_decode(file_get_contents("php://input"), true);
$email = $data["email"] ?? "";
$senha = $data["password"] ?? "";

// Buscando usuário no banco
$sql = "SELECT senha FROM userteste WHERE email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    if (password_verify($senha, $row['senha'])) {
        echo json_encode(["message" => "Login bem-sucedido!"]);
    } else {
        echo json_encode(["message" => "Senha incorreta!"]);
    }
} else {
    echo json_encode(["message" => "E-mail não encontrado!"]);
}

$stmt->close();
$conn->close();

?>
