<?php
    $opcion = 5;
    include_once 'admin/conexion.php';
    $conexion = conectarse();

    $query = "SELECT nombremultimedia, enlace FROM tbmultimedia";
    $resultado = mysqli_query($conexion, $query);
    $multimedia_data = [];
    while ($row = mysqli_fetch_assoc($resultado)) {
        $multimedia_data[] = $row;
    }

    mysqli_close($conexion);
?>
<!DOCTYPE html>
<html lang="es" dir="lrt">
<head>
    <?php include '_head.php'; ?>
    <title>Defensoria Universitaria - UNJBG</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .sidebar {
            width: 250px;
            float: left;
            padding: 20px;
            display: flex;
            flex-direction: column;
            gap: 10px;
        }
        .sidebar a {
            display: block;
            padding: 10px;
            margin: 5px 0;
            background-color: #ccc;
            text-decoration: none;
            color: #000;
            border-radius: 5px;
        }
        .sidebar a.active {
            background: #007bff;
            color: #fff;
        }
        .content {
            margin-left: 270px;
            padding: 20px;
        }
        .content iframe {
            width: 100%;
            height: 900px;
            border: none;
        }
        .content h2 {
            color: #007bff;
        }

        @media (max-width: 767px) {
            .sidebar {
                width: 100%; 
                float: none;
                margin-bottom: 20px;
            }
            
            .content {
                margin-left: 0; 
            }
            
            .content iframe {
                height: 400px; 
            }
        }

        @media (min-width: 768px) {
            .sidebar {
                width: 250px;
                float: left;
            }
            .content {
                margin-left: 270px;
            }
        }
    </style>
</head>
<body>
    <?php include_once '_header.php'; ?>
    <main>
        <section class="about-area bottom-padding1 position-relative">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                    <div class="section-title mb-30">
                        <?php if (!empty($multimedia_data)) { ?>
                            <div class="sidebar">
                                <?php foreach ($multimedia_data as $item): ?>
                                    <a href="#<?php echo $item['nombremultimedia']; ?>" onclick="showContent('<?php echo $item['nombremultimedia']; ?>')">
                                        <?php echo $item['nombremultimedia']; ?>
                                    </a>
                                <?php endforeach; ?>
                            </div>
                            <div class="content" id="content">
                                <h2><center><?php echo $multimedia_data[0]['nombremultimedia']; ?></center></h2>
                                <div class="iframe-container">
                                    <iframe src="<?php echo $multimedia_data[0]['enlace']; ?>"></iframe>
                                </div>
                            </div>
                        <?php } else { ?>
                            <br/>
                            <p><center>No hay multimedia disponible en este momento.</center></p>
                        <?php } ?>
                        <script>
                            const multimediaData = <?php echo json_encode($multimedia_data); ?>;

                            function showContent(section) {
                                const selectedContent = multimediaData.find(item => item.nombremultimedia === section);

                                document.querySelectorAll('.sidebar a').forEach(a => a.classList.remove('active'));
                                document.querySelector(`.sidebar a[href="#${section}"]`).classList.add('active');

                                document.getElementById('content').innerHTML = `
                                    <h2><center>${selectedContent.nombremultimedia}</center></h2>
                                    <div class="iframe-container">
                                        <iframe src="${selectedContent.enlace}"></iframe>
                                    </div>
                                `;
                            }
                        </script>
                    </div>
                    </div>
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
</body>
</html>
