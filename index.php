<?php
    $opcion = 1;
    include_once 'admin/conexion.php';
    $conexion = conectarse();

    $resultados_por_pagina = 4; 
    $pagina_actual_comunicados = isset($_GET['pagina_comunicados']) ? $_GET['pagina_comunicados'] : 1; 
    $pagina_actual_noticias = isset($_GET['pagina_noticias']) ? $_GET['pagina_noticias'] : 1; 

    $offset_comunicados = ($pagina_actual_comunicados - 1) * $resultados_por_pagina;
    $offset_noticias = ($pagina_actual_noticias - 1) * $resultados_por_pagina;

    $query_publicacion = "SELECT * FROM tbpublicacion ORDER BY fechapubli DESC LIMIT $offset_comunicados, $resultados_por_pagina";
    $resultado_publicacion = mysqli_query($conexion, $query_publicacion);

    $total_resultados_query_publicacion = "SELECT COUNT(*) AS total FROM tbpublicacion";
    $total_resultados_publicacion = mysqli_fetch_assoc(mysqli_query($conexion, $total_resultados_query_publicacion))['total'];

    $query_noticia = "SELECT * FROM tbnoticia ORDER BY fechapubli DESC LIMIT $offset_noticias, $resultados_por_pagina";
    $resultado_noticia = mysqli_query($conexion, $query_noticia);

    $total_resultados_query_noticia = "SELECT COUNT(*) AS total FROM tbnoticia";
    $total_resultados_noticia = mysqli_fetch_assoc(mysqli_query($conexion, $total_resultados_query_noticia))['total'];

    mysqli_close($conexion);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <?php include_once '_head.php'; ?>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/5.1.3/css/bootstrap.min.css" rel="stylesheet">
    <title>Defensoria Universitaria - UNJBG</title>
    <style>
        body {
            font-size: 16px;
        }

        @media (max-width: 992px) {
            body {
                font-size: 14px;
            }
        }

        .card {
            height: 100%;
            display: flex;
            flex-direction: column;
            border: 1px solid #ddd; 
            border-radius: 8px; 
            margin-bottom: 20px;
        }

        .card-body {
            flex: 1 1 auto;
            padding: 15px; 
        }

        .card-img-top {
            width: 100%;
            height: 200px;
            object-fit: cover;
            border-top-left-radius: 8px;
            border-top-right-radius: 8px;
        }

        .card-title {
            margin-top: 10px;
            font-size: 18px;
            font-weight: bold;
        }

        .card-text {
            margin-top: 10px;
            font-size: 14px;
            line-height: 1.6;
        }

        .text-muted {
            font-size: 12px;
            color: #777;
        }

        .pagination {
            display: flex;
            justify-content: center;
            margin-top: 20px;
        }

        .pagination a {
            color: #333;
            padding: 8px 16px;
            text-decoration: none;
            transition: background-color 0.3s;
            border: 1px solid #ccc;
            margin: 0 4px;
            border-radius: 4px;
        }

        .pagination a.active,
        .pagination a:hover {
            background-color: #ccc;
        }

        @media (max-width: 768px) {
            .card {
                margin-bottom: 15px;
            }

            .card-title {
                font-size: 16px;
            }

            .card-text {
                font-size: 13px;
            }
        }

        .modal-body {
                overflow-y: auto;
            }

        @media (max-width: 768px) {
            .modal-img {
                max-width: 100%;
                max-height: 70vh; 
                object-fit: contain; 
                overflow-y: auto; 
            }
        }
    </style>
