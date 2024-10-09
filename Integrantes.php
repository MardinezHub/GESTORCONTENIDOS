<?php
    define('INFO_DIV', "<div class='information-info'>");
    define('CLEAR_BOTH', "<div style='clear:both;'></div>");
    define('CLOSE_DIV', "</div>");
    define('LINE_BREAK', "<br/>");
    include_once 'admin/Model/informacionModel.php';
    include_once 'admin/Model/paginaModel.php';
    include_once 'admin/conexion.php';
    $conexion = conectarse();
    $informacionModel = new informacionModel();
    $paginaModel = new paginaModel();
    $paginaPrincipalId = 0;
    $subpaginaId = 2;
    $informacionesPrincipal = $informacionModel->listarInformacionPorPagina($paginaPrincipalId);
    $informacionesSubpagina = $informacionModel->listarInformacionPorSubpagina($subpaginaId);
    $listasPrincipal = $paginaModel->obtenerListasPorPagina($paginaPrincipalId);
    $listasSubpagina = $paginaModel->obtenerListasPorSubpagina($subpaginaId);
    $query_personal = "SELECT nompersonal, apepersonal, correopersonal, cargopersonal, profesionpersonal, foto FROM tbpersonal";
    $resultado_personal = mysqli_query($conexion, $query_personal);
    $fotosPorPagina = 1;
    $paginaActual = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
    $fotosTodas = ($paginaPrincipalId != 0) ? $paginaModel->obtenerFotosPorPagina($paginaPrincipalId) : $paginaModel->obtenerFotosPorSubpagina($subpaginaId);
    $fotosTotal = count($fotosTodas);
    $offset = ($paginaActual - 1) * $fotosPorPagina;
    $fotosMostradas = array_slice($fotosTodas, $offset, $fotosPorPagina);
    $totalPaginas = ceil($fotosTotal / $fotosPorPagina);
    $paginaMostrar = 1;
    mysqli_close($conexion);
