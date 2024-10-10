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

  $conexion = conectarse();

  $sql = "SELECT tbusuario.dniusuario, tbusuario.nomusuario, tbusuario.apusuario, tbusuario.correousuario, tbrol.nomrol
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
  <title>Administrar Usuarios - Administrador</title>
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
  <!-- Template Main CSS File -->
  <link href="../../source/css/style.css" rel="stylesheet">
  <!-- DataTables JBootstrap -->
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.css">
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
            <img src="../../source/img/empresario.png" alt="Empresario pequeño">
            <span class="d-none d-md-block dropdown-toggle ps-2 text-light"><?php echo $nombreCompleto; ?></span>
          </a>
          <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
            <li class="dropdown-header">
              <img src="../../source/img/empresario.png" style="width: 90px; height:90px;" alt="Empresario">
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
          <a class="btn btn-danger rounded" href="../../index.php">Cerrar Sesión</a>
      </li>  
    </ul>
  </aside>
  <main id="main" class="main">
    <div class="pagetitle">
        <h1>Gestor de Contenidos - Usuarios Registrados</h1>
    </div>
    <a class="btn btn-primary" id="registrarusuario">+ Crear Usuario</a><br/><br/>
    <section class="section dashboard">
      <div class="row">
        <div class="card">
            <div class="card-body">
              <h5 class="card-title">Tabla de Usuarios</h5>
               <div class="table-responsive">
                <table class="table" id="table_id">
                    <thead>
                      <tr>
                        <th scope="col">Documento Nacional de Identidad (DNI)</th>
                        <th scope="col">Nombres Completos</th>
                        <th scope="col">Apellidos Completos</th>
                        <th scope="col">Correo Electrónico</th>
                        <th scope="col">Direccion</th>
                        <th scope="col">Telefono</th>
                        <th scope="col">Rol de Usuario</th>
                        <th scope="col">Estado</th>
                        <th scope="col">Acciones</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php foreach ($usuarios as $usuario): ?>
                          <tr class="align-middle">
                              <td><strong><?php echo $usuario['dniusuario']; ?></strong></td>
                              <td><?php echo $usuario['nomusuario']; ?></td>
                              <td><?php echo $usuario['apusuario']; ?></td>
                              <td><?php echo $usuario['correousuario']; ?></td>
                              <td><?php echo $usuario['direccion']; ?></td>
                              <td><?php echo $usuario['telefono']; ?></td>
                              <td><strong><center><?php echo ($usuario['fk_idrol'] == 1) ? 'Administrador' : 'Personal'; ?></center></strong></td>
                              <td><strong><?php echo ($usuario['estado'] == 1) ? 'Activo' : 'Inactivo'; ?></strong></td>
                              <td>
                              <button class="btn btn-secondary editar-btn" data-usuario='<?php echo json_encode($usuario); ?>'>Editar Usuario</button>
                              </td>
                          </tr>
                      <?php endforeach; ?>
                  </tbody>
                </table>
               </div>
            </div>
    </section>
  </main>
    <footer id="footer" class="footer">
      <div class="copyright">
        &copy; Copyright <strong><span>UNJBG</span></strong>. Todos los derechos reservados.
      </div>
    </footer>
    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>
    <!-- Modal -->
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Editar Usuario</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <form id="editForm" action="../../Controller/usuarioController.php" method="POST" enctype="multipart/form-data">
              <div class="row mb-3">
                <div class="col-md-6">
                  <label for="edit-dniusuario" class="form-label">Documento Nacional de Identidad (DNI):</label>
                  <input type="number" id="edit-dniusuario" name="dniusuario" class="form-control" readonly/>
                </div>
                <div class="col-md-6">
                  <label for="edit-nomusuario" class="form-label">Nombres Completos:</label>
                  <input type="text" id="edit-nomusuario" name="nomusuario" class="form-control" />
                </div>
              </div>
              <div class="row mb-3">
                <div class="col-md-6">
                  <label for="edit-apusuario" class="form-label">Apellidos Completos:</label>
                  <input type="text" id="edit-apusuario" name="apusuario" class="form-control" />
                </div>
                <div class="col-md-6">
                  <label for="edit-correousuario" class="form-label">Correo Electrónico del Usuario:</label>
                  <input type="text" id="edit-correousuario" name="correousuario" class="form-control" />
                </div>
              </div>
              <div class="row mb-3">
                <div class="col-md-6">
                  <label for="edit-direccion" class="form-label">Direccion del Usuario:</label>
                  <input type="text" id="edit-direccion" name="direccion" class="form-control" />
                </div>
                <div class="col-md-6">
                  <label for="edit-telefono" class="form-label">Telefono del Usuario:</label>
                  <input type="text" id="edit-telefono" name="telefono" class="form-control" />
                </div>
              </div>
              <div class="row mb-3">
              <div class="col-md-6">
                  <label for="edit-nomrol" class="form-label"><strong>Rol del Usuario:</strong></label>
                  <input type="text" id="edit-nomrol" name="nomrol" class="form-control" readonly>
              </div>
                <div class="col-md-6">
                  <label for="edit-estado" class="form-label"><strong>Estado:</strong></label>
                  <select id="edit-estado" name="estado" class="form-control">
                    <option value="1">Activo</option>
                    <option value="0">Inactivo</option>
                  </select>
                </div>
              </div>
              <input type="hidden" name="accion" value="update">
              <div class="text-center">
                <button type="submit" class="btn btn-primary">Actualizar Usuario</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="registrarUsuarioModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Registrar Nuevo Usuario</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <form action="../../Controller/RegistroController.php" method="POST">
              <div class="form-group">
                <label for="dniusuario">Documento Nacional de Identidad (DNI):</label>
                <input type="number" id="dniusuario" name="dniusuario" class="form-control" required>
              </div>
              <br/>
              <div class="form-group">
                <label for="nombreusuario">Nombres Completos:</label>
                <input type="text" id="nombreusuario" name="nombreusuario" class="form-control" required>
              </div>
              <br/>
              <div class="form-group">
                <label for="apellidousuario">Apellidos Completos:</label>
                <input type="text" id="apellidousuario" name="apellidousuario" class="form-control" required>
              </div>
              <br/>
              <div class="form-group">
                <label for="correousuario">Correo Electrónico:</label>
                <input type="email" id="correousuario" name="correousuario" class="form-control" required>
              </div>
              <br/>
              <div class="form-group">
                <label for="telefono">Telefono:</label>
                <input type="number" id="telefono" name="telefono" class="form-control" required>
              </div>
              <br/>
              <div class="form-group">
                <label for="direccion">Dirección:</label>
                <input type="text" id="direccion" name="direccion" class="form-control" required>
              </div>
              <br/>
              <div class="form-group">
                <label for="contrasenia">Contraseña:</label>
                <input type="password" id="contrasenia" name="contrasenia" class="form-control" required>
              </div>
              <br/>
              <input type="hidden" name="accion" value="registrar">
              <div class="text-center">
                <button type="submit" class="btn btn-primary">Registrar Usuario</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  <script src="../../source/vendor/apexcharts/apexcharts.min.js"></script>
  <script src="../../source/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="../../source/vendor/chart.js/chart.umd.js"></script>
  <script src="../../source/vendor/echarts/echarts.min.js"></script>
  <script src="../../source/vendor/quill/quill.js"></script>
  <script src="../../source/vendor/simple-datatables/simple-datatables.js"></script>
  <script src="../../source/vendor/tinymce/tinymce.min.js"></script>
  <script src="../../source/vendor/php-email-form/validate.js"></script>
  <script src="../../source/js/jquery-3.7.1.min.js"></script>
  <script src="../../source/js/bootstrap.bundle.min.js"></script>
  <script src="../../source/js/main.js"></script>
  <script type="text/javascript" charset="utf8" src="../../source/js/datatables.js"></script>
  <script>
      $(document).ready( function () {
            $('#table_id').DataTable(
                {
                "language": {
                "url": "//cdn.datatables.net/plug-ins/1.13.1/i18n/es-ES.json"
                }
                }
            );}
      );
  </script>
  <script>
    $(document).ready(function() {
        $('.editar-btn').click(function() {
            var usuario = $(this).data('usuario');          
            $('#edit-dniusuario').val(usuario.dniusuario);
            $('#edit-nomusuario').val(usuario.nomusuario);
            $('#edit-apusuario').val(usuario.apusuario);
            $('#edit-correousuario').val(usuario.correousuario);
            $('#edit-direccion').val(usuario.direccion);
            $('#edit-telefono').val(usuario.telefono);
            $('#edit-nomrol').val(usuario.nomrol);
            $('#edit-estado').val(usuario.estado);
            $('#editModal').modal('show');
        });
    });
  </script>
  <script>
  $(document).ready(function() {
    $('#registrarusuario').click(function() {
      $('#registrarUsuarioModal').modal('show');
    });
  });
</script>
</body>
</html>