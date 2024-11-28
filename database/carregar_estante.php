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

$id_usuario = isset($_POST['id_usuario']) ? $_POST['id_usuario'] : null;
$id_status = isset($_POST['id_status']) ? $_POST['id_status'] : null;


if (!$id_status || !$id_usuario) {
    echo json_encode(['success' => false, 'message' => 'Dado invalido']);
    exit;
}

$stmt = $conn->prepare("SELECT livros.id, livros.titulo, livros.pagina_url, livros.capa_url FROM livros, usuarios, status, marcacao_livros WHERE marcacao_livros.id_livro = livros.id AND marcacao_livros.id_usuario = usuarios.id AND marcacao_livros.id_status = status.id AND usuarios.id = ? AND status.id = ?");
$stmt->bind_param("ii", $id_usuario, $id_status);
$stmt->execute();
$result = $stmt->get_result();

$livros = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $livros[] = $row;
    }
    echo json_encode(['success' => true, 'livros' => $livros]);
} else {
    echo json_encode(['success' => false, 'message' => 'Nenhum livro encontrado']);
}

$stmt->close();
$conn->close();
?>