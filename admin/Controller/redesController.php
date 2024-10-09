<?php
    include_once __DIR__ . '/../Model/redesModel.php';

    class redesController{
        private $redesModel;

        public function __construct()
        {
            $this->redesModel = new redesModel();
        }

        //ADMINISTRADOR
        public function insertarRed($data){
            $imagen = $_FILES['fileimagen'];

            if($imagen['error'] !== UPLOAD_ERR_OK){
                echo "<script>
                        window.alert('No se registró correctamente la Red Social.');
                        window.location.href = '../Views/Admin/redesadmin.php';
                    </script>";

                return;
            }

            $nombreFoto = basename($imagen['name']);
            $nombreFoto = uniqid() . '_' . preg_replace('/[^a-zA-Z0-9._-]/', '', $nombreFoto);
            $allowedExtensions = ['jpg', 'jpeg', 'png'];
            $fileExtension = pathinfo($nombreFoto, PATHINFO_EXTENSION);

            if (!in_array(strtolower($fileExtension), $allowedExtensions)) {
                echo "<script>
                        window.alert('El formato del archivo no está permitido.');
                        window.location.href = '../Views/Admin/redesadmin.php';
                    </script>";
                return;
            }

            $rutaDestino = realpath('../source/img/Red') . '/' . $nombreFoto;

            if(move_uploaded_file($imagen['tmp_name'], $rutaDestino)){
                $data['imagen'] = $nombreFoto;
                $this->redesModel->insertarRed($data);
            }else{
                echo "<script>
                        window.alert('No se subio la imagen correctamente en la Red Social.');
                        window.location.href = '../Views/Admin/redesadmin.php';
                    </script>";
            }
        }

        public function updateRed($data){
            $this->redesModel->updateRed(
                $data['idred'],
                $data['nomred'],
                $data['enlace']
            );
        }

        public function eliminarRed($idred){
            $this->redesModel->eliminarRed($idred);
        }
        
        //PERSONAL
        public function insertarRedPersonal($data){
            $imagen = $_FILES['fileimagen'];

            if($imagen['error'] !== UPLOAD_ERR_OK){
                echo "<script>
                        window.alert('No se registró correctamente la Red Social.');
                        window.location.href = '../Views/Personal/redespersonal.php';
                     </script>"; 

                return;
            }

            $nombreFoto = basename($imagen['name']);
            $nombreFoto = uniqid() . '_' . preg_replace('/[^a-zA-Z0-9._-]/', '', $nombreFoto);
            $allowedExtensions = ['jpg', 'jpeg', 'png'];
            $fileExtension = pathinfo($nombreFoto, PATHINFO_EXTENSION);

            if (!in_array(strtolower($fileExtension), $allowedExtensions)) {
                echo "<script>
                        window.alert('El formato del archivo no está permitido.');
                        window.location.href = '../Views/Personal/redespersonal.php';
                    </script>";
                return;
            }

            $rutaDestino = realpath('../source/img/Red') . '/' . $nombreFoto;

            if(move_uploaded_file($imagen['tmp_name'], $rutaDestino)){
                $data['imagen'] = $nombreFoto;
                $this->redesModel->insertarRedPersonal($data);
            }else{
                echo "<script>
                        window.alert('No se subio la imagen correctamente en la Red Social.');
                        window.location.href = '../Views/Personal/redespersonal.php';
                    </script>";
            }
        }

        public function updateRedPersonal($data){
            $this->redesModel->updateRedPersonal(
                $data['idred'],
                $data['nomred'],
                $data['enlace']
            );
        }

    }

    $controller = new redesController();

    if($_SERVER["REQUEST_METHOD"] == "POST"){
        if(isset($_POST['accion']) && $_POST['accion'] === 'registrarred'){
            $data = array(
                'nomred' => $_POST['nomred'],
                'imagen' => $_POST['imagen'],
                'enlace' => $_POST['enlace']
            );
            $controller->insertarRed($data);
        }elseif(isset($_POST['accion']) && $_POST['accion'] === 'updatered'){
            $data = array(
                'idred' => $_POST['idred'],
                'nomred' => $_POST['nomred'],
                'enlace' => $_POST['enlace'],

            );
            $controller->updateRed($data);
        }elseif(isset($_POST['accion']) && $_POST['accion'] === 'eliminarred'){
            $idred = $_POST['idred'];
            $controller->eliminarRed($idred);
        }elseif(isset($_POST['accion']) && $_POST['accion'] === 'registraredpersonal'){
            $data = array(
                'nomred' => $_POST['nomred'],
                'imagen' => $_POST['imagen'],
                'enlace' => $_POST['enlace']
            );

            $controller->insertarRedPersonal($data);
        }elseif(isset($_POST['accion']) && $_POST['accion'] === 'updateredpersonal'){
            $data = array(
                'idred' => $_POST['idred'],
                'nomred' => $_POST['nomred'],
                'enlace' => $_POST['enlace'],

            );
            $controller->updateRedPersonal($data);
        }
    }   

?>