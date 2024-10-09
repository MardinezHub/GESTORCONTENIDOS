<?php 
    $opcion = 6;
?>
<!DOCTYPE html>
<html lang="es" dir="ltr">
<head>
    <?php include '_head.php'; ?>
    <style>
        .contact-info {
            background-color: #f9f9f9;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0px 0px 20px rgba(0, 0, 0, 0.1);
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
        }

        .contact-info h4 {
            color: #333;
            font-size: 28px;
            font-weight: bold;
            margin-bottom: 20px;
            text-transform: uppercase;
        }

        .contact-info a.button {
            display: inline-block;
            padding: 10px 20px;
            background-color: #007bff;
            color: #fff;
            border-radius: 5px;
            text-decoration: none;
            transition: background-color 0.3s ease;
        }

        .contact-info a.button:hover {
            background-color: #0056b3;
        }

        .contact-info b {
            color: #555;
        }

        .contact-info p {
            color: #666;
            margin-bottom: 20px;
        }

        .contact-info ul {
            list-style-type: none;
            padding: 0;
        }

        .contact-info ul li {
            margin-bottom: 10px;
        }

        .contact-info ul li i {
            margin-right: 10px;
            color: #007bff;
        }

        .contact-info-left {
            flex: 1 1 60%;
        }

        .contact-info-right {
            flex: 1 1 35%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .contact-info-right img {
            max-width: 100%;
            height: auto;
        }

        @media (max-width: 768px) {
            .contact-info {
                padding: 20px;
                flex-direction: column;
                align-items: center;
            }
            .contact-info-right {
                margin-top: 20px;
            }
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
                            <div class="contact-info">
                                <div class="contact-info-left">
                                    <h4>Contáctanos</h4>
                                    <div>
                                        <ul>
                                            <li>Si tienes alguna queja, reclamo o denuncia, te invitamos a completar nuestro formulario:</li>
                                            <li><a href="https://docs.google.com/forms/d/e/1FAIpQLSeVabJzx6XeIgCa8qoGDGl1Q0PhE__P5075ShWTd9-BI4CCmg/viewform" class="button" target="_blank" rel="noopener">Formulario de Quejas, Reclamos y Denuncias </a></li>
                                            <li><b>Por medio de correo electrónico:</b></li>
                                            <li>- Para denuncias, quejas y reclamos: <a href="mailto:defu@unjbg.edu.pe">defu@unjbg.edu.pe</a></li>
                                            <li>- Casos de hostigamiento sexual: <a href="mailto:comite-hostigamiento@unjbg.edu.pe">comite-hostigamiento@unjbg.edu.pe</a></li>
                                            <li><b>Si deseas apersonarse a nuestras oficinas nos puedes ubicar:</b></li>
                                            <li>- Estamos en el 4to piso de la Escuela Profesional de Artes</li>
                                            <li><b>Telefonos (de lunes a viernes):</b></li>
                                            <li>- <a href="tel:952860666">952 860 666</a></li>
                                            <li>- <a href="tel:952954273">952 954 273</a></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="contact-info-right">
                                    <img src="img/servicio.png" alt="Imagen de contacto">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <?php include '_links.php'; ?>
    </main>
    <!-- Footer S t a r t -->
    <?php include '_footer.php'; ?>
    <?php include '_redes.php'; ?>
    <div class="search-overlay"></div>
    <!-- jquery-->
    <?php include '_js.php'; ?>
</body>
</html>