</head>
<body>
    <?php include_once '_header.php'; ?>
    <main>
        <?php include_once '_slider.php'; ?>
        <section class="about-area bottom-padding1 position-relative">
            <div class="container">
                <center>
                    <h1><strong>COMUNICADOS</strong></h1>
                    <br/><br/>
                </center>
                    <div class="row">
                        <?php
                        if (mysqli_num_rows($resultado_publicacion) > 0) {
                            while ($row = mysqli_fetch_assoc($resultado_publicacion)) {
                                ?>
                                <div class="col-lg-3 col-md-4 col-sm-5 mb-4">
                                    <div class="card">
                                        <img src="admin/source/img/Publicacion/<?php echo $row['foto']; ?>" class="card-img-top" alt="...">
                                        <div class="card-body">
                                            <h4 class="card-title"><?php echo $row['titulo']; ?></h4>
                                            <p class="card-text">
                                                <?php
                                                $descripcion_corta = substr($row['descripcion'], 0, 100);
                                                echo $descripcion_corta . (strlen($row['descripcion']) > 100 ? '...' : '');
                                                ?>
                                            </p>
                                            <center>
                                            <label class="card-text">Fecha de Publicación:</label>
                                            <p class="card-text"><strong><?php echo $row['fechapubli']; ?></strong></p>
                                            </center>
                                            <br/>
                                            <center>
                                                <button class="btn btn-sm btn-primary visualizar-comunicado" data-comunicado='<?php echo json_encode($row) ?>' style="font-size: 14px; padding: 5px 10px;">
                                                    Visualizar Comunicado
                                                </button>
                                            </center>
                                        </div>
                                    </div>
                                </div>
                                <?php
                            }
                        } else {
                            echo '<div class="col-md-12"><h6><center>Todavía no hay comunicados disponibles.</center></h6></div>';
                        }
                        ?>
                    </div>
                    <div class="pagination">
                        <?php
                        if ($total_resultados_publicacion > $resultados_por_pagina) {
                            $total_paginas_publicacion = ceil($total_resultados_publicacion / $resultados_por_pagina);
                            $num_enlaces_mostrados = 5;
                            $mitad_num_enlaces = floor($num_enlaces_mostrados / 2);

                            $inicio = max(1, $pagina_actual_comunicados - $mitad_num_enlaces);
                            $fin = min($total_paginas_publicacion, $pagina_actual_comunicados + $mitad_num_enlaces);

                            if ($pagina_actual_comunicados - $inicio < $mitad_num_enlaces) {
                                $fin = min($total_paginas_publicacion, $inicio + $num_enlaces_mostrados - 1);
                            }
                            if ($fin - $pagina_actual_comunicados < $mitad_num_enlaces) {
                                $inicio = max(1, $fin - $num_enlaces_mostrados + 1);
                            }

                            if ($pagina_actual_comunicados > 1) {
                                echo '<a href="?pagina_comunicados=1">«</a>';
                                echo '<a href="?pagina_comunicados=' . ($pagina_actual_comunicados - 1) . '">‹</a>'; 
                            }

                            for ($i = $inicio; $i <= $fin; $i++) {
                                if ($i == $pagina_actual_comunicados) {
                                    echo '<a href="?pagina_comunicados=' . $i . '" class="active">' . $i . '</a>';
                                } else {
                                    echo '<a href="?pagina_comunicados=' . $i . '">' . $i . '</a>';
                                }
                            }

                            if ($pagina_actual_comunicados < $total_paginas_publicacion) {
                                echo '<a href="?pagina_comunicados=' . ($pagina_actual_comunicados + 1) . '">›</a>'; 
                                echo '<a href="?pagina_comunicados=' . $total_paginas_publicacion . '">»</a>';
                            }
                        }
                        ?>
                    </div>
            </div>
            <div class="container">
                <center>
                    <br/>
                    <br/>
                    <h1><strong>NOTICIAS</strong></h1>
                    <br/>
                    <br/>
                </center>
                <div class="row">
                    <?php
                    if (mysqli_num_rows($resultado_noticia) > 0) {
                        while ($row = mysqli_fetch_assoc($resultado_noticia)) {
                            ?>
                            <div class="col-lg-3 col-md-4 col-sm-5 mb-4">
                                <div class="card">
                                    <img src="admin/source/img/Noticia/<?php echo $row['foto']; ?>" class="card-img-top" alt="...">
                                    <div class="card-body">
                                        <h4 class="card-title"><?php echo $row['titulo']; ?></h4>
                                        <p class="card-text">
                                            <?php
                                            $descripcion_corta = substr($row['descripcion'], 0, 100);
                                            echo $descripcion_corta . (strlen($row['descripcion']) > 100 ? '...' : '');
                                            ?>
                                        </p>
                                        <center>
                                        <label class="card-text">Fecha de Publicación:</label>
                                        <p class="card-text"><strong><?php echo $row['fechapubli']; ?></strong></p>
                                        </center>
                                        <br/>
                                        <center>
                                            <button class="btn btn-sm btn-primary visualizar-noticia" data-noticia='<?php echo json_encode($row) ?>' style="font-size: 14px; padding: 5px 10px;">
                                                Visualizar Noticia
                                            </button>
                                        </center>
                                    </div>
                                </div>
                            </div>
                            <?php
                        }
                    } else {
                        echo '<div class="col-md-12"><h6><center>Todavía no hay noticias disponibles.</center></h6></div>';
                    }
                    ?>
                </div>
                <div class="pagination">
                    <?php
                    if ($total_resultados_noticia > $resultados_por_pagina) {
                        $total_paginas_noticia = ceil($total_resultados_noticia / $resultados_por_pagina);
                        $num_enlaces_mostrados = 5;
                        $mitad_num_enlaces = floor($num_enlaces_mostrados / 2);

                        $inicio = max(1, $pagina_actual_noticias - $mitad_num_enlaces);
                        $fin = min($total_paginas_noticia, $pagina_actual_noticias + $mitad_num_enlaces);

                        if ($pagina_actual_noticias - $inicio < $mitad_num_enlaces) {
                            $fin = min($total_paginas_noticia, $inicio + $num_enlaces_mostrados - 1);
                        }
                        if ($fin - $pagina_actual_noticias < $mitad_num_enlaces) {
                            $inicio = max(1, $fin - $num_enlaces_mostrados + 1);
                        }

                        if ($pagina_actual_noticias > 1) {
                            echo '<a href="?pagina_noticias=1">«</a>';
                            echo '<a href="?pagina_noticias=' . ($pagina_actual_noticias - 1) . '">‹</a>'; 
                        }

                        for ($i = $inicio; $i <= $fin; $i++) {
                            if ($i == $pagina_actual_noticias) {
                                echo '<a href="?pagina_noticias=' . $i . '" class="active">' . $i . '</a>';
                            } else {
                                echo '<a href="?pagina_noticias=' . $i . '">' . $i . '</a>';
                            }
                        }

                        if ($pagina_actual_noticias < $total_paginas_noticia) {
                            echo '<a href="?pagina_noticias=' . ($pagina_actual_noticias + 1) . '">›</a>'; 
                            echo '<a href="?pagina_noticias=' . $total_paginas_noticia . '">»</a>';
                        }
                    }
                    ?>
                </div>
            </div>
            <div class="shape-bg-about">
                <img src="assets/images/icon/bg-shape-2.png" alt="">
            </div>
        </section>
        <?php include_once '_links.php'; ?>
    </main>
    <?php include_once '_footer.php'; ?>
    <?php include_once '_redes.php'; ?>
    <div class="search-overlay"></div>
    <?php include_once '_js.php'; ?>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/5.1.3/js/bootstrap.bundle.min.js"></script>
    <!--Modal de Noticia-->
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Noticia</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 d-flex justify-content-center align-items-center">
                            <div id="current-foto" class="mb-2">
                                <img id="visualizar-foto" src="admin/source/img/Noticia/<?php echo $row['foto']; ?>" alt="Foto de la Noticia" class="img-fluid modal-img">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <form id="editForm">
                                <div class="mb-3">
                                    <label for="visualizar-titulo" class="form-label">Título de la Noticia:</label>
                                    <input type="text" id="visualizar-titulo" name="titulo" class="form-control" readonly>
                                </div>
                                <div class="mb-3">
                                    <label for="visualizar-descripcion" class="form-label">Descripción de la Noticia:</label>
                                    <textarea class="form-control" id="visualizar-descripcion" name="descripcion" style="height: 150px;" readonly></textarea>
                                </div>
                                <div class="mb-3">
                                    <label for="visualizar-fecha" class="form-label">Fecha de Publicación:</label>
                                    <input type="date" id="visualizar-fecha" name="fechapubli" class="form-control" readonly>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--Modal de Comunicado-->
    <div class="modal fade" id="editModalComunicado" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Comunicado</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 d-flex justify-content-center align-items-center">
                            <div id="current-foto-comunicado" class="mb-2">
                                <img id="visualizar-foto-comunicado" src="admin/source/img/Publicacion/<?php echo $row['foto']; ?>" alt="Foto del Comunicado" class="img-fluid modal-img">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <form id="editForm">
                                <div class="mb-3">
                                    <label for="visualizar-titulo-comunicado" class="form-label">Título del Comunicado:</label>
                                    <input type="text" id="visualizar-titulo-comunicado" name="titulo" class="form-control" readonly>
                                </div>
                                <div class="mb-3">
                                    <label for="visualizar-descripcion-comunicado" class="form-label">Descripción del Comunicado:</label>
                                    <textarea class="form-control" id="visualizar-descripcion-comunicado" name="descripcion" style="height: 150px;" readonly></textarea>
                                </div>
                                <div class="mb-3">
                                    <label for="visualizar-fecha-comunicado" class="form-label">Fecha de Publicación:</label>
                                    <input type="date" id="visualizar-fecha-comunicado" name="fechapubli" class="form-control" readonly>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function(){
            $('.visualizar-noticia').click(function(){
                var noticia = $(this).data('noticia');
                
                $('#visualizar-foto').attr('src','admin/source/img/Noticia/' + noticia.foto);
                $('#visualizar-titulo').val(noticia.titulo);
                $('#visualizar-descripcion').val(noticia.descripcion);
                $('#visualizar-fecha').val(noticia.fechapubli);
                $('#editModal').modal('show');
            });
        });
        $(document).ready(function(){
            $('.visualizar-comunicado').click(function(){
                var comunicado = $(this).data('comunicado');

                $('#visualizar-foto-comunicado').attr('src','admin/source/img/Publicacion/' + comunicado.foto);
                $('#visualizar-titulo-comunicado').val(comunicado.titulo);
                $('#visualizar-descripcion-comunicado').val(comunicado.descripcion);
                $('#visualizar-fecha-comunicado').val(comunicado.fechapubli);
                $('#editModalComunicado').modal('show');
            });
        });
    </script>
</body>
</html>

