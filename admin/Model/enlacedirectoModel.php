<?php
    include_once __DIR__ . '../../conexion.php';

    class enlacedirectoModel{
        private $conn;
        private $table_name = "tbenlacedirecto";

        public function __construct()
        {
            $this->conn = conectarse();
        }

        //ADMINISTRADOR
        public function ListarEnlace(){
            $query = "SELECT * FROM " . $this->table_name;
            $result = $this->conn->query($query);

            $enlaces = array();

            if($result->num_rows > 0){
                while($row = $result->fetch_assoc()){
                    $enlaces[] = $row;
                }
            }

            return $enlaces;
        }

        public function insertarEnlace($data){
            $nomenlace = $this->conn->real_escape_string($data['nomenlace']);
            $enlace = $this->conn->real_escape_string($data['enlace']);
            $foto = $this->conn->real_escape_string($data['foto']);

            $query = "INSERT INTO " . $this->table_name . "
                      (idenlace,nomenlace,enlace,foto) VALUES(?,?,?,?)";

            if($stmt = $this->conn->prepare($query)){
                $stmt->bind_param("ssss", $idenlace,$nomenlace,$enlace,$foto);

                if($stmt->execute()){              
                    echo "<script>
                                window.alert('Se registró correctamente el Enlace Directo.');
                                window.location.href = '../Views/Admin/enlacesadmin.php';
                          </script>";      
                    exit();
                }else{
                    echo "<script>
                                window.alert('No se registró correctamente el Enlace Directo.');
                                window.location.href = '../Views/Admin/enlacesadmin.php';
                          </script>"; 
                }

                $stmt->close();
            }else{
                echo "Error en la prepacion de la consulta" . $this->conn->error;
            }
        }

        public function updateEnlace($idenlace,$nomenlace,$enlace){
            $idenlace = $this->conn->real_escape_string($idenlace);
            $nomenlace = $this->conn->real_escape_string($nomenlace);
            $enlace = $this->conn->real_escape_string($enlace);

            $query = "UPDATE " . $this->table_name . "
                      SET nomenlace = ?, enlace = ?
                      WHERE idenlace = ?";

            if($stmt = $this->conn->prepare($query)){
                $stmt->bind_param("ssi", $nomenlace,$enlace,$idenlace);

                if($stmt->execute()){
                    echo "<script>
                                window.alert('Se actualizo correctamente el Enlace Directo.');
                                window.location.href = '../Views/Admin/enlacesadmin.php';
                          </script>"; 
                }else{
                    echo "<script>
                                window.alert('No se actualizo correctamente el Enlace Directo.');
                                window.location.href = '../Views/Admin/enlacesadmin.php';
                          </script>"; 
                }

                $stmt->close();
            }else{
                echo "Error en la preparcion de la consulta" . $this->conn->error;
            }
        }

        public function eliminarEnlace($idenlace){
            $query = "DELETE FROM " . $this->table_name . " WHERE idenlace = ?";

            if($stmt = $this->conn->prepare($query)){
                $stmt->bind_param("i", $idenlace);

                if($stmt->execute()){
                    return true;
                }else{
                    echo "Error al eliminar el enlace directo" . $stmt->error;
                    return false;
                }                
            }else{
                echo "Error en la preparacion de la consulta" . $this->conn->error;
            }
        }

        //PERSONAL
        public function insertarEnlacePersonal($data){
            $nomenlace = $this->conn->real_escape_string($data['nomenlace']);
            $enlace = $this->conn->real_escape_string($data['enlace']);
            $foto = $this->conn->real_escape_string($data['foto']);

            $query = "INSERT INTO " . $this->table_name . "
                      (idenlace,nomenlace,enlace,foto) VALUES(?,?,?,?)";

            if($stmt = $this->conn->prepare($query)){
                $stmt->bind_param("ssss", $idenlace,$nomenlace,$enlace,$foto);

                if($stmt->execute()){
                    echo "<script>
                                window.alert('Se registro correctamente el Enlace Directo.');
                                window.location.href = '../Views/Personal/enlacespersonal.php';
                          </script>"; 
                    exit();
                }else{
                    echo "<script>
                                window.alert('No se registro correctamente el Enlace Directo.');
                                window.location.href = '../Views/Personal/enlacespersonal.php';
                          </script>";
                }

                $stmt->close();
            }else{
                echo "Error en la prepacion de la consulta" . $this->conn->error;
            }
        }

        public function updateEnlacePersonal($idenlace,$nomenlace,$enlace){
            $idenlace = $this->conn->real_escape_string($idenlace);
            $nomenlace = $this->conn->real_escape_string($nomenlace);
            $enlace = $this->conn->real_escape_string($enlace);

            $query = "UPDATE " . $this->table_name . "
                      SET nomenlace = ?, enlace = ?
                      WHERE idenlace = ?";

            if($stmt = $this->conn->prepare($query)){
                $stmt->bind_param("ssi", $nomenlace,$enlace,$idenlace);

                if($stmt->execute()){
                    echo "<script>
                                window.alert('Se actualizo correctamente el Enlace Directo.');
                                window.location.href = '../Views/Personal/enlacespersonal.php';
                          </script>";
                }else{
                    echo "<script>
                                window.alert('No se actualizo correctamente el Enlace Directo.');
                                window.location.href = '../Views/Personal/enlacespersonal.php';
                          </script>";
                }

                $stmt->close();
            }else{
                echo "Error en la preparcion de la consulta" . $this->conn->error;
            }
        }

    }

?>