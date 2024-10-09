<?php 
    include_once __DIR__ . '../../Model/fotoModel.php';

    class fotoController{
        private $fotoModel;

        public function __construct()
        {
            $this->fotoModel = new fotoModel();
        }

        //ADMINISTRADOR
        public function insertarfoto($data){
            $foto = $_FILES['filefoto'];

            if($foto['error'] !== UPLOAD_ERR_OK){
                echo "<script>
                        window.alert('No se registro correctamente la foto para la Pagina o Subpagina.');
                        window.location.href = '../Views/Admin/fotoadmin.php';
                      </script>";
                
                return;
            }

            $nombreFoto = basename($foto['name']);
            $nombreFoto = uniqid() . '_' . preg_replace('/[^a-zA-Z0-9._-]/', '', $nombreFoto);
            $allowedExtensions = ['jpg', 'jpeg', 'png'];
            $fileExtension = pathinfo($nombreFoto, PATHINFO_EXTENSION);

            if(!in_array(strtolower($fileExtension), $allowedExtensions)){
                echo "<script>
                        window.alert('El formato del archivo no está permitido.');
                        window.location.href = '../Views/Admin/fotoadmin.php';
                    </script>";
                return;
            }

            $rutaDestino = realpath('../source/img/Foto') . '/' . $nombreFoto;

            if(move_uploaded_file($foto['tmp_name'], $rutaDestino)){
                $data['foto'] = $nombreFoto;
                $this->fotoModel->insertarfoto($data);
            }else{
                echo "<script>
                        window.alert('No se subio la foto correctamente para la Pagina o SubPagina.');
                        window.location.href = '../Views/Admin/fotoadmin.php';
                    </script>";
            }
        }

        public function updatefoto($data){
            $this->fotoModel->updatefoto(
                $data['idfoto'],
                $data['fk_idpagina'],
                $data['fk_idsubpagina']
            );
        }

        public function eliminarfoto($idfoto){
            $this->fotoModel->eliminarfoto($idfoto);
        }

        //PERSONAL
        public function insertarfotoPersonal($data){
            $foto = $_FILES['filefoto'];

            if($foto['error'] !== UPLOAD_ERR_OK){
                echo "<script>
                        window.alert('No se registró correctamente la foto de la Pagina o SubPagina.');
                        window.location.href = '../Views/Personal/fotopersonal.php';
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
                        window.location.href = '../Views/Personal/fotopersonal.php';
                    </script>";
                return;
            }

            $rutaDestino = realpath('../source/img/Foto') . '/' . $nombreFoto;

            if(move_uploaded_file($foto['tmp_name'], $rutaDestino)){
                $data['foto'] = $nombreFoto;
                $this->fotoModel->insertarfotoPersonal($data);
            }else{
                echo "<script>
                        window.alert('No se subio la foto correctamente para la Pagina o SubPagina.');
                        window.location.href = '../Views/Personal/fotopersonal.php';
                    </script>";
            }
        }

        public function updatefotoPersonal($data){
            $this->fotoModel->updatefotoPersonal(
                $data['idfoto'],
                $data['fk_idpagina'],
                $data['fk_idsubpagina']
            );
        }
    }

    $controller = new fotoController();

    if($_SERVER["REQUEST_METHOD"] == "POST"){
        if(isset($_POST['accion']) && $_POST['accion'] === 'registrarfoto'){
            $data = array(
                'foto' => $_POST['foto'],
                'fk_idpagina' => $_POST['fk_idpagina'],
                'fk_idsubpagina' => $_POST['fk_idsubpagina']
            );

            $controller->insertarfoto($data);
        }elseif(isset($_POST['accion']) && $_POST['accion'] === 'updatefoto'){
            $data = array(
                'idfoto' => $_POST['idfoto'],
                'fk_idpagina' => $_POST['fk_idpagina'],
                'fk_idsubpagina' => $_POST['fk_idsubpagina']
            );

            $controller->updatefoto($data);
        }elseif(isset($_POST['accion']) && $_POST['accion'] === 'eliminarfoto'){
            $idfoto = $_POST['idfoto'];
            $controller->eliminarfoto($idfoto);
        }elseif(isset($_POST['accion']) && $_POST['accion'] === 'registrarfotopersonal'){
            $data = array(
                'foto' => $_POST['foto'],
                'fk_idpagina' => $_POST['fk_idpagina'],
                'fk_idsubpagina' => $_POST['fk_idsubpagina']
            );

            $controller->insertarfotoPersonal($data);
        }elseif(isset($_POST['accion']) && $_POST['accion'] === 'updatefotopersonal'){
            $data = array(
                'idfoto' => $_POST['idfoto'],
                'fk_idpagina' => $_POST['fk_idpagina'],
                'fk_idsubpagina' => $_POST['fk_idsubpagina']
            );

            $controller->updatefotoPersonal($data);
        }
    }
?>