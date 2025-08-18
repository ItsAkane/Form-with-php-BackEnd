<?php
header("Access-Control-Allow-Origin: http://localhost:3000");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json; charset=utf-8");

error_reporting(E_ALL);
ini_set('display_errors', 0);
ini_set('log_errors', 1);
ini_set('error_log', __DIR__ . '/php-error.log');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

$host = "localhost";
$user = "root";
$pass = "1234";
$db   = "banco";

$dados = json_decode(file_get_contents("php://input"), true);
if (!$dados) {
    echo json_encode(["status" => "error", "mensagem" => "Nenhum JSON recebido"]);
    exit;
}

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    echo json_encode(["status" => "error", "mensagem" => "Erro de conexão: " . $conn->connect_error]);
    exit;
}

$stmt = $conn->prepare("INSERT INTO mensagem(name, email, telefone, assunt, message) VALUES (?,?,?,?,?)");
if (!$stmt) {
    echo json_encode(["status" => "error", "mensagem" => "Erro no prepare: " . $conn->error]);
    $conn->close();
    exit;
}

$stmt->bind_param(
    "sssss",
    $dados["nome"],
    $dados["email"],
    $dados["telefone"],
    $dados["assunto"],
    $dados["mensagem"]
);

if ($stmt->execute()) {
    echo json_encode(["status" => "ok", "mensagem" => "Registro salvo com sucesso"]);
} else {
    echo json_encode(["status" => "error", "mensagem" => $stmt->error]);
}

$stmt->close();
$conn->close();
?>