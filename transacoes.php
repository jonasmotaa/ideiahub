<?php
session_start();
if ((!isset($_SESSION['email']) == true) and (!isset($_SESSION['senha']) == true)) {
  unset($_SESSION['email']);
  unset($_SESSION['senha']);
  header('Location: login.php'); // se nao existir sessao, retorna para login.php

}

include_once('php/conexao.php');

//Pegar o nome do user
$email = $_SESSION['email'];
$sql = "SELECT nome FROM usuario WHERE email = '$email'";
$result =  $mysqli->query($sql);
$nome = $result->fetch_assoc();

$sql = "SELECT id, adm FROM usuario WHERE email = '$email'";
$result = $mysqli->query($sql);
$row = $result->fetch_assoc();  // Obtém a linha como array associativo
$id = $row['id'];              // Extrai o valor do ID
$adm = $row['adm'];
if ($adm == 0) {
  header('Location: index.php'); // se nao for administrador, retorna para a home
}

//Pegar o ID da transação que está prestes a ser efetuada
$sql2 = "SELECT MAX(id) AS ultimo_id FROM transacao";
$result2 = $mysqli->query($sql2);

$row = $result2->fetch_assoc();
$ultimoid = $row['ultimo_id']; // Define o último ID
$ultimoid = $ultimoid + 1;


// Consultar os usuários cadastrados
$query = "SELECT id, nome FROM usuario";
$result = $mysqli->query($query);
$usuarios = $result->fetch_all(MYSQLI_ASSOC); // Isso vai pegar todos os usuários como um array associativo


//Subir no BD
if (isset($_POST['submit'])) {
  $valor = $_POST['valor'];

  // Remove espaços extras e garante que apenas números e vírgulas permaneçam
  $valor = preg_replace('/[^0-9,]/', '', $valor);

  // Substitui a vírgula por ponto (para formato numérico do PHP)
  $valor = str_replace(',', '.', $valor);

  $cliente = $_POST['cliente'];
  $data = $_POST['dat'];
  $descricao = $_POST['descricao'];

  if (isset($_POST['saida'])) {
    $saida = $_POST['saida'];
  } else {
    $saida = 0; // Valor padrão se a checkbox não for marcada.

  }
  if ($saida == 1) {
    $valor = -abs($valor);
  }


  //Comissões
  foreach ($usuarios as $usuario) {
    $str1 = "valorcom";
    $str2 = $usuario['id'];
    $str3 = $str1 . $str2;
    $valorcom = $_POST[$str3];

    // Remove espaços extras e garante que apenas números e vírgulas permaneçam
    $valorcom = preg_replace('/[^0-9,]/', '', $valorcom);

    // Substitui a vírgula por ponto (para formato numérico do PHP)
    $valorcom = str_replace(',', '.', $valorcom);

    if ($valorcom <= $valor) {

      if ($valorcom > 0) {
        $sql4 = "INSERT INTO comissao (valor, idu, idt, datcomissao) VALUES ('$valorcom', '$str2', '$ultimoid', '$data')";
        $result = $mysqli->query($sql4);
      }
    } else {
      echo "<script>alert('Erro: O valor da comissão está maior que o valor total da transação! Verifique os valores e tente novamente.');</script>";
      header("Refresh: 0");
      exit;
    }
  }

  $sql3 = "INSERT INTO transacao (email, cliente, dat, descricao, valor, tipo) VALUES ('$email', '$cliente', '$data','$descricao', '$valor', '$saida')";
  $result2 = $mysqli->query($sql3);
}



// Pasta onde os arquivos serão armazenados
$targetDir = "assets/docs/";

// Verifica se a pasta de destino existe, caso contrário, cria
if (!is_dir($targetDir)) {
  mkdir($targetDir, 0755, true);
}

