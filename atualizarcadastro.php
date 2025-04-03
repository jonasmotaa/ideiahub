<?php
session_start();

if (isset($_POST['submit2']) && !empty($_POST['emailnovo']) && !empty($_POST['senhanovo'])) {

    include_once('php/conexao.php');
    $email = $_SESSION['email'];
    $emailnovo = $_POST['emailnovo'];
    $senhanovo = $_POST['senhanovo'];




    // Consulta para verificar se o email existe

    if ($result2->num_rows > 0) {
        echo "<script>alert('Erro: O email colocado ja está cadastrado');</script>";
        header('Location: user-profile.php');
    } else {
        echo 'O email não está registrado.';
    }

    // Pasta onde os arquivos serão armazenados
    $targetDir = "assets/users/";

    // Verifica se a pasta de destino existe, caso contrário, cria
    if (!is_dir($targetDir)) {
        mkdir($targetDir, 0755, true);
    }

    // Verifica se foi enviado um arquivo
    if (isset($_FILES["file"])) {

        // Obtém o nome e a extensão do arquivo enviado
        $fileName = basename($_FILES["file"]["name"]);
        $fileExtension = pathinfo($fileName, PATHINFO_EXTENSION);

        // Cria o caminho completo para salvar o arquivo usando $ultimoid
        $targetFile = $targetDir . $id . '.' . $fileExtension;

        // Define os tipos de arquivo permitidos
        $allowedTypes = ["image/jpeg", "image/png", "application/pdf"];

        // Verifica se o tipo de arquivo é permitido
        $fileType = mime_content_type($_FILES["file"]["tmp_name"]); // Obtém o tipo MIME do arquivo
        if (in_array($fileType, $allowedTypes)) {
            // Move o arquivo para a pasta de destino
            move_uploaded_file($_FILES["file"]["tmp_name"], $targetFile);
        }
    }

    $sql = "UPDATE usuario
    SET email = '$emailnovo', senha = '$senhanovo'
    WHERE email = '$email'";
    $result = $mysqli->query($sql);
}
unset($_SESSION['email']);
unset($_SESSION['senha']);
header('Location: user-profile.php');
