<?php
  session_start();

  if (!isset($_SESSION['userId'])) {
      header("Location: ../../index.php");
      exit();
  }

  include_once '../../conexion.php';
  include_once '../../Controller/publicacionController.php';
  include_once '../../Model/publicacionModel.php';
  $publicacionModel = new publicacionModel();
  $publicacion = $publicacionModel->ListarPublicacion();

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
  <title>Comunicados - Personal</title>
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
      <a href="indexpersonal.php" class="logo d-flex align-items-center">
        <span class="d-none d-lg-block text-light">UNJBG</span>
      </a>
      <i class="bi bi-list toggle-sidebar-btn text-light"></i>
    </div>
    <nav class="header-nav ms-auto">
      <ul class="d-flex align-items-center">
        <li class="nav-item dropdown pe-3">
          <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
            <img src="../../source/img/persona.png" alt="Imagen">
            <span class="d-none d-md-block dropdown-toggle ps-2 text-light"><?php echo $nombreCompleto; ?></span>
          </a>
          <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
            <li class="dropdown-header">
              <img src="../../source/img/persona.png" style="width: 90px; height:90px;" alt="Imagen">
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
        <a class="nav-link " href="indexpersonal.php">
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
            <a href="informacionpersonal.php">
              <i class="bi bi-circle"></i><span>Administrar Información</span>
            </a>
          </li>
          <li>
            <a href="listapersonal.php">
              <i class="bi bi-circle"></i><span>Administrar Listas</span>
            </a>
          </li>
          <li>
            <a href="personalusuario.php">
              <i class="bi bi-circle"></i><span>Administrar Integrantes</span>
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
            <a href="publicacionpersonal.php">
              <i class="bi bi-circle"></i><span>Administrar Comunicados</span>
            </a>
          </li>
          <li>
            <a href="noticiapersonal.php">
              <i class="bi bi-circle"></i><span>Administrar Noticias</span>
            </a>
          </li>
          <li>
            <a href="fotopersonal.php">
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
            <a href="legalpersonal.php">
              <i class="bi bi-circle"></i><span>Administrar Marco <br/> Legal</span>
            </a>
          </li>
          <li>
            <a href="multimediapersonal.php">
              <i class="bi bi-circle"></i><span>Administrar Multimedia</span>
            </a>
          </li>
          <li>
            <a href="enlacespersonal.php">
              <i class="bi bi-circle"></i><span>Administrar Enlace Directo</span>
            </a>
          </li>
          <li>
            <a href="redespersonal.php">
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
      <h1>Gestor de Contenidos - Comunicados</h1>
    </div>
    <section class="section dashboard">
      <div class="row justify-content-center">
        <div class="col-lg-6">
          <div class="card">
            <div class="card-body">
              <form class="row g-3" action="../../Controller/publicacionController.php" method="POST" enctype="multipart/form-data">
                <div class="col-12">
                    <br/>
                    <label for="titulo" class="form-label">Título del Comunicado:</label>
                    <input type="text" id="titulo" name="titulo" class="form-control" />
                </div>
                <div class="col-12">
                    <label for="descripcion" class="form-label">Descripción del Comunicado:</label>
                    <textarea class="form-control" id="descripcion" name="descripcion" style="height: 150px;"></textarea>
                </div>
                <div class="col-12">
                    <label for="fechapubli" class="form-label">Fecha de Publicación:</label>
                    <input type="date" id="fechapubli" name="fechapubli" class="form-control" />
                </div>
                <div class="col-12">
                    <label for="filepublicacion" class="form-label">Foto del Comunicado:</label>
                    <input type="file" id="filepublicacion" name="filepublicacion" class="form-control" />
                </div>
                <input type="hidden" name="accion" value="registrar2">
                <div class="text-center">
                    <button type="submit" class="btn btn-primary">Registrar Comunicado</button>
                </div>
              </form>
            </div>
          </div>
        </div>
        <div class="card">
            <div class="card-body">
              <h5 class="card-title">Tabla de Comunicado</h5>
              <div class="table-responsive">
              <table class="table" id="table_id">
                <thead>
                  <tr>
                    <th scope="col">Título del Comunicado</th>
                    <th scope="col">Descripción del Comunicado</th>
                    <th scope="col">Fecha de Publicación</th>
                    <th scope="col">Foto del Comunicado</th>
                    <th scope="col">Acciones</th>
                  </tr>
                </thead>
                <tbody>
                  <?php if($publicacion): ?>
                    <?php foreach($publicacion as $row): ?>
                      <tr class="align-middle">
                        <td scope="row"><?php echo $row['titulo']; ?></td>
                        <td scope="row"><?php echo $row['descripcion']; ?></td>
                        <td scope="row"><?php echo $row['fechapubli'] ?></td>
                        <td scope="row"><img src="../../source/img/Publicacion/<?php echo $row['foto']; ?>" style="width:300px; height:300px"/></td>
                        <td>
                          <center>
                            <button class="btn btn-secondary editar-btn" data-publicacion='<?php echo json_encode($row); ?>'>Editar Comunicado</button><br/><br/>
                            <button class="btn btn-danger eliminar-btn" data-idpublicacion='<?php echo $row['idpublicacion']; ?>'>Eliminar Comunicado</button>
                          </center>
                        </td>
                      </tr>
                    <?php endforeach; ?>
                  <?php else: ?>
                      <tr>
                        <td>No se encontraron datos.</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                      </tr>
                  <?php endif; ?>
                </tbody>
              </table>
              </div>
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
    <div class="modal-dialog modal-dialog-centered modal-mb">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Editar Comunicado</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="row">
            <!-- Columna para el formulario -->
              <form id="editForm" method="POST" enctype="multipart/form-data" action="../../Controller/publicacionController.php">
                <div class="mb-8">                  
                  <input type="text" id="edit-idpublicacion" name="idpublicacion" class="form-control" style="display: none;"><br>
                  <label for="edit-titulo" class="form-label">Título del Comunicado:</label>
                  <input type="text" id="edit-titulo" name="titulo" class="form-control"><br/>
                <div class="mb-8">
                  <label for="edit-descripcion" class="form-label">Descripción del Comunicado:</label>
                  <textarea class="form-control" id="edit-descripcion" name="descripcion" style="height: 150px;"></textarea><br/>
                  <label for="edit-fecha" class="form-label">Fecha de Comunicado:</label>
                  <input type="date" id="edit-fecha" name="fechapubli" class="form-control"><br>
                </div>
                <div class="mb-8">
                  <center>
                    <label for="current-foto" class="form-label">Foto del Comunicado:</label>
                    <div id="current-foto" class="mb-2">
                      <img id="edit-foto" src="../../source/img/Publicacion/<?php echo $row['foto']; ?>" alt="Foto de la Publicacion" class="img-fluid">
                    </div>
                  </center>
                </div>                
                <input type="hidden" name="accion" value="update2">
                <div class="text-center">
                  <button type="submit" class="btn btn-primary">Actualizar Comunicado</button>
                </div>
              </form>
          </div>
        </div>
      </div>
    </div>
  </div>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  <script src="../../source/vendor/apexcharts/apexcharts.min.js"></script>
  <script src="../../source/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="../../source/vendor/chart.js/chart.umd.js"></script>
  <script src="../../source/vendor/echarts/echarts.min.js"></script>
  <script src="../../source/vendor/quill/quill.js"></script>
  <script src="../../source/vendor/simple-datatables/simple-datatables.js"></script>
  <script src="../../source/vendor/tinymce/tinymce.min.js"></script>
  <script src="../../source/vendor/php-email-form/validate.js"></script>
  <script src="../../source/js/main.js"></script>
  <script src="../../source/js/jquery-3.7.1.min.js"></script>
  <script src="../../source/js/bootstrap.bundle.min.js"></script>  
  <!-- DataTables JS library -->
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
      $(document).ready(function(){
        $('.editar-btn').click(function(){
          var publicacion = $(this).data('publicacion');

          $('#edit-idpublicacion').val(publicacion.idpublicacion);
          $("#edit-titulo").val(publicacion.titulo);
          $('#edit-descripcion').val(publicacion.descripcion);
          $('#edit-fecha').val(publicacion.fechapubli);
          $('#edit-foto').attr('src', '../../source/img/Publicacion/' + publicacion.foto);
          $('#editModal').modal('show');
        });
      });

      $('.eliminar-btn').click(function(){
        var idpublicacion = $(this).data('idpublicacion');
        var confirmarEliminar = confirm("¿Estás seguro de que deseas eliminar el comunicado?");
        if(confirmarEliminar){
          $.ajax({
            url: "../../Controller/publicacionController.php",
            method: "POST",
            data: { accion: "eliminar", idpublicacion: idpublicacion},
            success: function(data){
              location.reload();
            },
            error: function(xhr, status, error){
              console.error("Error al eliminar el comunicado: " + error);
            }
          });
        }
      });
  </script>
</body>
</html>