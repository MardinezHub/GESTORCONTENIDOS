<?php
  session_start();

  if (!isset($_SESSION['userId'])) {
      header("Location: ../../index.php");
      exit();
  }

  include_once '../../conexion.php';
  include_once '../../Model/paginaModel.php';
  include_once '../../Model/fotoModel.php';
  $paginaModel = new paginaModel();
  $fotoModel = new fotoModel();
  $fotos = $fotoModel->listarfotos();
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
  <title>Fotos - Administrador</title>
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
        <a class="nav-link" href="indexadmin.php">
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
      <h1>Gestor de Contenidos - Fotos</h1>
    </div>
    <section class="section dashboard">      
      <div class="row justify-content-center">
        <div class="col-lg-6">
          <div class="card">
              <div class="card-body">
                  <h5 class="card-title">Fotos</h5>
                  <form class="row g-3" action="../../Controller/fotoController.php" method="POST" enctype="multipart/form-data">
                      <div class="col-12">
                          <label for="filefoto" class="form-label">Foto:</label>
                          <input type="file" id="filefoto" name="filefoto" class="form-control" />
                      </div>
                      <div class="col-12">
                          <label for="fk_idpagina">Página:</label>
                          <select name="fk_idpagina" id="fk_idpagina" class="form-control">
                            <option value="0">--Seleccione una página--</option>
                            <option value="1">Inicio</option>
                            <?php foreach($paginas as $row): ?>
                              <option value="<?php echo $row['idpagina'] ?>"><?php echo $row['nombrepagina'] ?></option>
                              <?php endforeach; ?>
                          </select>
                      </div>
                      <div class="col-12">
                          <label for="fk_idsubpagina">SubPágina:</label>
                          <select name="fk_idsubpagina" id="fk_idsubpagina" class="form-control">
                            <option value="0">--Seleccione una SubPágina--</option>
                            <?php foreach($subpaginas as $row): ?>
                              <option value="<?php echo $row['idsubpagina'] ?>"><?php echo $row['nombresub'] ?></option>
                              <?php endforeach; ?>
                          </select>
                      </div>
                      <input type="hidden" name="accion" value="registrarfoto">
                      <div class="text-center">
                          <button type="submit" class="btn btn-primary">Registrar Foto</button>
                      </div>
                  </form>
              </div>
          </div>
      </div>
    </div>
    <div>
      <div class="card">
            <div class="card-body">
                <h5 class="card-title">Tabla de Fotos</h5>
                <br /><br />
                <div class="table-responsive">
                  <table class="table" id="tabla-objetivos">
                      <thead>
                          <tr>
                              <th scope="col">Foto</th>
                              <th scope="col">Página</th>
                              <th scope="col">SubPágina</th>
                              <th scope="col">Acciones</th>
                          </tr>
                      </thead>
                      <tbody>
                        <?php if($fotos): ?>
                          <?php foreach($fotos as $row): ?>
                            <tr class="align-middle">
                              <td><img src="../../source/img/Foto/<?php echo $row['foto'] ?>" style="width:300px; height:200px" alt="Pagina vista"></td>
                              <td scope="row">
                              <?php 
                                    if (!empty($row['fk_idpagina'])) {
                                    if ($row['fk_idpagina'] == 1) {
                                        echo "Inicio";
                                    } else {
                                        echo $row['nombrepagina'];
                                    }
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
                                <button class="btn btn-secondary editar-btn-foto" data-foto='<?php echo json_encode($row); ?>'>Editar <br/>Foto</button><br/><br/>
                                <button class="btn btn-danger eliminar-btn-foto" data-idfoto='<?php echo $row['idfoto']; ?>'>Eliminar <br/>Foto</button>
                              </td>
                            </tr>
                        <?php endforeach; ?>
                        <?php else: ?>
                                <tr>
                                  <td>No se encontraron datos.</td>
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
          <h5 class="modal-title" id="exampleModalLabel">Editar Foto</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
        <form id="editForm" method="POST" enctype="multipart/form-data" action="../../Controller/listaController.php">
              <input type="number" name="idfoto" id="edit-idfoto" class="form-control" style="display: none;">
              <div class="mb-3">
                    <label for="current-foto" class="form-label">Foto</label>
                    <div id="current-foto" class="mb-2">
                    <img id="edit-foto" src="../../source/img/Foto/<?php echo $row['foto']; ?>" style="width:250px; height:200px" alt="Almacen de vista" />
                    </div>
              </div>
              <div class="mb-3">
                <label form="edit-fk_idpagina" class="form-label">Página:</label>
                <select class="form-control" name="fk_idpagina" id="edit-fk_idpagina">
                    <option value="1">Inicio</option>
                    <?php foreach($paginas as $pagina): ?>
                        <option value="<?php echo $pagina['idpagina'] ?>"><?php echo $pagina['nombrepagina'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="mb-3">
                <label form="edit-fk_idsubpagina" class="form-label">SubPágina:</label>
                <select class="form-control" name="fk_idsubpagina" id="edit-fk_idsubpagina">
                    <?php foreach($subpaginas as $subpagina):  ?>
                        <option value="<?php echo $subpagina['idsubpagina'] ?>"><?php echo $subpagina['nombresub'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <input type="hidden" name="accion" value="updatefoto">
            <div class="text-center">
              <button type="submit" class="btn btn-primary">Actualizar Foto</button>
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
        $('.editar-btn-foto').click(function(){
          var foto = $(this).data('foto');

          $('#edit-idfoto').val(foto.idfoto);
          $('#edit-foto').attr('src', '../../source/img/Foto/' + foto.foto);
          $('#edit-fk_idpagina').val(foto.fk_idpagina);
          $('#edit-fk_idsubpagina').val(foto.fk_idsubpagina);
          $('#editModal').modal('show');
        });
      });

      $('.eliminar-btn-foto').click(function(){
        var idfoto = $(this).data('idfoto');
        var confirmarEliminar = confirm("¿Estás seguro de que deseas eliminar esta foto?");
        if(confirmarEliminar){
          $.ajax({
            url: "../../Controller/fotoController.php",
            method: "POST",
            data: { accion: "eliminarfoto", idfoto: idfoto},
            success: function(data){
              location.reload();
            },
            error: function(xhr, status, error){
              console.error("Error al eliminar la foto: " + error);
            }
          });
        }
      });
  </script>
</body>
</html>