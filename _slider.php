<?php
    include_once 'admin/conexion.php';
    $conexion = conectarse();

    $query_foto = "SELECT foto,fk_idpagina,fk_idsubpagina FROM tbfoto WHERE fk_idpagina = 1";
    $resultado_foto = mysqli_query($conexion, $query_foto);

    mysqli_close($conexion);
?>

<div id="carouselExampleCaptions" class="carousel slide" data-bs-ride="carousel">
    <div class="carousel-inner">
        <?php if(mysqli_num_rows($resultado_foto) > 0) {?>
            <?php while($row = mysqli_fetch_assoc($resultado_foto)) { ?>
                <div class="carousel-item active">
                    <img src="admin/source/img/Foto/<?php echo $row['foto'] ?>" rel="preload" as="image" class="d-block w-100" alt="..." style="object-fit: cover; height: 700px;">
                    <div class="carousel-caption d-md-block">
                        <h2 class="text-white"><strong>Defensoría Universitaria</sstrong></h2><br/>
                        <h6 class="text-white">El saber te empodera para defender tus derechos</h6><br/>
                        <div>
                            <a href="https://docs.google.com/forms/d/e/1FAIpQLSeVabJzx6XeIgCa8qoGDGl1Q0PhE__P5075ShWTd9-BI4CCmg/viewform" class="btn btn-primary" target="_blank">Formula tu queja</a>
                        </div>
                    </div>
                </div>
            <?php } ?>
        <?php } ?>        
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
    </button>
</div>
<style>
    .carousel-caption {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    left: 0;
    right: 0;
    text-align: center;
    }

    .carousel-item::before {
    content: "";
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5);
    }
    .text-white {
    font-size: 35px; 
    }

    .btn-primary {
        font-size: 18px;
        padding: 20px 30px;
    }
    @media only screen and (max-width: 767px) {
    #carouselExampleCaptions .carousel-caption {
        bottom: 0;
        left: 0;
        right: 0;
    }

    #carouselExampleCaptions .text-white {
        font-size: 13px;
    }

    #carouselExampleCaptions .btn-primary {
        font-size: 10px; 
        padding: 8px 5px;
    }

    #carouselExampleCaptions .carousel-item img {
        max-width: 100%;
        height: auto;
        max-height: 200px;
    }
}
</style>