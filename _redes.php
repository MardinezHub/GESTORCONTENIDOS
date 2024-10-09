<?php 
    include_once 'admin/conexion.php';
    $conexion = conectarse();

    $query_redes = "SELECT nomred,enlace,imagen FROM tbredes;";
    $resultado_red = mysqli_query($conexion, $query_redes);
    mysqli_close($conexion);
?>
<div class="social-float">
    <?php if(mysqli_num_rows($resultado_red)>0){ ?>
        <?php while($row = mysqli_fetch_assoc($resultado_red)) { ?>
            <a href="<?php echo $row['enlace'] ?>" class="enlacesocial" target="_blank">
                <img src="admin/source/img/Red/<?php echo $row['imagen'] ?>" alt="red" class="social-icon">
            </a>
        <?php } ?>
    <?php } ?>
</div>

<style>
    .social-float {
        position: fixed;
        top: 50%;
        left: 0;
        transform: translateY(-50%);
        display: flex;
        flex-direction: column;
        padding: 0;
    }
    .social-icon {
        width: 40px;
        height: 40px;
        display: block;
        margin: 0;
    }
    @media only screen and (max-width: 767px) {
        .social-float {
            display: none;
        }
    }
</style>
