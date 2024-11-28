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

// Obtendo dados do POST
$id_usuario = isset($_POST['id']) ? $_POST['id'] : null;
$id_livro = isset($_POST['senha']) ? $_POST['senha'] : null;

if (!$id_usuario || !$id_livro) {
    echo json_encode(['success' => false, 'message' => 'ID e senha são obrigatórios']);
    exit;
}

// Preparando a query
$stmt = $conn->prepare("UPDATE usuarios SET senha = ? WHERE id = ?");
$stmt->bind_param("si", $id_livro, $id_usuario);

// Executando a query
if ($stmt->execute()) {
    if ($stmt->affected_rows > 0) {
        echo json_encode(['success' => true, 'message' => 'Senha alterada com sucesso!']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Nenhuma alteração feita. Verifique se o ID existe.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Erro ao executar a atualização']);
}

$stmt->close();
$conn->close();
?>



