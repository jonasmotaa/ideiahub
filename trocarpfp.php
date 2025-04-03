<?php
session_start();
include_once('php/conexao.php');

$email = $_SESSION['email'];

$sql = "SELECT id FROM usuario WHERE email = '$email'";
$result = $mysqli->query($sql);
$row = $result->fetch_assoc();  // Obtém a linha como array associativo
$id = $row['id'];              // Extrai o valor do ID

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['file'])) {
    $destino = 'assets/users/';
    $fileExtension = strtolower(pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION));
    
    // Caminho do novo arquivo
    $targetFile = $destino . $id . '.' . $fileExtension;
    
    $tmpArquivo = $_FILES['file']['tmp_name'];
    $erro = $_FILES['file']['error'];

    if ($erro === UPLOAD_ERR_OK) {
        // Verifica se o diretório existe, caso contrário, cria
        if (!is_dir($destino)) {
            mkdir($destino, 0777, true);
        }

        // Remove a imagem anterior, independente da extensão
        $extensoes = ['jpg', 'jpeg', 'png', 'gif', 'webp']; // Tipos de arquivos suportados
        foreach ($extensoes as $ext) {
            $foto_anterior = $destino . $id . '.' . $ext;
            if (file_exists($foto_anterior)) {
                unlink($foto_anterior);
            }
        }

        // Move a nova imagem para o diretório
        if (move_uploaded_file($tmpArquivo, $targetFile)) {
            header("Location: user-profile.php");
            exit();
        }
    }
}
?>