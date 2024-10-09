<?php
    include_once __DIR__ . '/../Model/publicacionModel.php';

    class publicacionController{
        private $publicacionModel;

        public function __construct()
        {
            $this->publicacionModel = new publicacionModel();
        }


        //ADMINISTRADOR
        public function insertarPublicacion($data){
            $foto = $_FILES['filepublicacion'];

            if($foto['error'] !== UPLOAD_ERR_OK){
                echo "<script>
                        window.alert('No se registró correctamente el Comunicado.');
                        window.location.href = '../Views/Admin/publicacionadmin.php';
                    </script>";

                return;
            }
            
            $nombreFoto = basename($foto['name']);
            $nombreFoto = uniqid() . '_' . preg_replace('/[^a-zA-Z0-9._-]/', '', $nombreFoto);
            $allowedExtensions = ['jpg', 'jpeg', 'png'];
            $fileExtension = pathinfo($nombreFoto, PATHINFO_EXTENSION);

            if (!in_array(strtolower($fileExtension), $allowedExtensions)) {
                echo "<script>
                        window.alert('El formato del archivo no está permitido.');
                        window.location.href = '../Views/Admin/publicacionadmin.php';
                    </script>";
                return;
            }

            $rutaDestino = realpath('../source/img/Publicacion') . '/' . $nombreFoto;

            if(move_uploaded_file($foto['tmp_name'],$rutaDestino)){
                $data['foto'] = $nombreFoto;
                $this->publicacionModel->insertarPublicacion($data);
            }else{
                echo "<script>
                        window.alert('No se subio la imagen correctamente en el comunicado.');
                        window.location.href = '../Views/Admin/publicacionadmin.php';
                    </script>";
            }
        }

        public function updatePublicacion($data){
            $this->publicacionModel->updatePublicacion(
                $data['idpublicacion'],
                $data['titulo'],
                $data['descripcion'],
                $data['fechapubli']
            );
        }

        public function eliminarPublicacion($idpublicacion){
            $this->publicacionModel->eliminarPublicacion($idpublicacion);
        }

        //PERSONAL
        public function insertarPublicacionPersonal($data){
            $foto = $_FILES['filepublicacion'];

            if($foto['error'] !== UPLOAD_ERR_OK){
                echo "<script>
                        window.alert('No se registró correctamente el Comunicado.');
                        window.location.href = '../Views/Personal/publicacionpersonal.php';
                    </script>";

                return;
            }

            $nombreFoto = basename($foto['name']);
            $nombreFoto = uniqid() . '_' . preg_replace('/[^a-zA-Z0-9._-]/', '', $nombreFoto);
            $allowedExtensions = ['jpg', 'jpeg', 'png'];
            $fileExtension = pathinfo($nombreFoto, PATHINFO_EXTENSION);

            if (!in_array(strtolower($fileExtension), $allowedExtensions)) {
                echo "<script>
                        window.alert('El formato del archivo no está permitido.');
                        window.location.href = '../Views/Personal/publicacionpersonal.php';
                    </script>";
                return;
            }

            $rutaDestino = realpath('../source/img/Publicacion') . '/' . $nombreFoto;

            if(move_uploaded_file($foto['tmp_name'],$rutaDestino)){
                $data['foto'] = $nombreFoto;
                $this->publicacionModel->insertarPublicacionPersonal($data);
            }else{
                echo "<script>
                        window.alert('No se subio la imagen correctamente en el comunicado.');
                        window.location.href = '../Views/Personal/publicacionpersonal.php';
                    </script>";
            }
        }

        public function updatePublicacionPersonal($data){
            $this->publicacionModel->updatePublicacionPersonal(
                $data['idpublicacion'],
                $data['titulo'],
                $data['descripcion'],
                $data['fechapubli']
            );
        }
    }

    $controller = new publicacionController();

    if($_SERVER["REQUEST_METHOD"] == "POST"){
        if(isset($_POST['accion']) && $_POST['accion'] === 'registrar'){
            $data = array(
                'titulo' => $_POST['titulo'],
                'descripcion' => $_POST['descripcion'],
                'foto' => $_FILES['filepublicacion']['name'],
                'fechapubli' => $_POST['fechapubli']
            );

            $controller->insertarPublicacion($data);
        }elseif(isset($_POST['accion']) && $_POST['accion'] === 'update'){
            $data = array(
                'idpublicacion' => $_POST['idpublicacion'],
                'titulo' => $_POST['titulo'],
                'descripcion' => $_POST['descripcion'],
                'fechapubli' => $_POST['fechapubli']
            );

            $controller->updatePublicacion($data);
        }elseif(isset($_POST['accion']) && $_POST['accion'] === 'eliminar'){
            $idpublicacion = $_POST['idpublicacion'];
            $controller->eliminarPublicacion($idpublicacion);

        }elseif(isset($_POST['accion']) && $_POST['accion'] === 'registrar2'){
            $data = array(
                'titulo' => $_POST['titulo'],
                'descripcion' => $_POST['descripcion'],
                'foto' => $_FILES['filepublicacion']['name'],
                'fechapubli' => $_POST['fechapubli']
            );

            $controller->insertarPublicacionPersonal($data);
        }elseif(isset($_POST['accion']) && $_POST['accion'] === 'update2'){
            $data = array(
                'idpublicacion' => $_POST['idpublicacion'],
                'titulo' => $_POST['titulo'],
                'descripcion' => $_POST['descripcion'],
                'fechapubli' => $_POST['fechapubli']
            );

            $controller->updatePublicacionPersonal($data);
        }
    }

?>
