<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");

$host = 'localhost';
$db = 'estante_virtual'; 
$user = 'root'; 
$password = ''; 

$conn = new mysqli($host, $user, $password, $db);

if ($conn->connect_error) {
    die(json_encode(['success' => false, 'message' => 'Erro ao conectar ao banco de dados']));
}

$id = isset($_POST['id']) ? $_POST['id'] : null;
$senha = isset($_POST['senha']) ? $_POST['senha'] : null;


if (!$id || !$senha) {
    echo json_encode(['success' => false, 'message' => 'Senha são obrigatórios']);
    exit;
}

$stmt = $conn->prepare("UPDATE usuarios SET senha = ? WHERE id = ?");
$stmt->bind_param("si", $senha, $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
        echo json_encode(['success' => true, 'message' => 'Senha alterada com sucesso!']);
} else {
    echo json_encode(['success' => false, 'message' => 'Senha não alterada']);
}

$stmt->close();
$conn->close();
?>

