<?php
  session_start();

  if (!isset($_SESSION['userId'])) {
      header("Location: ../../index.php");
      exit();
  }

  include_once '../../conexion.php';
  include_once '../../Model/paginaModel.php';
  include_once '../../Model/listaModel.php';
  $paginaModel = new paginaModel();
  $listaModel = new listaModel();
  $listas = $listaModel->Listarlista();
  $opciones = $listaModel->Listaropciones();
  $paginas = $paginaModel->ListarPaginas();
  $subpaginas = $paginaModel->ListarSubpaginas();
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
  <title>Administrar Listas - Personal</title>
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
      <h1>Gestor de Contenidos - Listas - Opciones</h1>
    </div>
    <section class="section dashboard">
      <div class="row">
        <div class="col-lg-6">
          <div class="card">
            <div class="card-body">
              <center>
              <h5 class="card-title">Lista</h5>
              </center>
              <form class="row g-3" action="../../Controller/listaController.php" method="POST">
                  <div class="col-12">
                      <label for="titulo" class="form-label">Título de la Lista:</label>
                      <input type="text" name="titulo" id="titulo" class="form-control">
                  </div>
                  <div>
                      <label form="pagina" class="form-label">Página:</label>
                      <select name="fk_idpagina" id="fk_idpagina" class="form-control">
                        <option value="0">--Seleccione una Página--</option>
                          <?php foreach($paginas as $row): ?>
                            <option value="<?php echo $row['idpagina'] ?>"><?php echo $row['nombrepagina'] ?></option>
                          <?php endforeach; ?>
                      </select>
                  </div>
                  <div>
                    <label form="fk_idsubpagina">SubPágina:</label>
                    <select name="fk_idsubpagina" id="fk_idsubpagina" class="form-control">
                      <option value="0">--Seleccione una SubPágina--</option>
                      <?php foreach($subpaginas as $row): ?>
                        <option value="<?php echo $row['idsubpagina'] ?>"><?php echo $row['nombresub'] ?></option>
                        <?php endforeach; ?>
                    </select>
                  </div>
                  <input type="hidden" name="accion" value="registrarlistapersonal">
                  <div class="text-center">
                      <button type="submit" class="btn btn-primary">Registrar Lista</button>
                  </div>
              </form>
            </div>
          </div>
      </div>
      <div class="col-lg-6">
        <div class="card">
              <div class="card-body">
                <h5 class="card-title">Tabla de Listas</h5>
                 <div class="table-responsive">
                  <table class="table">
                    <thead>
                      <tr>
                        <th scope="col">Título de la Lista</th>
                        <th scope="col">Página</th>
                        <th scope="col">SubPágina</th>
                        <th scope="col">Acciones</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php if($listas): ?>
                        <?php foreach($listas as $row): ?>
                          <tr class="align-middle">
                            <td scope="row"><?php echo $row['titulo']; ?></td>
                            <td scope="row">
                              <?php 
                                if (!empty($row['nombrepagina'])) {
                                  echo $row['nombrepagina'];
                                  } else {
                                  echo "<strong>No hay página</strong>";
                                }
                              ?>
                            </td>
                            <td scope="row">
                              <?php 
                                if (!empty($row['nombresub'])) {
                                    echo $row['nombresub'];
                                } else {
                                    echo "<strong>No hay subpagina</strong>";
                                }
                              ?>
                            </td>
                            <td>
                              <center>
                                <button class="btn btn-secondary editar-btn-lista" data-lista='<?php echo json_encode($row); ?>'>Editar <br/>Lista de Opciones</button><br/><br/>
                                <button class="btn btn-danger eliminar-btn-lista" data-idlista='<?php echo $row['idlista']; ?>'>Eliminar <br/>Lista de Opciones</button>
                              </center>
                            </td>
                          </tr>
                      <?php endforeach; ?>
                      <?php else: ?>
                            <tr>
                              <td colspan="11">No se encontraron datos.</td>
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
      </div>
      <div class="row justify-content-center">
        <div class="col-lg-6">
          <div class="card">
              <div class="card-body">
                  <h5 class="card-title">Opción</h5>
                  <form class="row g-3" action="../../Controller/listaController.php" method="POST">
                      <div class="col-12">
                          <label for="descripcion" class="form-label">Descripción:</label>
                          <textarea class="form-control" id="descripcion" name="descripcion" style="height: 100px;"></textarea>
                      </div>
                      <div class="col-12">
                          <label for="fk_idlista">Lista:</label>
                          <select name="fk_idlista" id="fk_idlista" class="form-control">
                            <option value="0">--Seleccione una Lista--</option>
                            <?php foreach($listas as $row): ?>
                              <option value="<?php echo $row['idlista'] ?>"><?php echo $row['titulo'] ?></option>
                              <?php endforeach; ?>
                          </select>
                      </div>
                      <input type="hidden" name="accion" value="registraropcionpersonal">
                      <div class="text-center">
                          <button type="submit" class="btn btn-primary">Registrar Opción</button>
                      </div>
                  </form>
              </div>
          </div>
      </div>
    </div>
    <div>
      <div class="card">
            <div class="card-body">
                <h5 class="card-title">Tabla de Opciones</h5>
                <br /><br />
                <div class="table-responsive">
                  <table class="table" id="tabla-objetivos">
                      <thead>
                          <tr>
                              <th scope="col">Descripción</th>
                              <th scope="col">Lista</th>
                              <th scope="col">Acciones</th>
                          </tr>
                      </thead>
                      <tbody>
                        <?php if($opciones): ?>
                          <?php foreach($opciones as $row): ?>
                            <tr class="align-middle">
                              <td scope="row"><?php echo $row['descripcion']; ?></td>
                              <td scope="row"><strong><?php echo $row['titulo'] ?></strong></td>
                              <td>
                                <center>
                                  <button class="btn btn-secondary editar-btn-opcion" data-opcion='<?php echo json_encode($row); ?>'>Editar <br/>Opción</button><br/><br/>
                                  <button class="btn btn-danger eliminar-btn-opcion" data-idopcion='<?php echo $row['idopcion']; ?>'>Eliminar <br/>Opción</button>
                                </center>
                              </td>
                            </tr>
                        <?php endforeach; ?>
                        <?php else: ?>
                                <tr>
                                  <td>No se encontraron datos.</td>
                                  <td></td>
                                  <td></td>
                                </tr>
                        <?php endif; ?>
                      </tbody>
                  </table>
                </div>
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
    <div class="modal-dialog modal-lg-4">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Editar Lista</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
        <form id="editForm" method="POST" enctype="multipart/form-data" action="../../Controller/listaController.php">
              <input type="number" name="idlista" id="edit-lista" class="form-control" style="display:none ;">
              <div class="mb-3">
                <label for="edit-titulo" class="form-label">Título de la Lista:</label>
                <input class="form-control" id="edit-titulo" name="titulo" >
              </div>
              <div class="mb-3">
                <label form="edit-pagina" class="form-label">Página:</label>
                <select class="form-control" name="fk_idpagina" id="edit-pagina">
                    <?php foreach($paginas as $pagina): ?>
                        <option value="<?php echo $pagina['idpagina'] ?>"><?php echo $pagina['nombrepagina'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="mb-3">
                <label form="edit-subpagina" class="form-label">SubPágina:</label>
                <select class="form-control" name="fk_idsubpagina" id="edit-subpagina">
                    <?php foreach($subpaginas as $subpagina):  ?>
                        <option value="<?php echo $subpagina['idsubpagina'] ?>"><?php echo $subpagina['nombresub'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <input type="hidden" name="accion" value="updatelistapersonal">
            <div class="text-center">
              <button type="submit" class="btn btn-primary">Actualizar Lista</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal -->
  <div class="modal fade" id="editModal2" tabindex="-1" aria-labelledby="exampleModalLabel2" aria-hidden="true">
    <div class="modal-dialog modal-lg-4">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel2">Editar Opción</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form id="editForm" method="POST" enctype="multipart/form-data" action="../../Controller/listaController.php">
            <input type="number" id="edit-idopcion" name="idopcion" class="form-control" style="display: none;">
            <div class="mb-3">
              <label for="edit-descripcion" class="form-label">Descripción de la Opción:</label>
              <textarea class="form-control" id="edit-descripcion" name="descripcion" style="height: 200px;"></textarea>
            </div>
            <div class="mb-3">
                <label form="edit-lista" class="form-label">Lista:</label>
                <select class="form-control" name="fk_idlista" id="edit-lista">
                    <?php foreach($listas as $lista):  ?>
                        <option value="<?php echo $lista['idlista'] ?>"><?php echo $lista['titulo'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <input type="hidden" name="accion" value="updateopcionpersonal">
            <div class="text-center">
              <button type="submit" class="btn btn-primary">Actualizar Opción</button>
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
  <script src="../../source/js/main.js"></script>
  <script src="../../source/js/jquery-3.7.1.min.js"></script>
  <script src="../../source/js/bootstrap.bundle.min.js"></script>  
  <!-- DataTables JS library -->
  <script type="text/javascript" charset="utf8" src="../../source/js/datatables.js"></script>
  <script>
      $(document).ready( function () {
            $('#tabla-objetivos').DataTable(
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
        $('.editar-btn-lista').click(function(){
          var lista = $(this).data('lista');

          $('#edit-lista').val(lista.idlista);
          $('#edit-titulo').val(lista.titulo);
          $('#edit-pagina').val(lista.fk_idpagina);
          $('#edit-subpagina').val(lista.fk_idsubpagina);
          $('#editModal').modal('show');
        });
      });

      $('.eliminar-btn-lista').click(function(){
        var idlista = $(this).data('idlista');
        var confirmarEliminar = confirm("¿Estás seguro de que deseas eliminar la lista?");
        if(confirmarEliminar){
          $.ajax({
            url: "../../Controller/listaController.php",
            method: "POST",
            data: { accion: "eliminarlista", idlista: idlista},
            success: function(data){
              location.reload();
            },
            error: function(xhr, status, error){
              console.error("Error al eliminar la lista: " + error);
            }
          });
        }
      });

      $(document).ready(function(){
        $('.editar-btn-opcion').click(function(){
          var opcion = $(this).data('opcion');

          $('#edit-idopcion').val(opcion.idopcion);
          $('#edit-descripcion').val(opcion.descripcion);
          $('#edit-lista').val(opcion.fk_idlista);
          $('#editModal2').modal('show');
        });
      });

      $('.eliminar-btn-opcion').click(function(){
        var idopcion = $(this).data('idopcion');
        var confirmarEliminar = confirm("¿Estás seguro de que deseas eliminar esta opcion?");
        if(confirmarEliminar){
          $.ajax({
            url: "../../Controller/listaController.php",
            method: "POST",
            data: { accion: "eliminaropcion", idopcion: idopcion},
            success: function(data){
              location.reload();
            },
            error: function(xhr, status, error){
              console.error("Error al eliminar la opcion: " + error);
            }
          });
        }
      });
  </script>
</body>
</html>