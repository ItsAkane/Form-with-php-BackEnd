<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");


$host = "localhost";
$user = "root";
$pass = "1234";
$db = "banco";

$conn = mysqli_connect($host, $user, $pass, $db);

if ($conn->connect_error) {
    echo json_decode($conn->connect_error);
    exit();
}

$sql = "SELECT id, name, email, telefone, assunt, message FROM mensagem";
$result = $conn->query($sql);

$mensagems = [];
while ($row = $result->fetch_assoc()) {
    $mensagem[] = $row;
}

echo json_encode($mensagem);

$conn->close();
?>