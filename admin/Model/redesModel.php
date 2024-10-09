<?php 
    include_once __DIR__ . '../../conexion.php';

    class redesModel{
        private $conn;

        public function __construct()
        {
            $this->conn = conectarse();
        }

        //METODOS DE ADMINISTRADOR
        public function listarRed(){
            $query = "SELECT idred,nomred,imagen,enlace FROM tbredes";

            $result = $this->conn->query($query);

            $redes = array();

            if($result->num_rows > 0){
                while($row = $result->fetch_assoc()){
                    $redes[] = $row;
                }
            }

            return $redes;
        }

        public function insertarRed($data){
            $nombred = $this->conn->real_escape_string($data['nomred']);
            $enlace = $this->conn->real_escape_string($data['enlace']);
            $imagen = $this->conn->real_escape_string($data['imagen']);

            $query = "INSERT INTO tbredes(nomred,imagen,enlace) VALUES(?,?,?)";

            if($stmt = $this->conn->prepare($query)){
                $stmt->bind_param("sss",$nombred,$imagen,$enlace);

                if($stmt->execute()){
                    echo "<script>
                            window.alert('Se registró correctamente la Red Social.');
                            window.location.href = '../Views/Admin/redesadmin.php';
                        </script>";
                    exit();
                }else{
                    echo "<script>
                            window.alert('No se registró correctamente la Red Social.');
                            window.location.href = '../Views/Admin/redesadmin.php';
                        </script>";
                }

                $stmt->close();
            }else{
                echo "Error en la preparacion de la declaracion" . $this->conn->error;
            }
        }

        public function updateRed($idred, $nombred,$enlace){
            $idred = $this->conn->real_escape_string($idred);
            $nombred = $this->conn->real_escape_string($nombred);
            $enlace = $this->conn->real_escape_string($enlace);

            $query = "UPDATE tbredes SET nomred = ?,enlace = ? WHERE idred = ?";

            if($stmt = $this->conn->prepare($query)){
                $stmt->bind_param("ssi", $nombred,$enlace, $idred);

                if($stmt->execute()){
                    echo "<script>
                            window.alert('Se actualizo correctamente la Red Social.');
                            window.location.href = '../Views/Admin/redesadmin.php';
                        </script>";
                }else{
                    echo "<script>
                            window.alert('No se actualizo correctamente la Red Social.');
                            window.location.href = '../Views/Admin/redesadmin.php';
                        </script>";
                }

                $stmt->close();
            }else{
                echo "Error en la actualizacion de la red" . $this->conn->error;
            }
        }

        public function eliminarRed($idred){
            $query = "DELETE FROM tbredes WHERE idred = ?";

            if($stmt = $this->conn->prepare($query)){
                $stmt->bind_param("i", $idred);

                if($stmt->execute()){
                    return true;
                }else{
                    echo "Error al eliminar la red social" . $stmt->error;
                    return false;
                }

            }else{
                echo "Error al preparar la consulta" . $this->conn->error;
                return false;
            }
        }

        //METODOS DEL PERSONAL
        public function insertarRedPersonal($data){
            $nombred = $this->conn->real_escape_string($data['nomred']);
            $enlace = $this->conn->real_escape_string($data['enlace']);
            $imagen = $this->conn->real_escape_string($data['imagen']);

            $query = "INSERT INTO tbredes(nomred,imagen,enlace) VALUES(?,?,?)";

            if($stmt = $this->conn->prepare($query)){
                $stmt->bind_param("sss",$nombred,$imagen,$enlace);

                if($stmt->execute()){
                    echo "<script>
                            window.alert('Se registró correctamente la Red Social.');
                            window.location.href = '../Views/Personal/redespersonal.php';
                        </script>";
                    exit();
                }else{
                    echo "<script>
                            window.alert('No se registró correctamente la Red Social.');
                            window.location.href = '../Views/Personal/redespersonal.php';
                        </script>";
                }

                $stmt->close();
            }else{
                echo "Error en la preparacion de la declaracion" . $this->conn->error;
            }
        }

        public function updateRedPersonal($idred, $nombred,$enlace){
            $idred = $this->conn->real_escape_string($idred);
            $nombred = $this->conn->real_escape_string($nombred);
            $enlace = $this->conn->real_escape_string($enlace);

            $query = "UPDATE tbredes SET nomred = ?,enlace = ? WHERE idred = ?";

            if($stmt = $this->conn->prepare($query)){
                $stmt->bind_param("ssi", $nombred,$enlace, $idred);

                if($stmt->execute()){
                    echo "<script>
                            window.alert('Se actualizo correctamente la Red Social.');
                            window.location.href = '../Views/Personal/redespersonal.php';
                        </script>";
                }else{
                    echo "<script>
                            window.alert('No se actualizo correctamente la Red Social.');
                            window.location.href = '../Views/Personal/redespersonal.php';
                        </script>";
                }

                $stmt->close();
            }else{
                echo "Error en la actualizacion de la red" . $this->conn->error;
            }
        }
    }
?>