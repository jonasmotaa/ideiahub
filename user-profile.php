<?php
session_start();
if ((!isset($_SESSION['email']) == true) and (!isset($_SESSION['senha']) == true)) {
  unset($_SESSION['email']);
  unset($_SESSION['senha']);
  header('Location: login.php'); // se nao existir sessao, retorna para login.php

}
include_once('php/conexao.php');

$email = $_SESSION['email'];
$sql = "SELECT nome FROM usuario WHERE email = '$email'";
$result =  $mysqli->query($sql);
$nome = $result->fetch_assoc();

$sql = "SELECT id FROM usuario WHERE email = '$email'";
$result = $mysqli->query($sql);
$row = $result->fetch_assoc();  // Obtém a linha como array associativo
$id = $row['id'];              // Extrai o valor do ID

$sql = "SELECT adm FROM usuario WHERE email = '$email'";
$result = $mysqli->query($sql);
$row = $result->fetch_assoc();  // Obtém a linha como array associativo
$adm = $row['adm'];              // Extrai o valor do ADM

if (isset($_POST['submit'])) {

  include_once('php/conexao.php');

  $nomeusr = $_POST['nome'];
  $email = $_POST['email'];
  $senha = $_POST['senha'];

  if (isset($_POST['administrar'])) {
    $administrar = $_POST['administrar'];
  } else {
    $administrar = 0; // Valor padrão se a checkbox não for marcada.
  }

  $sql = "SELECT email FROM usuario WHERE usuario.email = '$email'";
  $result =  $mysqli->query($sql);
  if ($result->num_rows > 0) {
    echo '<div style="text-align: center;">';
    echo 'Já existe um usuário cadastrado com esse email.';
    echo '</div>';
  } else {
    mysqli_query($mysqli, "INSERT INTO usuario(email, nome, senha, adm)
  VALUES ('$email','$nomeusr','$senha', '$administrar')");
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
  <title>Perfil do usuário</title>
  <!--favicon-->
  <link rel="icon" href="assets/images/favicon-32x32.png" type="image/png">
  <!-- loader-->
  <link href="assets/css/pace.min.css" rel="stylesheet">
  <script src="assets/js/pace.min.js"></script>

  <!--plugins-->
  <link href="assets/plugins/perfect-scrollbar/css/perfect-scrollbar.css" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="assets/plugins/metismenu/metisMenu.min.css">
  <link rel="stylesheet" type="text/css" href="assets/plugins/metismenu/mm-vertical.css">
  <link rel="stylesheet" type="text/css" href="assets/plugins/simplebar/css/simplebar.css">
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
                    <img src="<?php echo $imagemUsuario; ?>" class="img-fluid rounded-circle p-1 bg-grd-danger shadow" width="32" height="32" alt="">
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
                      <img src="assets/images/avatars/01.png" class="rounded-circle" width="45" height="45" alt="">
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
                      <img src="assets/images/avatars/06.png" class="rounded-circle" width="45" height="45" alt="">
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
          <img src="<?php echo $imagemUsuario; ?>" class="img-fluid rounded-circle p-1 bg-grd-danger shadow" width="45" height="45" alt="">
          </a>
          <div class="dropdown-menu dropdown-user dropdown-menu-end shadow">
            <a class="dropdown-item  gap-2 py-2" href="javascript:;">
              <div class="text-center">
              <img src="<?php echo $imagemUsuario; ?>" class="img-fluid rounded-circle p-1 bg-grd-danger shadow" width="90" height="90" alt="">
                <h5 class="user-name mb-0 fw-bold">Olá, <?php echo $nome['nome'];?></h5>
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
            <div class="menu-title">Perfil do usuário</div>
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
        <div class="breadcrumb-title pe-3">IdeiaHub</div>
        <div class="ps-3">
          <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0 p-0">
              <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
              </li>
              <li class="breadcrumb-item active" aria-current="page">Perfil do usuário</li>
            </ol>
          </nav>
        </div>

      </div>
      <!--end breadcrumb-->


      <div class="card rounded-4">
        <div class="card-body p-4">
          <div class="position-relative mb-5">
            <img src="assets/images/gallery/profile-cover.png" class="img-fluid rounded-4 shadow" alt="">
            <div class="profile-avatar position-absolute top-100 start-50 translate-middle">
<img src="<?php echo $imagemUsuario; ?>" class="img-fluid rounded-circle p-1 bg-grd-danger shadow" width="170" height="170" alt="">
            </div>
          </div>
          <div class="profile-info pt-5 d-flex align-items-center justify-content-between">
            <div class="">
              <h3><?php echo $nome['nome']; ?></h3>

            </div>

          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-12 col-xl-16">
          <div class="card rounded-4 border-top border-4 border-primary border-gradient-1">
            <div class="card-body p-4">
              <div class="d-flex align-items-start justify-content-between mb-3">
                <div class="">
                  <h5 class="mb-0 fw-bold">Editar perfil</h5>
                </div>
                <div class="dropdown">
                  <a href="javascript:;" class="dropdown-toggle-nocaret options dropdown-toggle"
                    data-bs-toggle="dropdown">
                    <span class="material-icons-outlined fs-5">more_vert</span>
                  </a>
                  <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="javascript:;">Action</a></li>
                    <li><a class="dropdown-item" href="javascript:;">Another action</a></li>
                    <li><a class="dropdown-item" href="javascript:;">Something else here</a></li>
                  </ul>
                </div>
              </div>
              <form class="row g-4" method="POST" action="atualizarcadastro.php">


                <div class="col-md-12">
                  <label for="input4" class="form-label">Email</label>
                  <input type="email" name="emailnovo" class="form-control" id="emailnovo" required>
                </div>
                <div class="col-md-12">
                  <label for="input5" class="form-label">Senha</label>
                  <input type="password" name="senhanovo" class="form-control" id="senhanovo" required>
                </div>



                <div class="col-md-12">
                  <div class="d-md-flex d-grid align-items-center gap-3">
                    <button type="submit" name="submit2" id="submit2" class="btn btn-grd-primary px-4">Atualizar perfil</button>
                  </div>
                </div>
              </form>

              <form class="row g-4" method="POST" action="trocarpfp.php" enctype="multipart/form-data">
                <div class="mb-4" style="padding-top: 50px;">
                  <label for="file">Trocar foto de perfil:</label>
                  <input type="file" name="file" id="file">
                  <div style="padding-top: 20px;">
                    <button type="submit" name="submit3" id="submit3" class="btn btn-grd-primary px-4">Atualizar foto</button>
                  </div>
                </div>
              </form>



            </div>
          </div>
        </div>

        <?php if ($adm == 1) { ?>
          <div class="section-authentication-cover">
            <div class="">


              <div class="card rounded-5 m-3 border-0 shadow-none bg-none">
                <div class="card-body p-sm-5">
                  <img src="assets/images/logoideiahub.png" class="mb-4" width="145" alt="">
                  <h4 class="fw-bold">Criar uma conta</h4>
                  <p class="mb-0">Crie as credenciais para o novo usuário</p>



                  <div class="form-body mt-4">
                    <form class="row g-3" action="user-profile.php" method="POST">
                      <div class="col-12">
                        <label for="inputUsername" class="form-label">Username</label>
                        <input type="text" name="nome" class="form-control" id="nome" placeholder="Nome">
                      </div>
                      <div class="col-12">
                        <label for="inputEmailAddress" class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" id="email" placeholder="exemplo@ideianinja.onmicrosoft.com" required>
                      </div>
                      <div class="col-12">
                        <label for="senha" class="form-label">Senha</label>
                        <div class="input-group" id="show_hide_password">
                          <input type="password" name="senha" class="form-control" id="senha" placeholder="Senha" required>
                          <a href="javascript:;" class="input-group-text bg-transparent"><i class="bi bi-eye-slash-fill"></i></a>
                        </div>
                      </div>

                      <div class="form-check">
                        <input type="hidden" name="administrar" value="0">
                        <input class="form-check-input" type="checkbox" value="1" id="administrar" name="administrar">
                        <label class="form-check-label" for="saida">Administrador</label>
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
            <!--end row-->
          </div>
        <?php } ?>
      </div><!--end row-->



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