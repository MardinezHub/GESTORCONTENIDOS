<?php
    include_once __DIR__ . '../../conexion.php';

    class multimediaModel{
        private $conn;
        private $table_name = "tbmultimedia";

        public function __construct(){
            $this->conn = conectarse();
        }

        //ADMINISTRADOR
        public function ListarMultimedia(){
            $query = "SELECT * FROM " . $this->table_name;
            $result = $this->conn->query($query);

            $multimedias = array();

            if($result->num_rows > 0){
                while($row = $result->fetch_assoc()){
                    $multimedias[] = $row;
                }
            }

            return $multimedias;
        }

        public function insertarMultimedia($data){
            $nombremultimedia = $this->conn->real_escape_string($data['nombremultimedia']);
            $enlace = $this->conn->real_escape_string($data['enlace']);

            $enlace = $enlace . "/preview";

            $query = "INSERT INTO " . $this->table_name . "
                      (nombremultimedia,enlace) VALUES(?,?)";

            if($stmt = $this->conn->prepare($query)){
                $stmt->bind_param("ss",$nombremultimedia,$enlace);

                if($stmt->execute()){
                    echo "<script>
                                window.alert('Se registró correctamente el Multimedia.');
                                window.location.href = '../Views/Admin/multimediaadmin.php';
                          </script>";
                    exit();
                }else{
                    echo "<script>
                                window.alert('No se registró correctamente el Multimedia.');
                                window.location.href = '../Views/Admin/multimediaadmin.php';
                          </script>";
                }
                $stmt->close();
            }else{
                echo "Error en la preparacion de la declaracion: " . $this->conn->error;
            }
        }

        public function updateMultimedia($idmulti,$nombremultimedia,$enlace){
            $idmulti = $this->conn->real_escape_string($idmulti);
            $nombremultimedia = $this->conn->real_escape_string($nombremultimedia);
            $enlace = $this->conn->real_escape_string($enlace);

            $enlace = $enlace . "/preview";

            $query = "UPDATE " . $this->table_name . "
                      SET nombremultimedia = ?, enlace = ?
                      WHERE idmulti = ?";
            
            if($stmt = $this->conn->prepare($query)){
                $stmt->bind_param("ssi", $nombremultimedia,$enlace,$idmulti);

                if($stmt->execute()){
                    echo "<script>
                                window.alert('Se actualizo correctamente el Multimedia.');
                                window.location.href = '../Views/Admin/multimediaadmin.php';
                          </script>";
                }else{
                    echo "<script>
                                window.alert('No se actualizo correctamente el Multimedia.');
                                window.location.href = '../Views/Admin/multimediaadmin.php';
                          </script>";
                }
            }
        }

        public function eliminarMultimedia($idmulti){
            $query = "DELETE FROM " . $this->table_name . " WHERE idmulti = ?";
            if($stmt = $this->conn->prepare($query)){
                $stmt->bind_param("i", $idmulti);
                if($stmt->execute()){
                    return true;
                }else{
                    echo "Error al eliminar el multimedia: " . $stmt->error;
                    return false;
                }
                
            }else{
                echo "Error al preparar la consulta de eliminación: " . $this->conn->error;
                return false;
            }
        }

        //PERSONAL
        public function insertarMultimediaPersonal($data){
            $nombremultimedia = $this->conn->real_escape_string($data['nombremultimedia']);
            $enlace = $this->conn->real_escape_string($data['enlace']);

            $enlace = $enlace . "/preview";

            $query = "INSERT INTO " . $this->table_name . "
                      (nombremultimedia,enlace) VALUES(?,?)";

            if($stmt = $this->conn->prepare($query)){
                $stmt->bind_param("ss",$nombremultimedia,$enlace);

                if($stmt->execute()){
                    echo "<script>
                                window.alert('Se registro correctamente el Multimedia.');
                                window.location.href = '../Views/Personal/multimediapersonal.php';
                          </script>";
                    exit();
                }else{
                    echo "<script>
                                window.alert('No se registro correctamente el Multimedia.');
                                window.location.href = '../Views/Personal/multimediapersonal.php';
                          </script>";
                }
                $stmt->close();
            }else{
                echo "Error en la preparacion de la declaracion: " . $this->conn->error;
            }
        }

        public function updateMultimediaPersonal($idmulti,$nombremultimedia,$enlace){
            $idmulti = $this->conn->real_escape_string($idmulti);
            $nombremultimedia = $this->conn->real_escape_string($nombremultimedia);
            $enlace = $this->conn->real_escape_string($enlace);

            $enlace = $enlace . "/preview";

            $query = "UPDATE " . $this->table_name . "
                      SET nombremultimedia = ?, enlace = ?
                      WHERE idmulti = ?";
            
            if($stmt = $this->conn->prepare($query)){
                $stmt->bind_param("ssi", $nombremultimedia,$enlace,$idmulti);

                if($stmt->execute()){
                    echo "<script>
                                window.alert('Se actualizo correctamente el Multimedia.');
                                window.location.href = '../Views/Personal/multimediapersonal.php';
                          </script>";
                }else{
                    echo "<script>
                                window.alert('No se actualizo correctamente el Multimedia.');
                                window.location.href = '../Views/Personal/multimediapersonal.php';
                          </script>";
                }
            }
        }

    }
?>