<?php
    include_once 'admin/conexion.php';
    $conexion = conectarse();

    $query_enlaces = "SELECT nomenlace,enlace,foto FROM tbenlacedirecto;";
    $resultado_enlace = mysqli_query($conexion, $query_enlaces);
    mysqli_close($conexion);
?>
<section class="brand-area">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-12 text-center">
                <div class="border-section-title">
                    <h4 class="title">Enlaces directos</h4>
                </div>
                <div class="swiper brandSwiper-active d-flex justify-content-center">                    
                    <div class="swiper-wrapper">
                        <?php if(mysqli_num_rows($resultado_enlace)>0){ ?>
                            <?php while($row = mysqli_fetch_assoc($resultado_enlace)){ ?>
                            <div class="swiper-slide">
                                <a href="<?php echo $row['enlace'] ?>" target="_blank" rel="noopener"><img src="admin/source/img/Enlace/<?php echo $row['foto'] ?>" alt="<?php echo $row['nomenlace'] ?>" style="width: 500px;height:80px"></a>
                            </div>
                            <?php }?>
                        <?php } else { ?>
                            <p style="text-align: center;">Todavía no hay enlaces directos</p>
                        <?php }?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
