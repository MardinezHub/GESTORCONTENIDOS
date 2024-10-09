<?php
    function loadEnv($path)
    {
        if (!file_exists($path)) {
            throw new Exception("El archivo .env no se encuentra en la ruta especificada.");
        }

        $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        foreach ($lines as $line) {
            if (strpos(trim($line), '#') === 0) {
                continue;
            }

            list($name, $value) = explode('=', $line, 2);

            $name = trim($name);
            $value = trim($value);

            $value = trim($value, '"\'');
            
            $_ENV[$name] = $value;
        }
    }

    loadEnv(__DIR__ . '/.env');

    function conectarse()
    {
        $host = $_ENV['DB_HOST'];
        $usuario = $_ENV['DB_USERNAME'];
        $password = $_ENV['DB_PASSWORD'];
        $base_datos = $_ENV['DB_DATABASE'];

        $link = mysqli_connect("p:" . $host, $usuario, $password, $base_datos);

        if (!$link) {
            echo "<script>alert('No se pudo establecer la conexión a la base de datos.');</script>";
            die("Error de conexión: " . mysqli_connect_error());
        }

        return $link;
    }

    $con = conectarse();
?>
