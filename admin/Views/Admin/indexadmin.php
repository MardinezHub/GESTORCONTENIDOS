<?php
  session_start();

  if (!isset($_SESSION['userId'])) {
      header("Location: ../../index.php");
      exit();
  }

  include_once '../../conexion.php';
  include_once '../../Controller/usuarioController.php';
  include_once '../../Model/usuarioModel.php';
  $usuarioModel = new usuarioModel();
  $usuarios = $usuarioModel->listarUsuario();
  $headers = $usuarioModel->headerlista();
  $conexion = conectarse();

  $sql = "SELECT tbusuario.dniusuario, tbusuario.nomusuario, tbusuario.apusuario, tbusuario.correousuario,tbusuario.telefono, tbusuario.direccion, tbrol.nomrol
          FROM tbusuario
          INNER JOIN tbrol ON tbusuario.fk_idrol = tbrol.idrol
          WHERE tbusuario.dniusuario = ?";

  $stmt = $conexion->prepare($sql);
  $stmt->bind_param("s", $_SESSION['userId']);
  $stmt->execute();
  $result = $stmt->get_result();

  if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $nombreCompleto = $row['nomusuario'] . ' ' . $row['apusuario'];
    $nombre = $row['nomusuario'];
    $apellido = $row['apusuario'];
    $correo = $row['correousuario'];
    $rol = $row['nomrol'];
    $telefono = $row['telefono'];
    $direccion = $row['direccion'];
  } else {

    echo "Error: Usuario no encontrado";
    exit();
  }

  $stmt->close();
  $conexion->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>Perfil - Administrador</title>
  <!-- Favicons -->
  <link href="../../source/img/favicon.png" rel="icon">
  <link href="../../source/img/apple-touch-icon.png" rel="apple-touch-icon">
  <!-- Google Fonts -->
  <link href="https://fonts.gstatic.com" rel="preconnect">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">
  <!-- Vendor CSS Files -->
  <link href="../../source/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="../../source/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="../../source/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="../../source/vendor/quill/quill.snow.css" rel="stylesheet">
  <link href="../../source/vendor/quill/quill.bubble.css" rel="stylesheet">
  <link href="../../source/vendor/remixicon/remixicon.css" rel="stylesheet">
  <link href="../../source/vendor/simple-datatables/style.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <!-- Template Main CSS File -->
  <link href="../../source/css/style.css" rel="stylesheet">
