<?php
    include_once __DIR__ . '/../Model/personalModel.php';

    class personalController {
        private $personalModel;

        public function __construct()
        {
            $this->personalModel = new personalModel();
        }

        //ADMINISTRADOR
        public function insertarPersonal($data){
            $foto = $_FILES['filepersonal'];
            
            if($foto['error'] !== UPLOAD_ERR_OK){
                echo "<script>
                        window.alert('No se registró correctamente el Integrante.');
                        window.location.href = '../Views/Admin/personaladmin.php';
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
                        window.location.href = '../Views/Admin/personaladmin.php';
                    </script>";
                return;
            }

            $rutaDestino = realpath('../source/img/Personal') . '/' . $nombreFoto;

            if (move_uploaded_file($foto['tmp_name'], $rutaDestino)) {
                $data['foto'] = $nombreFoto;
                $this->personalModel->insertarPersonal($data);
            } else {
                echo "<script>
                        window.alert('No se subio la imagen correctamente en la informacion del Integrante.');
                        window.location.href = '../Views/Admin/personaladmin.php';
                    </script>";
            }
        }

        public function updatePersonal($data){
            $this->personalModel->updatePersonal(
                $data['idintegrante'],
                $data['nompersonal'],
                $data['apepersonal'],
                $data['correopersonal'],
                $data['cargopersonal'],
                $data['profesionpersonal']
            );
        }

        public function eliminarPersonal($idintegrante){
            $this->personalModel->eliminarPersonal($idintegrante);
        }


        //PERSONAL
        public function insertarPersonal2($data){
            $foto = $_FILES['filepersonal']; 

            if($foto['error'] !== UPLOAD_ERR_OK){
                echo "<script>
                        window.alert('No se registró correctamente el Integrante.');
                        window.location.href = '../Views/Personal/personalusuario.php';
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
                        window.location.href = '../Views/Personal/personalusuario.php';
                    </script>";
                return;
            }

            $rutaDestino = realpath('../source/img/Personal') . '/' . $nombreFoto;

            if (move_uploaded_file($foto['tmp_name'], $rutaDestino)) {
                $data['foto'] = $nombreFoto;
                $this->personalModel->insertarPersonal2($data);
            } else {
                echo "<script>
                        window.alert('No se subio la imagen correctamente en la informacion del Integrante.');
                        window.location.href = '../Views/Personal/personalusuario.php';
                    </script>";
            }
        }

        public function updatePersonal2($data){
            $this->personalModel->updatePersonal2(
                $data['idintegrante'],
                $data['nompersonal'],
                $data['apepersonal'],
                $data['correopersonal'],
                $data['cargopersonal'],
                $data['profesionpersonal']
            );
        }
    }

    $controller = new personalController();

    if($_SERVER["REQUEST_METHOD"] == "POST"){
        if(isset($_POST['accion']) && $_POST['accion'] === 'registrar'){
            $data = array(
                'nompersonal' => $_POST['nompersonal'],
                'apepersonal' => $_POST['apepersonal'],
                'correopersonal' => $_POST['correopersonal'],
                'cargopersonal' => $_POST['cargopersonal'],
                'profesionpersonal' => $_POST['profesionpersonal'],
                'foto' => $_POST['foto']
            );

            $controller->insertarPersonal($data);
        }
        elseif(isset($_POST['accion']) && $_POST['accion'] === 'update')
        {
            $data = array(
                'idintegrante' => $_POST['idintegrante'],
                'nompersonal' => $_POST['nompersonal'],
                'apepersonal' => $_POST['apepersonal'],
                'correopersonal' => $_POST['correopersonal'],
                'cargopersonal' => $_POST['cargopersonal'],
                'profesionpersonal' => $_POST['profesionpersonal']
            );

            $controller->updatePersonal($data);
        }elseif(isset($_POST['accion']) && $_POST['accion'] === 'eliminar'){
            $idintegrante = $_POST['idintegrante'];
            $controller->eliminarPersonal($idintegrante);
        }elseif(isset($_POST['accion']) && $_POST['accion'] === 'registrar2'){
            $data = array(
                'nompersonal' => $_POST['nompersonal'],
                'apepersonal' => $_POST['apepersonal'],
                'correopersonal' => $_POST['correopersonal'],
                'cargopersonal' => $_POST['cargopersonal'],
                'profesionpersonal' => $_POST['profesionpersonal'],
                'foto' => $_POST['foto']
            );

            $controller->insertarPersonal2($data);
        }elseif(isset($_POST['accion']) && $_POST['accion'] === 'update2'){
            $data = array(
                'idintegrante' => $_POST['idintegrante'],
                'nompersonal' => $_POST['nompersonal'],
                'apepersonal' => $_POST['apepersonal'],
                'correopersonal' => $_POST['correopersonal'],
                'cargopersonal' => $_POST['cargopersonal'],
                'profesionpersonal' => $_POST['profesionpersonal']
            );

            $controller->updatePersonal2($data);
        }
    }
?>
