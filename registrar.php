<?php
if(isset($_POST['submit'])){

    include_once('php/conexao.php');

    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $senha = $_POST['senha'];


 

    $sql = "SELECT email FROM usuario WHERE usuario.email = '$email'";
    $result =  $mysqli->query($sql);
    if($result->num_rows > 0){
        echo '<div style="text-align: center;">';
        echo 'Já existe um usuário cadastrado com esse email.';
        echo '</div>';
        
        }else{ mysqli_query($mysqli, "INSERT INTO usuario(email, nome, senha)
    VALUES ('$email','$nome','$senha')");

            
        }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['arquivo'])) {
  $diretorioDestino = "assets/images/users"; // Diretório onde os arquivos serão salvos
  $nomeArquivo = basename($_FILES['arquivo']['name']);
  $caminhoCompleto = $diretorioDestino . $nomeArquivo;

  // Certifique-se de que o diretório existe
  if (!is_dir($diretorioDestino)) {
      mkdir($diretorioDestino, 0777, true);
  }

  // Mover o arquivo para o diretório destino
  if (move_uploaded_file($_FILES['arquivo']['tmp_name'], $caminhoCompleto)) {
      echo "Arquivo salvo com sucesso em: " . $caminhoCompleto;
  } else {
      echo "Falha ao salvar o arquivo.";
  }
}

?>

<!doctype html>
<html lang="en" data-bs-theme="blue-theme">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Maxton | Bootstrap 5 Admin Dashboard Template</title>
  <!--favicon-->
	<link rel="icon" href="assets/images/favicon-32x32.png" type="image/png">
  <!-- loader-->
	<link href="assets/css/pace.min.css" rel="stylesheet">
	<script src="assets/js/pace.min.js"></script>

  <!--plugins-->
  <link href="assets/plugins/perfect-scrollbar/css/perfect-scrollbar.css" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="assets/plugins/metismenu/metisMenu.min.css">
  <link rel="stylesheet" type="text/css" href="assets/plugins/metismenu/mm-vertical.css">
  <!--bootstrap css-->
  <link href="assets/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Noto+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Material+Icons+Outlined" rel="stylesheet">
  <!--main css-->
  <link href="assets/css/bootstrap-extended.css" rel="stylesheet">
  <link href="sass/main.css" rel="stylesheet">
  <link href="sass/dark-theme.css" rel="stylesheet">
  <link href="sass/blue-theme.css" rel="stylesheet">
  <link href="sass/responsive.css" rel="stylesheet">

  </head>

<body>


  <!--authentication-->

  <div class="section-authentication-cover">
    <div class="">
      <div class="row g-0">

        <div class="col-12 col-xl-7 col-xxl-8 auth-cover-left align-items-center justify-content-center d-none d-xl-flex border-end bg-transparent">

          <div class="card rounded-0 mb-0 border-0 shadow-none bg-transparent bg-none">
            <div class="card-body">
              <img src="assets/images/auth/register1.png" class="img-fluid auth-img-cover-login" width="500"
                alt="">
            </div>
          </div>

        </div>

        <div class="col-12 col-xl-5 col-xxl-4 auth-cover-right align-items-center justify-content-center">
          <div class="card rounded-0 m-3 border-0 shadow-none bg-none">
            <div class="card-body p-sm-5">
              <img src="assets/images/logoideiahub.png" class="mb-4" width="145" alt="">
              <h4 class="fw-bold">Criar uma conta</h4>
              <p class="mb-0">Crie as credenciais para o novo usuário</p>

          

              <div class="form-body mt-4">
                <form class="row g-3" action="registrar.php" method="POST">
                  <div class="col-12">
                    <label for="inputUsername" class="form-label">Username</label>
                    <input type="text" name="nome" class="form-control" id="nome" placeholder="Nome">
                  </div>
                  <div class="col-12">
                    <label for="inputEmailAddress" class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" id="email" placeholder="examplo@ideianinja.onmicrosoft.com">
                  </div>
                  <div class="col-12">
                    <label for="senha" class="form-label">Senha</label>
                    <div class="input-group" id="show_hide_password">
                      <input type="password" name="senha" class="form-control" id="senha" placeholder="Senha">
                       <a href="javascript:;" class="input-group-text bg-transparent"><i class="bi bi-eye-slash-fill"></i></a>
                    </div>
                  </div>
                 
                 
                  <div class="col-12">
                    <div class="d-grid">
                      <button type="submit" name="submit" id="submit" class="btn btn-grd-danger">Registrar</button>
                    </div>
                  </div>
                  
                </form>
              </div>

          </div>
          </div>
        </div>

      </div>
      <!--end row-->
    </div>
  </div>

  <!--authentication-->




  <!--plugins-->
  <script src="assets/js/jquery.min.js"></script>

  <script>
    $(document).ready(function () {
      $("#show_hide_password a").on('click', function (event) {
        event.preventDefault();
        if ($('#show_hide_password input').attr("type") == "text") {
          $('#show_hide_password input').attr('type', 'password');
          $('#show_hide_password i').addClass("bi-eye-slash-fill");
          $('#show_hide_password i').removeClass("bi-eye-fill");
        } else if ($('#show_hide_password input').attr("type") == "password") {
          $('#show_hide_password input').attr('type', 'text');
          $('#show_hide_password i').removeClass("bi-eye-slash-fill");
          $('#show_hide_password i').addClass("bi-eye-fill");
        }
      });
    });
  </script>

</body>

</html>