<?php 
    $opcion = 7;
    include_once 'admin/conexion.php';
    $conexion = conectarse();

    $query = "SELECT * FROM tbmarcolegal";
    $resultado = mysqli_query($conexion, $query);

    mysqli_close($conexion);
?>
<!DOCTYPE html>
<html lang="es" dir="lrt">
<head>
    <?php include '_head.php'; ?>
    <style>
        .card-container {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
        }

        .card {
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            height: 100%;
        }

        .card-body {
            flex-grow: 1;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            text-align: center;
        }

        .card img {
            height: 120px;
            width: 120px;
            margin-bottom: 10px;
            
        }

        .card .btn {
            margin-top: auto;
        }
    </style>
</head>
<body>
    <?php include '_header.php'; ?>
    <main>
        <section class="about-area bottom-padding1 position-relative">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="section-title mb-30">
                            <h4 class="text-center text-primary">Marco legal</h4><br>
                            <div class="row">
                            <?php
                            if (mysqli_num_rows($resultado) > 0) {
                                while ($row = mysqli_fetch_assoc($resultado)) {
                            ?>
                            <div class="col-12 col-sm-6 col-md-3 mb-4">
                                <div class="card">
                                    <div class="card-body">
                                        <center>
                                        <img src="img/pdf_logo.png" class="img-fluid mb-2">
                                        </center>
                                        <i class="fas fa-file-word card-icon"></i>
                                        <h6 class="card-title mt-3"><?php echo $row['nombremarco']; ?></h6><br/>
                                        <a type="button" class="btn btn-outline-primary" href="<?php echo $row['nombrearchivo'] ?>" target="_blank" rel="noopener"><strong>Visualizar</strong></a>
                                    </div>
                                </div>
                            </div>
                            <?php
                                }
                            } else {
                            ?>
                                <p class="no-data-message text-center">No hay documentos disponibles.</p>
                            <?php
                            }
                            ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="shape-bg-about">
                <img src="assets/images/icon/bg-shape-2.png" alt="">
            </div>
        </section>
        <?php include '_links.php'; ?>
    </main>
    <!-- Footer Start -->
    <?php include '_footer.php'; ?>
    <?php include '_redes.php'; ?>
    <div class="search-overlay"></div>
    <!-- jquery-->
    <?php include '_js.php'; ?>
</body>
</html>