// Verifica se foi enviado um arquivo
if (isset($_FILES["file"]) && $_FILES["file"]["error"] === UPLOAD_ERR_OK) {

  // Obtém o nome e a extensão do arquivo enviado
  $fileName = basename($_FILES["file"]["name"]);
  $fileExtension = pathinfo($fileName, PATHINFO_EXTENSION);

  // Cria o caminho completo para salvar o arquivo usando $ultimoid
  $targetFile = $targetDir . $ultimoid . '.' . $fileExtension;

  // Define os tipos de arquivo permitidos
  $allowedTypes = ["image/jpeg", "image/png", "application/pdf"];

  // Verifica se o tipo de arquivo é permitido
  $fileType = mime_content_type($_FILES["file"]["tmp_name"]); // Obtém o tipo MIME do arquivo
  if (in_array($fileType, $allowedTypes)) {
    // Move o arquivo para a pasta de destino
    move_uploaded_file($_FILES["file"]["tmp_name"], $targetFile);
  }
}

// Exibir a imagem do usuário
$imagemUsuario = "assets/users/default.png"; // Imagem padrão
foreach (["jpg", "jpeg", "png"] as $ext) {
  if (file_exists("assets/users/" . $id . "." . $ext)) {
    $imagemUsuario = "assets/users/" . $id . "." . $ext;
    break;
  }
}

?>

<!doctype html>
<html lang="en" data-bs-theme="blue-theme">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Realizar transação</title>
  <!--favicon-->
  <link rel="icon" href="assets/images/favicon-32x32.png" type="image/png">
  <!-- loader-->
  <link href="assets/css/pace.min.css" rel="stylesheet">
  <script src="assets/js/pace.min.js"></script>

  <!--plugins-->
  <link href="assets/plugins/perfect-scrollbar/css/perfect-scrollbar.css" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="assets/plugins/metismenu/metisMenu.min.css">
  <link rel="stylesheet" type="text/css" href="assets/plugins/metismenu/mm-vertical.css">
  <link href="assets/plugins/simplebar/css/simplebar.css" rel="stylesheet">
  <!--bootstrap css-->
  <link href="assets/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Noto+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Material+Icons+Outlined" rel="stylesheet">
  <!--main css-->
  <link href="assets/css/bootstrap-extended.css" rel="stylesheet">
  <link href="sass/main.css" rel="stylesheet">
  <link href="sass/dark-theme.css" rel="stylesheet">
  <link href="sass/blue-theme.css" rel="stylesheet">
  <link href="sass/semi-dark.css" rel="stylesheet">
  <link href="sass/bordered-theme.css" rel="stylesheet">
  <link href="sass/responsive.css" rel="stylesheet">

</head>

