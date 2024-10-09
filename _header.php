<?php 
    include_once 'admin/conexion.php';
    include_once 'admin/Model/paginaModel.php';

    $paginaModel = new paginaModel();

    $paginas = $paginaModel->obtenerPaginasPrincipales();
    $headers = $paginaModel->headerlista();
    
?>
<header>
        <div class="header-area">
            <div class="main-header">
                <!-- Header Top -->
                <div class="header-top">
                    <div class="container">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="top-menu-wrapper d-flex align-items-center justify-content-between">
                                    <!-- Top Left Side -->
                                    <div class="top-header-left d-flex align-items-center">
                                        <!-- Logo-->
                                        <div class="logo">
                                            <a href="index.php"><img src="assets/images/logo/logo.png" alt="logo" class="changeLogo" style="height: 100px;"></a>
                                        </div>
                                    </div>
                                    <!--Top Right Side -->
                                    <div class="top-header-right">
                                        <!-- contact us -->
                                        <div class="contact-section">
                                            <div class="circle-primary-sm">
                                                <i class="ri-mail-line"></i>
                                            </div>
                                            <div class="info">
                                                <p class="pera">Escríbenos</p>
                                                <h4 class="title">
                                                    <?php echo $headers['correo']?>
                                                </h4>
                                            </div>
                                        </div>
                                        <div class="contact-section">
                                            <div class="circle-primary-sm">
                                                <i class="ri-phone-line"></i>
                                            </div>
                                            <div class="info">
                                                <p class="pera">Llámanos</p>
                                                <h4 class="title">
                                                    <a href="tel:<?php echo $headers['telefono']?>"><?php echo $headers['telefono']?></a>
                                                </h4>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Header Bottom -->
                <div class="barra header-sticky" style="background-color: <?php echo $headers['color']?>;">
                    <div class="container" >
                        <div class="row" >
                            <div class="col-lg-12" >
                                <div class="menu-wrapper">
                                    <!-- Main-menu for desktop -->
                                    <div class="main-menu d-none d-lg-block" >
                                        <nav>
                                            <div class="d-flex justify-content-between align-items-center">
                                                <ul class="listing" id="navigation" >
                                                    <li class="single-list">
                                                        <a href="index.php" class="single <?php if($opcion==1){ echo "link-active"; } ?>">Inicio</a>
                                                    </li>
                                                    <?php foreach ($paginas as $pagina) : ?>
                                                        <?php
                                                        $subpaginas = $paginaModel->obtenerSubpaginas($pagina['idpagina']);
                                                        ?>
                                                        <li class="single-list">
                                                            <?php if (!empty($subpaginas)) : ?>
                                                                <a href="#" class="single"><?= $pagina['nombrepagina'] ?> <i class="ri-arrow-down-s-line"></i></a>
                                                                <ul class="submenu">
                                                                    <?php foreach ($subpaginas as $subpagina) : ?>
                                                                        <li class="single-list">
                                                                            <a href="<?= $subpagina['archivo'] ?>" class="single <?= ($opcion == $subpagina['idsubpagina']) ? 'link-active' : '' ?>">
                                                                                <?= $subpagina['nombresub'] ?>
                                                                            </a>
                                                                        </li>
                                                                    <?php endforeach; ?>
                                                                </ul>
                                                            <?php else : ?>
                                                                <a href="<?= $pagina['archivo'] ?>" class="single <?= ($opcion == $pagina['idpagina']) ? 'link-active' : '' ?>">
                                                                    <?= $pagina['nombrepagina'] ?>
                                                                </a>
                                                            <?php endif; ?>
                                                        </li>
                                                    <?php endforeach; ?>                                                    
                                                    <li class="single-list">
                                                        <a href="marco-legal.php" class="single <?php if($opcion==7){ echo "link-active"; } ?>">Marco Legal</a>
                                                    </li>
                                                    <li class="single-list">
                                                        <a href="Multimedia.php" class="single <?php if($opcion==5){ echo "link-active"; } ?>">Multimedia</a>
                                                    </li>
                                                    <li class="single-list">
                                                        <a href="contacto.php" class="single <?php if($opcion==6){ echo "link-active"; } ?>">Contáctanos</a>
                                                    </li>
                                                </ul>

                                            </div>
                                        </nav>
                                    </div>
                                </div>
                                <!-- Mobile Menu -->
                                <div class="div">
                                    <div class="mobile_menu d-block d-lg-none"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Search box -->
            <div class="search-container">
                <div class="top-section">
                    <div class="search-icon">
                        <i class="ri-search-line"></i>
                    </div>
                    <div class="modal-search-box">
                        <input type="text" id="searchField" class="search-field" placeholder="Destination, Agency, Country">
                        <button id="closeSearch" class="close-search-btn">
                            <kbd class="light-text"> ESC </kbd>
                        </button>
                    </div>
                </div>
                <div class="body-section">
                    <div class="row">
                        <div class="div">
                            <div class="filter_menu"></div>
                        </div>
                    </div>
                </div>
            </div>
        <!-- / End-Search -->
    </div>
</header>

<style>    
   @media only screen and (max-width: 767px) {
        .top-header-left .logo {
            display: flex;
        }
        .top-menu-wrapper {
            flex-direction: column;
            align-items: center;
        }

        .top-header-left .logo img {
            max-width: 100%;
        }

        .top-header-right {
            text-align: center;
            margin-top: 20px;
        }

        .contact-section {
            margin-bottom: 10px;
        }
        
    }

    @media only screen and (max-width: 767px) {
        .top-header-right {
            display: block !important;
        }
    }
</style>