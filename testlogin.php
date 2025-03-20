<?php
session_start();

if(isset($_POST['submit'])&& !empty($_POST['email']) && !empty($_POST['senha'])){

    include_once('php/conexao.php');
    $email = $_POST['email'];
    $senha = $_POST['senha'];


    $sql = "SELECT * FROM usuario WHERE email = '$email' and senha = '$senha'";
    $result = $mysqli->query($sql);

    
    if(mysqli_num_rows($result) < 1){
        header('Location: login.php'); // se nao existir cadastro no sistema, retorna a pagina de login
        unset($_SESSION['email']);
        unset($_SESSION['senha']);

    }
    else{
        $_SESSION['email'] = $email;
        $_SESSION['senha'] = $senha;

        header('Location: index.php'); //acessou o sistema
    }
}
else
{
    header('Location: login.php'); // se o formulario nao for preenchido e o botao enviar for clicado, retorna a pagina de login
}

?>