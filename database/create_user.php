
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

$nome = isset($_POST['nome']) ? $_POST['nome'] : null;
$email = isset($_POST['email']) ? $_POST['email'] : null;
$senha = isset($_POST['senha']) ? $_POST['senha'] : null;


if (!$email || !$senha || !$nome) {
    echo json_encode(['success' => false, 'message' => 'Todos os campos são obrigatórios']);
    exit;
}

$stmt = $conn->prepare("INSERT INTO usuarios (nome, email, senha)  VALUES(?, ?, ?)");
$stmt->bind_param("sss", $nome, $email, $senha);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
        echo json_encode(['success' => true, 'message' => 'Usuario criado com sucesso!','id' => $user['id'], 'nome' => $user['nome']]);
} else {
    echo json_encode(['success' => false, 'message' => 'Usuário não encontrado']);
}

$stmt->close();
$conn->close();
?>
