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

$email = isset($_POST['email']) ? $_POST['email'] : null;
$senha = isset($_POST['senha']) ? $_POST['senha'] : null;


if (!$email || !$senha) {
    echo json_encode(['success' => false, 'message' => 'Email e senha são obrigatórios']);
    exit;
}

$stmt = $conn->prepare("SELECT * FROM usuarios WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
    if ($senha == $user['senha']) {
        echo json_encode(['success' => true, 'message' => 'Login realizado com sucesso!', 'id' => $user['id'], 'nome' => $user['nome'], 'email' => $user['email']]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Senha incorreta']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Usuário não encontrado']);
}

$stmt->close();
$conn->close();
?>