<body>

  <!--start header-->
  <header class="top-header">
    <nav class="navbar navbar-expand align-items-center gap-4">
      <div class="btn-toggle">
        <a href="javascript:;"><i class="material-icons-outlined">menu</i></a>
      </div>
      <div class="search-bar flex-grow-1">
        <div class="position-relative">
          <span class="material-icons-outlined position-absolute me-3 translate-middle-y end-0 top-50 search-close">close</span>
          <div class="search-popup p-3">
            <div class="card rounded-4 overflow-hidden">
              <div class="card-header d-lg-none">
                <div class="position-relative">
                </div>
              </div>
              <div class="card-body search-content">
                <p class="search-title">Recent Searches</p>
                <div class="d-flex align-items-start flex-wrap gap-2 kewords-wrapper">
                  <a href="javascript:;" class="kewords"><span>Angular Template</span><i
                      class="material-icons-outlined fs-6">search</i></a>
                  <a href="javascript:;" class="kewords"><span>Dashboard</span><i
                      class="material-icons-outlined fs-6">search</i></a>
                  <a href="javascript:;" class="kewords"><span>Admin Template</span><i
                      class="material-icons-outlined fs-6">search</i></a>
                  <a href="javascript:;" class="kewords"><span>Bootstrap 5 Admin</span><i
                      class="material-icons-outlined fs-6">search</i></a>
                  <a href="javascript:;" class="kewords"><span>Html eCommerce</span><i
                      class="material-icons-outlined fs-6">search</i></a>
                  <a href="javascript:;" class="kewords"><span>Sass</span><i
                      class="material-icons-outlined fs-6">search</i></a>
                  <a href="javascript:;" class="kewords"><span>laravel 9</span><i
                      class="material-icons-outlined fs-6">search</i></a>
                </div>
                <hr>
                <p class="search-title">Tutorials</p>
                <div class="search-list d-flex flex-column gap-2">
                  <div class="search-list-item d-flex align-items-center gap-3">
                    <div class="list-icon">
                      <i class="material-icons-outlined fs-5">play_circle</i>
                    </div>
                    <div class="">
                      <h5 class="mb-0 search-list-title ">Wordpress Tutorials</h5>
                    </div>
                  </div>
                  <div class="search-list-item d-flex align-items-center gap-3">
                    <div class="list-icon">
                      <i class="material-icons-outlined fs-5">shopping_basket</i>
                    </div>
                    <div class="">
                      <h5 class="mb-0 search-list-title">eCommerce Website Tutorials</h5>
                    </div>
                  </div>

                  <div class="search-list-item d-flex align-items-center gap-3">
                    <div class="list-icon">
                      <i class="material-icons-outlined fs-5">laptop</i>
                    </div>
                    <div class="">
                      <h5 class="mb-0 search-list-title">Responsive Design</h5>
                    </div>
                  </div>
                </div>

                <hr>
                <p class="search-title">Members</p>

                <div class="search-list d-flex flex-column gap-2">
                  <div class="search-list-item d-flex align-items-center gap-3">
                    <div class="memmber-img">
                      <img src="<?php echo $imagemUsuario; ?>" width="32" height="32" class="rounded-circle" alt="">
                    </div>
                    <div class="">
                      <h5 class="mb-0 search-list-title ">Andrew Stark</h5>
                    </div>
                  </div>

                  <div class="search-list-item d-flex align-items-center gap-3">
                    <div class="memmber-img">
                      <img src="assets/images/avatars/02.png" width="32" height="32" class="rounded-circle" alt="">
                    </div>
                    <div class="">
                      <h5 class="mb-0 search-list-title ">Snetro Jhonia</h5>
                    </div>
                  </div>

                  <div class="search-list-item d-flex align-items-center gap-3">
                    <div class="memmber-img">
                      <img src="assets/images/avatars/03.png" width="32" height="32" class="rounded-circle" alt="">
                    </div>
                    <div class="">
                      <h5 class="mb-0 search-list-title">Michle Clark</h5>
                    </div>
                  </div>

                </div>
              </div>
              <div class="card-footer text-center bg-transparent">
                <a href="javascript:;" class="btn w-100">See All Search Results</a>
              </div>
            </div>
          </div>
        </div>
      </div>
      <ul class="navbar-nav gap-1 nav-right-links align-items-center">
        <li class="nav-item d-lg-none mobile-search-btn">
          <a class="nav-link" href="javascript:;"><i class="material-icons-outlined">search</i></a>
        </li>




        <li class="nav-item dropdown">

          <div class="dropdown-menu dropdown-notify dropdown-menu-end shadow">
            <div class="px-3 py-1 d-flex align-items-center justify-content-between border-bottom">
              <h5 class="notiy-title mb-0">Notifications</h5>
              <div class="dropdown">
                <button class="btn btn-secondary dropdown-toggle dropdown-toggle-nocaret option" type="button"
                  data-bs-toggle="dropdown" aria-expanded="false">
                  <span class="material-icons-outlined">
                    more_vert
                  </span>
                </button>
                <div class="dropdown-menu dropdown-option dropdown-menu-end shadow">
                  <div><a class="dropdown-item d-flex align-items-center gap-2 py-2" href="javascript:;"><i
                        class="material-icons-outlined fs-6">inventory_2</i>Archive All</a></div>
                  <div><a class="dropdown-item d-flex align-items-center gap-2 py-2" href="javascript:;"><i
                        class="material-icons-outlined fs-6">done_all</i>Mark all as read</a></div>
                  <div><a class="dropdown-item d-flex align-items-center gap-2 py-2" href="javascript:;"><i
                        class="material-icons-outlined fs-6">mic_off</i>Disable Notifications</a></div>
                  <div><a class="dropdown-item d-flex align-items-center gap-2 py-2" href="javascript:;"><i
                        class="material-icons-outlined fs-6">grade</i>What's new ?</a></div>
                  <div>
                    <hr class="dropdown-divider">
                  </div>
                  <div><a class="dropdown-item d-flex align-items-center gap-2 py-2" href="javascript:;"><i
                        class="material-icons-outlined fs-6">leaderboard</i>Reports</a></div>
                </div>
              </div>
            </div>
            <div class="notify-list">
              <div>
                <a class="dropdown-item border-bottom py-2" href="javascript:;">
                  <div class="d-flex align-items-center gap-3">
                    <div class="">
                      <img src="<?php echo $imagemUsuario; ?>" class="rounded-circle" width="45" height="45" alt="">
                    </div>
                    <div class="">
                      <h5 class="notify-title">Congratulations Jhon</h5>
                      <p class="mb-0 notify-desc">Many congtars jhon. You have won the gifts.</p>
                      <p class="mb-0 notify-time">Today</p>
                    </div>
                    <div class="notify-close position-absolute end-0 me-3">
                      <i class="material-icons-outlined fs-6">close</i>
                    </div>
                  </div>
                </a>
              </div>
              <div>
                <a class="dropdown-item border-bottom py-2" href="javascript:;">
                  <div class="d-flex align-items-center gap-3">
                    <div class="user-wrapper bg-primary text-primary bg-opacity-10">
                      <span>RS</span>
                    </div>
                    <div class="">
                      <h5 class="notify-title">New Account Created</h5>
                      <p class="mb-0 notify-desc">From USA an user has registered.</p>
                      <p class="mb-0 notify-time">Yesterday</p>
                    </div>
                    <div class="notify-close position-absolute end-0 me-3">
                      <i class="material-icons-outlined fs-6">close</i>
                    </div>
                  </div>
                </a>
              </div>
              <div>
                <a class="dropdown-item border-bottom py-2" href="javascript:;">
                  <div class="d-flex align-items-center gap-3">
                    <div class="">
                      <img src="assets/images/apps/13.png" class="rounded-circle" width="45" height="45" alt="">
                    </div>
                    <div class="">
                      <h5 class="notify-title">Payment Recived</h5>
                      <p class="mb-0 notify-desc">New payment recived successfully</p>
                      <p class="mb-0 notify-time">1d ago</p>
                    </div>
                    <div class="notify-close position-absolute end-0 me-3">
                      <i class="material-icons-outlined fs-6">close</i>
                    </div>
                  </div>
                </a>
              </div>
              <div>
                <a class="dropdown-item border-bottom py-2" href="javascript:;">
                  <div class="d-flex align-items-center gap-3">
                    <div class="">
                      <img src="assets/images/apps/14.png" class="rounded-circle" width="45" height="45" alt="">
                    </div>
                    <div class="">
                      <h5 class="notify-title">New Order Recived</h5>
                      <p class="mb-0 notify-desc">Recived new order from michle</p>
                      <p class="mb-0 notify-time">2:15 AM</p>
                    </div>
                    <div class="notify-close position-absolute end-0 me-3">
                      <i class="material-icons-outlined fs-6">close</i>
                    </div>
                  </div>
                </a>
              </div>
              <div>
                <a class="dropdown-item border-bottom py-2" href="javascript:;">
                  <div class="d-flex align-items-center gap-3">
                    <div class="">
                      <img src="<?php echo $imagemUsuario; ?>" class="rounded-circle" width="45" height="45" alt="">
                    </div>
                    <div class="">
                      <h5 class="notify-title">Congratulations Jhon</h5>
                      <p class="mb-0 notify-desc">Many congtars jhon. You have won the gifts.</p>
                      <p class="mb-0 notify-time">Today</p>
                    </div>
                    <div class="notify-close position-absolute end-0 me-3">
                      <i class="material-icons-outlined fs-6">close</i>
                    </div>
                  </div>
                </a>
              </div>
              <div>
                <a class="dropdown-item py-2" href="javascript:;">
                  <div class="d-flex align-items-center gap-3">
                    <div class="user-wrapper bg-danger text-danger bg-opacity-10">
                      <span>PK</span>
                    </div>
                    <div class="">
                      <h5 class="notify-title">New Account Created</h5>
                      <p class="mb-0 notify-desc">From USA an user has registered.</p>
                      <p class="mb-0 notify-time">Yesterday</p>
                    </div>
                    <div class="notify-close position-absolute end-0 me-3">
                      <i class="material-icons-outlined fs-6">close</i>
                    </div>
                  </div>
                </a>
              </div>
            </div>
          </div>
        </li>

        <li class="nav-item dropdown">
          <a href="javascrpt:;" class="dropdown-toggle dropdown-toggle-nocaret" data-bs-toggle="dropdown">
            <img src="<?php echo $imagemUsuario; ?>" class="rounded-circle p-1 border" width="45" height="45" alt="">
          </a>
          <div class="dropdown-menu dropdown-user dropdown-menu-end shadow">
            <a class="dropdown-item  gap-2 py-2" href="javascript:;">
              <div class="text-center">
                <img src="<?php echo $imagemUsuario; ?>" class="rounded-circle p-1 shadow mb-3" width="90" height="90"
                  alt="">
                <h5 class="user-name mb-0 fw-bold">Olá, <?php echo $nome['nome']; ?></h5>
              </div>
            </a>
            <hr class="dropdown-divider">

            <a class="dropdown-item d-flex align-items-center gap-2 py-2" href="sair.php"><i
                class="material-icons-outlined">power_settings_new</i>Logout</a>
          </div>
        </li>
      </ul>

    </nav>
  </header>
  <!--end top header-->


  <!--start sidebar-->
  <aside class="sidebar-wrapper" data-simplebar="true">
    <div class="sidebar-header">
      <div class="logo-icon">
        <img src="assets/images/logo-icon-ideia.png" class="logo-img" alt="">
      </div>
      <div class="logo-name flex-grow-1">
      </div>
      <div class="sidebar-close">
        <span class="material-icons-outlined">close</span>
      </div>
    </div>
    <div class="sidebar-nav">
      <!--navigation-->
      <ul class="metismenu" id="sidenav">
        <li>
          <a href="index.php">
            <div class="parent-icon"><i class="material-icons-outlined">home</i>
            </div>
            <div class="menu-title">Home</div>
          </a>

        </li>

        <li>
          <a class="has-arrow" href="javascript:;">
            <div class="parent-icon"><i class="material-icons-outlined">apps</i>
            </div>
            <div class="menu-title">Apps</div>
          </a>
          <?php if ($id == 1) { ?>
            <ul>

              <li><a href="transacoes.php"><i class="material-icons-outlined">arrow_right</i>Realizar Transação</a>
              </li>
            </ul>

            <ul>

              <li><a href="saldo.php"><i class="material-icons-outlined">arrow_right</i>Transações</a>
              </li>
            </ul>
        </li>
      <?php } ?>
      <li class="menu-label">Pages</li>

      <li>
        <a href="user-profile.php">
          <div class="parent-icon"><i class="material-icons-outlined">person</i>
          </div>
          <div class="menu-title">Perfil de usuário</div>
        </a>
      </li>

      </ul>
      <!--end navigation-->
    </div>
  </aside>
  <!--end sidebar-->



  <!--start main wrapper-->
  <main class="main-wrapper">
    <div class="main-content">
      <!--breadcrumb-->
      <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">Realizar Transação</div>

        
      </div>
      <!--end breadcrumb-->
      <div class="card radius-10">
        <div class="card-header py-3">
          <div class="row align-items-center g-3">
            <div class="col-12 col-lg-6">
              <h5 class="mb-0">Registrar transação</h5>
            </div>

          </div>
        </div>

        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-invoice">

              <thead>

              </thead>
              <tbody>
                <tr>
                  <form action="transacoes.php" method="post" enctype="multipart/form-data">

                    <div class="row row-cols-1 row-cols-lg-3" style="margin-bottom: 10px;">

                      <div class="">
                        <h5>Cliente</h5>
                        <input class="form-control" type="text" id="cliente" placeholder="Cliente" name="cliente" required>
                      </div>

                    </div>



          </div>

          <div class="mb-4">
            <h5 class="mb-3">Data</h5>
            <input type="date" name="dat" id="dat" class="form-control rounded-0" required>
          </div>

          <div class="mb-4">
            <h5 class="mb-3">Descrição</h5>
            <textarea class="form-control" cols="4" rows="6" placeholder="Escreva a descrição aqui..." id="descricao" name="descricao"></textarea>
          </div>


          <div class="mb-4">
            <h5 class="mb-3">Valor</h5>
            <input class="form-control" type="text" id="money" placeholder="R$ 0,00" name="valor" required>

          </div>

          <!--Código para formatar a entrada do valor-->
          <script>
            const moneyInput = document.getElementById("money");
            const form = document.getElementById("form");

            // Formatar valor em tempo real
            moneyInput.addEventListener("input", (e) => {
              let value = e.target.value.replace(/\D/g, ""); // Remove todos os não-dígitos
              value = (value / 100).toFixed(2); // Divide por 100 e mantém duas casas decimais
              e.target.value = "R$ " + value.replace(".", ","); // Formata como moeda BRL
            });
          </script>

          <div class="form-check">
            <input type="hidden" name="saida" value="0">
            <input class="form-check-input" type="checkbox" value="1" id="saida" name="saida">
            <label class="form-check-label" for="saida">Saída</label>
          </div>
          <div class="card">


            <!-- PARTE DE COMISSAO-->

            <div class="card-body" id="conteudo">
              <div class="card-title">
                <h4 class="mb-0">Comissionar</h4>
              </div>


              <?php foreach ($usuarios as $usuario):
                $imagemUsuario2 = "assets/users/default.png"; // Imagem padrão
                foreach (["jpg", "jpeg", "png"] as $ext) {
                  if (file_exists("assets/users/" . $usuario['id'] . "." . $ext)) {
                    $imagemUsuario2 = "assets/users/" . $usuario['id'] . "." . $ext;
                    break;
                  }
                }
              ?>
                <div>
                  <div class="chip" data-id="<?php echo $usuario['id']; ?>">
                    <img src="<?php echo $imagemUsuario2; ?>" alt="Contact Person">
                    <?php echo htmlspecialchars($usuario['nome']); ?>
                  </div>

                  <div class="col-md-2" id="text-input-container-<?php echo $usuario['id']; ?>" style="display: none;">
                    <input style="margin-bottom: 10px;" class="form-control" type="text" id="valorcom<?php echo $usuario['id']; ?>" placeholder="R$ 0,00" name="valorcom<?php echo $usuario['id']; ?>">
                  </div>

                  <script>
                    // A cada clique na chip, alterna a visibilidade da caixa de entrada
                    document.querySelector('.chip[data-id="<?php echo $usuario['id']; ?>"]').addEventListener('click', function() {
                      const textInputContainer = document.getElementById('text-input-container-<?php echo $usuario['id']; ?>');

                      // Alterna a visibilidade da caixa de entrada
                      function toggleVisibility() {
                        if (textInputContainer.style.display === 'none') {
                          textInputContainer.style.display = 'block';
                        } else {
                          textInputContainer.style.display = 'none';
                        }
                      }

                      toggleVisibility(); // Chama a função para alternar a visibilidade ao clicar

                      // Adiciona a formatação BRL ao campo de input
                      textInputContainer.querySelector('input').addEventListener('input', (e) => {
                        let value = e.target.value.replace(/\D/g, ""); // Remove todos os caracteres que não são números
                        value = (value / 100).toFixed(2); // Mantém duas casas decimais
                        e.target.value = "R$ " + value.replace(".", ","); // Formata como moeda BRL
                      });
                    });
                  </script>
                </div>
              <?php endforeach; ?>

            </div>

            <script>
              document.getElementById("saida").addEventListener("change", function() {
                const conteudo = document.getElementById("conteudo");
                conteudo.style.display = this.checked ? "none" : "block";
              });
            </script>

            <button style="margin-top: 10px;" type="submit" name="submit" class="btn btn-grd-primary">Enviar</button>

            </form>
            </tr>
            </tbody>
            </table>
          </div>







        </div>
      </div>
  </main>
  <!--end main wrapper-->

  <!--start overlay-->
  <div class="overlay btn-toggle"></div>
  <!--end overlay-->
  <!--start footer-->
  <footer class="page-footer">
    <p class="mb-0">Copyright © 2024. All right reserved.</p>
  </footer>
  <!--top footer-->

  <!--start cart-->
  <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasCart">
    <div class="offcanvas-header border-bottom h-70">
      <h5 class="mb-0" id="offcanvasRightLabel">8 New Orders</h5>
      <a href="javascript:;" class="primaery-menu-close" data-bs-dismiss="offcanvas">
        <i class="material-icons-outlined">close</i>
      </a>
    </div>
    <div class="offcanvas-body p-0">
      <div class="order-list">
        <div class="order-item d-flex align-items-center gap-3 p-3 border-bottom">
          <div class="order-img">
            <img src="assets/images/orders/01.png" class="img-fluid rounded-3" width="75" alt="">
          </div>
          <div class="order-info flex-grow-1">
            <h5 class="mb-1 order-title">White Men Shoes</h5>
            <p class="mb-0 order-price">$289</p>
          </div>
          <div class="d-flex">
            <a class="order-delete"><span class="material-icons-outlined">delete</span></a>
            <a class="order-delete"><span class="material-icons-outlined">visibility</span></a>
          </div>
        </div>

        <div class="order-item d-flex align-items-center gap-3 p-3 border-bottom">
          <div class="order-img">
            <img src="assets/images/orders/02.png" class="img-fluid rounded-3" width="75" alt="">
          </div>
          <div class="order-info flex-grow-1">
            <h5 class="mb-1 order-title">Red Airpods</h5>
            <p class="mb-0 order-price">$149</p>
          </div>
          <div class="d-flex">
            <a class="order-delete"><span class="material-icons-outlined">delete</span></a>
            <a class="order-delete"><span class="material-icons-outlined">visibility</span></a>
          </div>
        </div>

        <div class="order-item d-flex align-items-center gap-3 p-3 border-bottom">
          <div class="order-img">
            <img src="assets/images/orders/03.png" class="img-fluid rounded-3" width="75" alt="">
          </div>
          <div class="order-info flex-grow-1">
            <h5 class="mb-1 order-title">Men Polo Tshirt</h5>
            <p class="mb-0 order-price">$139</p>
          </div>
          <div class="d-flex">
            <a class="order-delete"><span class="material-icons-outlined">delete</span></a>
            <a class="order-delete"><span class="material-icons-outlined">visibility</span></a>
          </div>
        </div>

        <div class="order-item d-flex align-items-center gap-3 p-3 border-bottom">
          <div class="order-img">
            <img src="assets/images/orders/04.png" class="img-fluid rounded-3" width="75" alt="">
          </div>
          <div class="order-info flex-grow-1">
            <h5 class="mb-1 order-title">Blue Jeans Casual</h5>
            <p class="mb-0 order-price">$485</p>
          </div>
          <div class="d-flex">
            <a class="order-delete"><span class="material-icons-outlined">delete</span></a>
            <a class="order-delete"><span class="material-icons-outlined">visibility</span></a>
          </div>
        </div>

        <div class="order-item d-flex align-items-center gap-3 p-3 border-bottom">
          <div class="order-img">
            <img src="assets/images/orders/05.png" class="img-fluid rounded-3" width="75" alt="">
          </div>
          <div class="order-info flex-grow-1">
            <h5 class="mb-1 order-title">Fancy Shirts</h5>
            <p class="mb-0 order-price">$758</p>
          </div>
          <div class="d-flex">
            <a class="order-delete"><span class="material-icons-outlined">delete</span></a>
            <a class="order-delete"><span class="material-icons-outlined">visibility</span></a>
          </div>
        </div>

        <div class="order-item d-flex align-items-center gap-3 p-3 border-bottom">
          <div class="order-img">
            <img src="assets/images/orders/06.png" class="img-fluid rounded-3" width="75" alt="">
          </div>
          <div class="order-info flex-grow-1">
            <h5 class="mb-1 order-title">Home Sofa Set </h5>
            <p class="mb-0 order-price">$546</p>
          </div>
          <div class="d-flex">
            <a class="order-delete"><span class="material-icons-outlined">delete</span></a>
            <a class="order-delete"><span class="material-icons-outlined">visibility</span></a>
          </div>
        </div>

        <div class="order-item d-flex align-items-center gap-3 p-3 border-bottom">
          <div class="order-img">
            <img src="assets/images/orders/07.png" class="img-fluid rounded-3" width="75" alt="">
          </div>
          <div class="order-info flex-grow-1">
            <h5 class="mb-1 order-title">Black iPhone</h5>
            <p class="mb-0 order-price">$1049</p>
          </div>
          <div class="d-flex">
            <a class="order-delete"><span class="material-icons-outlined">delete</span></a>
            <a class="order-delete"><span class="material-icons-outlined">visibility</span></a>
          </div>
        </div>

        <div class="order-item d-flex align-items-center gap-3 p-3 border-bottom">
          <div class="order-img">
            <img src="assets/images/orders/08.png" class="img-fluid rounded-3" width="75" alt="">
          </div>
          <div class="order-info flex-grow-1">
            <h5 class="mb-1 order-title">Goldan Watch</h5>
            <p class="mb-0 order-price">$689</p>
          </div>
          <div class="d-flex">
            <a class="order-delete"><span class="material-icons-outlined">delete</span></a>
            <a class="order-delete"><span class="material-icons-outlined">visibility</span></a>
          </div>
        </div>
      </div>
    </div>
    <div class="offcanvas-footer h-70 p-3 border-top">
      <div class="d-grid">
        <button type="button" class="btn btn-grd btn-grd-primary" data-bs-dismiss="offcanvas">View Products</button>
      </div>
    </div>
  </div>
  <!--end cart-->





  <!--bootstrap js-->
  <script src="assets/js/bootstrap.bundle.min.js"></script>

  <!--plugins-->
  <script src="assets/js/jquery.min.js"></script>
  <!--plugins-->
  <script src="assets/plugins/perfect-scrollbar/js/perfect-scrollbar.js"></script>
  <script src="assets/plugins/metismenu/metisMenu.min.js"></script>
  <script src="assets/plugins/simplebar/js/simplebar.min.js"></script>
  <script src="assets/js/main.js"></script>


</body>

</html>