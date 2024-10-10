<?php
    define('INFO_DIV', "<div class='information-info'>");
    define('CLEAR_BOTH', "<div style='clear:both;'></div>");
    define('CLOSE_DIV', "</div>");
    define('LINE_BREAK', "<br/>");        
    include_once 'admin/Model/informacionModel.php';
    include_once 'admin/Model/paginaModel.php';
    include_once 'admin/conexion.php';    
    $informacionModel = new informacionModel();
    $paginaModel = new paginaModel();    
    $paginaPrincipalId = 0;
    $subpaginaId = 1;    
    $informacionesPrincipal = $informacionModel->listarInformacionPorPagina($paginaPrincipalId);
    $informacionesSubpagina = $informacionModel->listarInformacionPorSubpagina($subpaginaId);
    $listasPrincipal = $paginaModel->obtenerListasPorPagina($paginaPrincipalId);
    $listasSubpagina = $paginaModel->obtenerListasPorSubpagina($subpaginaId);    
    $fotosPorPagina = 1;
    $paginaActual = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;    
    $fotosTodas = ($paginaPrincipalId != 0) ? $paginaModel->obtenerFotosPorPagina($paginaPrincipalId) : $paginaModel->obtenerFotosPorSubpagina($subpaginaId);
    $fotosTotal = count($fotosTodas);
    $offset = ($paginaActual - 1) * $fotosPorPagina;
    $fotosMostradas = array_slice($fotosTodas, $offset, $fotosPorPagina);
    $totalPaginas = ceil($fotosTotal / $fotosPorPagina);
    $paginaMostrar = 1;
?>
<!DOCTYPE html>
    <html lang='es' dir='ltr'>
        <head>
        <title>Defensoria Universitaria - UNJBG</title>
            <?php include_once '_head.php'; ?>
            <style>
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
                    <div class='container-custom'>
                        <div class='row'>
                            <div class='col-md-12'>
                                <div class='photo-gallery'>
                                    <?php
                                    if ($paginaPrincipalId != 0 || $subpaginaId != 0) {
                                        foreach ($fotosMostradas as $foto) {
                                            echo "<center><h3>Galeria de Fotos</h3></center>";
                                            echo "<img src='admin/source/img/Foto/{$foto['foto']}' alt='Foto'>";
                                        }
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class='container-custom'>
                        <div class='row'>
                            <div class='col-md-12 text-center'>
                                <nav aria-label='Page navigation'>
                                    <ul class='pagination'>
                                        <?php
                                        if ($paginaActual > 1) {
                                            echo "<li class='page-item'><a class='page-link' href='?pagina=" . ($paginaActual - 1) . "'>&laquo;</a></li>";
                                        }
                                        for ($i = max(1, $paginaActual - 1); $i <= min($paginaActual + 1, $totalPaginas); $i++) {
                                            echo "<li class='page-item " . ($i == $paginaActual ? 'active' : '') . "'><a class='page-link' href='?pagina=$i'>$i</a></li>";
                                        }
                                        if ($paginaActual < $totalPaginas) {
                                            echo "<li class='page-item'><a class='page-link' href='?pagina=" . ($paginaActual + 1) . "'>&raquo;</a></li>";
                                        }
                                        ?>
                                    </ul>
                                </nav>
                            </div>
                        </div>
                    </div>
                </section>
            <?php include_once '_links.php'; ?>
            </main>
            <?php include_once '_footer.php'; ?>
            <?php include_once '_redes.php'; ?>
            <div class="search-overlay"></div>
            <?php include_once '_js.php'; ?>
    </body>
</html>