</head>
<body>
  <header id="header" class="header fixed-top d-flex align-items-center">
  <div class="d-flex align-items-center justify-content-between">
      <a href="indexadmin.php" class="logo d-flex align-items-center">
        <span class="d-none d-lg-block text-light">UNJBG</span>
      </a>
      <i class="bi bi-list toggle-sidebar-btn text-light"></i>
    </div>
    <nav class="header-nav ms-auto">
      <ul class="d-flex align-items-center">
        <li class="nav-item dropdown pe-3">
          <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
            <img src="../../source/img/empresario.png">
            <span class="d-none d-md-block dropdown-toggle ps-2 text-light"><?php echo $nombreCompleto; ?></span>
          </a>
          <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
            <li class="dropdown-header">
              <img src="../../source/img/empresario.png" style="width: 90px; height:90px;">
              <h6><?php echo $nombreCompleto; ?></h6>
              <span><?php echo $rol; ?></span>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>
          </ul>
        </li>
      </ul>
    </nav>
  </header>
  <aside id="sidebar" class="sidebar">
    <ul class="sidebar-nav" id="sidebar-nav">
      <li class="nav-item">
        <a class="nav-link " href="indexadmin.php">
          <i class="bi bi-person-check"></i>
          <span>Perfil</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#components-nav" data-bs-toggle="collapse" href="#">
          <i class="bi bi-clipboard2-check"></i><span>Inicio</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="components-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
          <li>
            <a href="informacionadmin.php">
              <i class="bi bi-circle"></i><span>Administrar Información</span>
            </a>
          </li>
          <li>
            <a href="listaadmin.php">
              <i class="bi bi-circle"></i><span>Administrar Listas</span>
            </a>
          </li>
          <li>
            <a href="personaladmin.php">
              <i class="bi bi-circle"></i><span>Administrar Integrantes</span>
            </a>
          </li>
          <li>
            <a href="paginasadmin.php">
              <i class="bi bi-circle"></i><span>Administrar Páginas</span>
            </a>
          </li>          
        </ul>
      </li>
      <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#forms-nav" data-bs-toggle="collapse" href="#">
          <i class="bi bi-people-fill"></i><span>Usuarios</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="forms-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
          <li>
            <a href="usuariosadmin.php">
              <i class="bi bi-circle"></i><span>Administrar Usuarios</span>
            </a>
          </li>
        </ul>
      </li>  
      <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#tables-nav" data-bs-toggle="collapse" href="#">
          <i class="bi bi-card-text"></i><span>Publicaciones</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="tables-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
          <li>
                <a href="publicacionadmin.php">
                <i class="bi bi-circle"></i><span>Administrar Comunicados</span>
                </a>
            </li>
            <li>
                <a href="noticiaadmin.php">
                <i class="bi bi-circle"></i><span>Administrar Noticias</span>
                </a>
            </li>
            <li>
                <a href="fotoadmin.php">
                <i class="bi bi-circle"></i><span>Administrar Fotos</span>
                </a>
            </li>
        </ul>
      </li>
      <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#charts-nav" data-bs-toggle="collapse" href="#">
        <i class="bi bi-journal-check"></i><span>Archivos o Enlaces</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="charts-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
          <li>
            <a href="legaladmin.php">
              <i class="bi bi-circle"></i><span>Administrar Marco <br/> Legal</span>
            </a>
          </li>
          <li>
            <a href="multimediaadmin.php">
              <i class="bi bi-circle"></i><span>Administrar Multimedia</span>
            </a>
          </li>
          <li>
            <a href="enlacesadmin.php">
              <i class="bi bi-circle"></i><span>Administrar Enlace Directo</span>
            </a>
          </li>
          <li>
            <a href="redesadmin.php">
              <i class="bi bi-circle"></i><span>Administrar Redes Sociales</span>
            </a>
          </li>
        </ul>
      </li>      
      <br><br>
      <li>
        <center>
          <a class="btn btn-danger rounded" href="../../index.php">Cerrar Sesión</a>
        </center>
      </li>
    </ul>
  </aside>
  <main id="main" class="main">
    <div class="pagetitle">
      <center>
      <h1>Bienvenido <?php echo $rol ?> al Gestor de Contenidos</h1>
      </center>
    </div>    
    <section class="section dashboard">
      <div class="row justify-content-center">
        <div class="col-lg-6">
            <div class="card mx-auto">
                <div class="card-body d-flex flex-column align-items-center">
                <h5 class="card-title">Perfil del Usuario</h5>
                  <form class="row g-3" action="../../Controller/usuarioController.php" method="POST" onsubmit="mostrarAlerta()">
                    <div class="col-12">
                      <label for="dniusuario" class="form-label">Documento Nacional de Identidad (DNI):</label>
                      <input type="number" class="form-control" id="dniusuario" name="dniusuario" value="<?php echo $_SESSION['userId']; ?>" readonly>
                    </div>
                    <div class="col-12">
                      <label for="nomusuario" class="form-label">Nombres Completos:</label>
                      <input type="text" class="form-control" id="nomusuario" name="nomusuario" value="<?php echo $nombre; ?>">
                    </div>
                    <div class="col-12">
                      <label for="apusuario" class="form-label">Apellidos Completos:</label>
                      <input type="text" class="form-control" id="apusuario" name="apusuario" value="<?php echo $apellido; ?>">
                    </div>
                    <div class="col-12">
                      <label for="correousuario" class="form-label">Correo Electrónico Personal:</label>
                      <input type="text" class="form-control" id="correousuario" name="correousuario" value="<?php echo $correo; ?>">
                    </div>
                    <div class="col-12">
                      <label for="telefono" class="form-label">Telefono:</label>
                      <input type="number" class="form-control" id="telefono" name="telefono" value="<?php echo $telefono; ?>">
                    </div>
                    <div class="col-12">
                      <label for="direccion" class="form-label">Dirección:</label>
                      <input type="text" class="form-control" id="direccion" name="direccion" value="<?php echo $direccion; ?>">
                    </div>
                    <input type="hidden" name="accion" value="updateadmin">
                    <div class="text-center">
                      <button type="submit"  class="btn btn-primary" >Modificar Perfil de Usuario</button>           
                    </div>
                  </form>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card mx-auto">
                <div class="card-body d-flex flex-column align-items-center">
                <h5 class="card-title">Correo - Color - Contacto</h5>
                  <form class="row g-3" action="../../Controller/usuarioController.php" method="POST">
                    <div class="col-12">
                      <label for="correo" class="form-label">Correo Electrónico de la Oficina:</label>
                      <input type="text" class="form-control" id="correo" name="correo" value="<?php echo $headers['correo'] ?>">
                    </div>
                    <div class="col-12">
                      <label for="telefono" class="form-label">Telefono de Contacto:</label>
                      <input type="number" class="form-control" id="telefono" name="telefono" value="<?php echo $headers['telefono'] ?>">
                    </div>
                    <div class="col-5">
                      <label for="color" class="form-label">Color de Barra:</label>
                      <input type="color" class="form-control" id="color" name="color" value="<?php echo $headers['color'] ?>">
                    </div>
                    <input type="hidden" name="accion" value="actualizarheader">
                    <div class="text-center">
                      <button type="submit"  class="btn btn-primary" >Modificar Información</button>           
                    </div>
                  </form>
                </div>
            </div>
        </div>
      </div>
    </section>
  </main>
  <footer class="footer" id="footer">
    <div class="copyright">
      &copy; Copyright <strong><span>UNJBG</span></strong>. Todos los derechos reservados.
    </div>
  </footer>
  <script src="../../source/vendor/apexcharts/apexcharts.min.js"></script>
  <script src="../../source/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="../../source/vendor/chart.js/chart.umd.js"></script>
  <script src="../../source/vendor/echarts/echarts.min.js"></script>
  <script src="../../source/vendor/quill/quill.js"></script>
  <script src="../../source/vendor/simple-datatables/simple-datatables.js"></script>
  <script src="../../source/vendor/tinymce/tinymce.min.js"></script>
  <script src="../../source/vendor/php-email-form/validate.js"></script>
  <script src="../../source/js/main.js"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="../../source/js/alert.js"></script>
  <script>
      function mostrarAlerta() {
        alert("¡Su perfil se ha actualizado correctamente!");
      }
  </script>
</body>
</html>