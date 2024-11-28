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
$id_usuario = isset($_POST['id_usuario']) ? $_POST['id_usuario'] : null;
$id_livro = isset($_POST['id_livro']) ? $_POST['id_livro'] : null;
$id_status = isset($_POST['id_status']) ? $_POST['id_status'] : null;

if (!$id_usuario || !$id_livro || !$id_status) {
    echo json_encode(['success' => false, 'message' => 'Os Dados são obrigatorios']);
    exit;
}



$stmt = $conn->prepare("SELECT marcacao_livros.id_usuario, marcacao_livros.id_livro, marcacao_livros.id_status FROM marcacao_livros, usuarios, livros, status WHERE marcacao_livros.id_usuario = usuarios.id AND marcacao_livros.id_livro = livros.id AND marcacao_livros.id_status = status.id AND livros.id = ?");
$stmt->bind_param("i", $id_livro);
$stmt->execute();
$result = $stmt->get_result();


if ($result->num_rows > 0) {

    // Preparando a query
    $stmt = $conn->prepare("UPDATE marcacao_livros SET id_status =?  WHERE id_usuario = ? AND id_livro = ?");
    $stmt->bind_param("iii", $id_status, $id_usuario, $id_livro);

    // Executando a query
    if ($stmt->execute()) {
        if ($stmt->affected_rows > 0) {
            echo json_encode(['success' => true, 'message' => 'Status alterado com sucesso!']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Nenhuma alteração feita.']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Erro ao executar alteração']);
    }


} else {
    $stmt = $conn->prepare("INSERT into marcacao_livros (id_usuario, id_livro, id_status) values (?, ?, ?)");
    $stmt->bind_param("iii", $id_usuario, $id_livro, $id_status);

    // Executando a query
    if ($stmt->execute()) {
        if ($stmt->affected_rows > 0) {
            echo json_encode(['success' => true, 'message' => 'Livro adicionado à estante!']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Nenhuma alteração feita.']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Erro ao executar a atualização']);
    }
}

// Preparando a query

$stmt->close();
$conn->close();
?>