?>
<!DOCTYPE html>
<html lang='es' dir='ltr'>
<head>
    <?php include_once '_head.php'; ?>
    <style>
        .card {
            border: none;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .card:hover {
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
        }

        .card-img-top {
            border-top-left-radius: 15px;
            border-top-right-radius: 15px;
        }

        .card-body {
            text-align: center;
        }

        .card-title {
            font-size: 20px;
            color: #007bff;
            font-weight: bold;
        }

        .card h5, .card h6 {
            color: #555;
            margin-bottom: 10px;
        }

        .card h6 {
            font-size: 14px;
        }

        @media (max-width: 768px) {
            .card-body {
                padding: 15px;
            }

            .card-title {
                font-size: 18px;
            }

            .card.mb-mobile {
                margin-bottom: 20px;
            }
        }
        .container-custom {
            max-width: 1000px;
            margin: 0 auto;
        }
        .information-info {
            background-color: #f9f9f9;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0px 0px 20px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }
        .information-info h4 {
            color: #333;
            font-size: 28px;
            font-weight: bold;
            margin-bottom: 20px;
            text-transform: uppercase;
        }
        .information-info a.button {
            display: inline-block;
            padding: 10px 20px;
            background-color: #007bff;
            color: #fff;
            border-radius: 5px;
            text-decoration: none;
            transition: background-color 0.3s ease;
        }
        .information-info a.button:hover {
            background-color: #0056b3;
        }
        .information-info b {
            color: #555;
        }
        .information-info p {
            color: #666;
            margin-bottom: 20px;
        }
        .information-info ul {
            list-style-type: none;
            padding: 0;
        }
        .information-info ul li {
            margin-bottom: 10px;
        }
        .information-info ul li i {
            margin-right: 10px;
            color: #007bff;
        }
        .information-info-left {
            float: left;
            width: 60%;
        }
        .information-info-right {
            float: right;
            width: 40%;
        }
        .photo-gallery {
            text-align: center;
            margin-top: 20px;
        }
        .photo-gallery img {
            width: 100%;
            max-width: 750px;
            height: 500px;
            object-fit: cover;
            margin: 10px 0;
        }
        .pagination {
            display: flex;
            justify-content: center;
            margin-top: 20px;
            flex-wrap: wrap;
        }
        .pagination .page-item {
            margin: 0 5px;
        }
        .pagination .page-item .page-link {
            padding: 10px 15px;
            border-radius: 5px;
            border: 1px solid #ddd;
            color: #007bff;
        }
        .pagination .page-item.active .page-link {
            background-color: #007bff;
            color: #fff;
            border-color: #007bff;
        }
        .pagination-arrows {
            display: none;
        }
        .pagination-arrows .page-link {
            padding: 10px 15px;
            border-radius: 5px;
            border: 1px solid #ddd;
            color: #007bff;
        }
        @media (max-width: 768px) {
            .information-info {
                padding: 20px;
            }
            .information-info-left,
            .information-info-right {
                float: none;
                width: 100%;
            }
            .information-info-right {
                margin-top: 20px;
            }
            .information-info-right img {
                max-width: 100%;
                height: auto;
            }
            .photo-gallery img {
                height: 300px;
                width: 400px;
            }
        }
    </style>
</head>
<body>
    <?php include_once '_header.php'; ?>
    <main>
        <section class='about-area bottom-padding1 position-relative'>
            <div class='container-custom'>
                <div class='row'>
                    <div class='col-md-12'>
                        <div class='section-title mb-30'>
                            <?php 
                            if ($paginaPrincipalId != 0 && $informacionesPrincipal) {
                                foreach ($informacionesPrincipal as $row) {
                                    echo INFO_DIV;
                                    echo "<h4>{$row['titulo']}</h4>";
                                    echo "<p>{$row['informacion']}</p>";
                                    echo CLEAR_BOTH;
                                    echo CLOSE_DIV . LINE_BREAK;
                                }
                            } elseif ($subpaginaId != 0 && $informacionesSubpagina) {
                                foreach ($informacionesSubpagina as $row) {
                                    echo INFO_DIV;
                                    echo "<h4>{$row['titulo']}</h4>";
                                    echo "<p>{$row['informacion']}</p>";
                                    echo CLEAR_BOTH;
                                    echo CLOSE_DIV . LINE_BREAK;
                                }
                            }
                            ?>                           
                        </div>
                    </div>                    
                </div>                       
            </div>
            <div class='container-custom'>
                <div class='row'>
                    <div class='col-md-12'>
                        <div class='section-title mb-30'>
                            <?php
                            if ($paginaPrincipalId != 0 && $listasPrincipal) {
                                foreach ($listasPrincipal as $lista) {
                                    echo INFO_DIV;
                                    echo "<h4>{$lista['titulo']}</h4>";
                                    echo "<ul>";
                                    foreach ($lista['opciones'] as $opcion) {
                                        echo "<li> - {$opcion['descripcion']}</li>";
                                    }
                                    echo "</ul>";
                                    echo CLEAR_BOTH;
                                    echo CLOSE_DIV . LINE_BREAK;
                                }
                            } elseif ($subpaginaId != 0 && $listasSubpagina) {
                                foreach ($listasSubpagina as $lista) {
                                    echo INFO_DIV;
                                    echo "<h4>{$lista['titulo']}</h4>";
                                    echo "<ul>";
                                    foreach ($lista['opciones'] as $opcion) {
                                        echo "<li> - {$opcion['descripcion']}</li>";
                                    }
                                    echo "</ul>";
                                    echo CLEAR_BOTH;
                                    echo CLOSE_DIV . LINE_BREAK;
                                }
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>                                       
            <div class="container">
                <h2 class="title text-center text-primary">INTEGRANTES</h2><br/>
                <div class="row">
                    <?php if(mysqli_num_rows($resultado_personal) > 0){ ?>
                        <?php while($row = mysqli_fetch_assoc($resultado_personal)) { ?>
                            <div class="col-md-4 mb-4 mb-md-0">
                                <br/>
                                <div class="card mx-30 mb-mobile">
                                    <img src="admin/source/img/Personal/<?php echo $row['foto']; ?>" class="card-img-top" alt="" style="width:420px; height:300px">
                                    <div class="card-body">
                                        <h4><strong><?php echo $row['nompersonal'] . ' ' . $row['apepersonal'] ?></strong></h4>                                       
                                        <h5 class="card-title" style="color: #1074B3;"><?php echo $row['profesionpersonal'] ; ?></h5>
                                        <h1 class="card-title" style="color: #1074B3;"><?php echo $row['cargopersonal']; ?></h1>
                                        <h6>Correo Electrónico: <?php echo $row['correopersonal']; ?></h6>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                    <?php } else { ?>
                        <p style="text-align: center;">Todavía no hay Integrante registrado.</p>
                    <?php } ?>
                </div>
            </div>                                  
        </section>
        <?php include_once '_links.php'; ?>
    </main>
    <!-- Footer Start -->
    <?php include_once '_footer.php'; ?>
    <?php include_once '_redes.php'; ?>
    <div class="search-overlay"></div>
    <!-- jquery -->
    <?php include_once '_js.php'; ?>
</body>
</html>
