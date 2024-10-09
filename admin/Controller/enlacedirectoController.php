<?php
    include_once __DIR__ . '/../Model/enlacedirectoModel.php';

    class enlacedirectoController{
        private $enlacedirectoModel;

        public function __construct()
        {
            $this->enlacedirectoModel = new enlacedirectoModel();
        }

        //ADMINISTRADOR
        public function insertarEnlace($data){
            $foto = $_FILES['fileenlace'];

            if($foto['error'] !== UPLOAD_ERR_OK){
                echo "<script>
                        window.alert('No se registro correctamente el Enlace Directo.');
                        window.location.href = '../Views/Admin/enlacesadmin.php';
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
                        window.location.href = '../Views/Admin/enlacesadmin.php';
                    </script>";
                return;
            }

            $rutaDestino = realpath('../source/img/Enlace') . '/' . $nombreFoto;

            if(move_uploaded_file($foto['tmp_name'], $rutaDestino)){
                $data['foto'] = $nombreFoto;
                $this->enlacedirectoModel->insertarEnlace($data);
            }else{
                echo "<script>
                        window.alert('No se subio correctamente la foto del Enlace Directo.');
                        window.location.href = '../Views/Admin/enlacesadmin.php';
                    </script>";
            }
        }

        public function updateEnlace($data){
            $this->enlacedirectoModel->updateEnlace(
                $data['idenlace'],
                $data['nomenlace'],
                $data['enlace'],
                $data['foto']
            );
        }

        public function eliminarEnlace($idenlace){
            $this->enlacedirectoModel->eliminarEnlace($idenlace);
        }

        //PERSONAL
        public function insertarEnlacePersonal($data){
            $foto = $_FILES['fileenlace'];
        
            if($foto['error'] !== UPLOAD_ERR_OK){
                echo "<script>
                        window.alert('No se registro correctamente el Enlace Directo.');
                        window.location.href = '../Views/Personal/enlacespersonal.php';
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
                        window.location.href = '../Views/Personal/enlacespersonal.php';
                    </script>";
                return;
            }
        
            $rutaDestino = realpath('../source/img/Enlace') . '/' . $nombreFoto;
            
            if(move_uploaded_file($foto['tmp_name'], $rutaDestino)){
                $data['foto'] = $nombreFoto;
                $this->enlacedirectoModel->insertarEnlacePersonal($data);
            }else{
                echo "<script>
                        window.alert('No se subio correctamente la foto del Enlace Directo.');
                        window.location.href = '../Views/Personal/enlacespersonal.php';
                    </script>";
            }
        }        

        public function updateEnlacePersonal($data){
            $this->enlacedirectoModel->updateEnlacePersonal(
                $data['idenlace'],
                $data['nomenlace'],
                $data['enlace'],
                $data['foto']
            );
        }
    }

    $controller = new enlacedirectoController();

    if($_SERVER['REQUEST_METHOD'] == "POST"){
        if(isset($_POST['accion']) && $_POST['accion'] === "registrar"){
            $data = array(
                'idenlace' => $_POST['idenlace'],
                'nomenlace' => $_POST['nomenlace'],
                'enlace' => $_POST['enlace'],
                'foto' => $_POST['foto']
            );

            $controller->insertarEnlace($data);
        }elseif(isset($_POST['accion']) && $_POST['accion'] === "update"){
            $data = array(
                'idenlace' => $_POST['idenlace'],
                'nomenlace' => $_POST['nomenlace'],
                'enlace' => $_POST['enlace']
            );

            $controller->updateEnlace($data);
        }elseif(isset($_POST['accion']) && $_POST['accion'] === "eliminar"){
            $idenlace = $_POST['idenlace'];
            $controller->eliminarEnlace($idenlace);
        }elseif(isset($_POST['accion']) && $_POST['accion'] === "registrar2"){
            $data = array(
                'idenlace' => $_POST['idenlace'],
                'nomenlace' => $_POST['nomenlace'],
                'enlace' => $_POST['enlace'],
                'foto' => $_POST['foto']
            );

            $controller->insertarEnlacePersonal($data);
        }elseif(isset($_POST['accion']) && $_POST['accion'] === "update2"){
            $data = array(
                'idenlace' => $_POST['idenlace'],
                'nomenlace' => $_POST['nomenlace'],
                'enlace' => $_POST['enlace']
            );

            $controller->updateEnlacePersonal($data);
        }
    }

?>