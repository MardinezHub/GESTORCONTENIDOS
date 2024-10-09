<?php
    include_once __DIR__ . '../../conexion.php';

    class personalModel {
        private $conn;
        private $table_name = "tbpersonal";

        public function __construct() {
            $this->conn = conectarse();
        }

        //METODOS ADMINISTRADOR

        public function ListarPersonal() {
            $query = "SELECT * FROM " . $this->table_name;
            $result = $this->conn->query($query);

            $personals = array();

            if($result->num_rows > 0)
            {
                while($row = $result->fetch_assoc()){
                    $personals[] = $row;
                }
            }
            
            return $personals;
        }

        public function insertarPersonal($data) {
            $nompersonal = $this->conn->real_escape_string($data['nompersonal']);
            $apepersonal = $this->conn->real_escape_string($data['apepersonal']);
            $correopersonal = $this->conn->real_escape_string($data['correopersonal']);
            $profesionpersonal = $this->conn->real_escape_string($data['profesionpersonal']);
            $cargopersonal = $this->conn->real_escape_string($data['cargopersonal']);
            $foto = $this->conn->real_escape_string($data['foto']);

            $query = "INSERT INTO " . $this->table_name . " 
                      (nompersonal, apepersonal, correopersonal, profesionpersonal, cargopersonal, foto)
                      VALUES (?, ?, ?, ?, ?, ?)";

            if($stmt = $this->conn->prepare($query)){
                $stmt->bind_param("ssssss", $nompersonal, $apepersonal, $correopersonal, $profesionpersonal, $cargopersonal, $foto);

                if($stmt->execute()){
                    echo "<script>
                            window.alert('Se registró correctamente el Integrante.');
                            window.location.href = '../Views/Admin/personaladmin.php';
                        </script>";
                    exit();
                }else{
                    echo "<script>
                            window.alert('No se registró correctamente el Integrante.');
                            window.location.href = '../Views/Admin/personaladmin.php';
                        </script>";
                }
                $stmt->close();
            }else{
                echo "Error en la preparacion de la declaracion: " . $this->conn->error; 
            }
        }

        public function updatePersonal($idintegrante, $nompersonal, $apepersonal, $correopersonal, $cargopersonal, $profesionpersonal) {
            $idintegrante = $this->conn->real_escape_string($idintegrante);
            $nompersonal = $this->conn->real_escape_string($nompersonal);
            $apepersonal = $this->conn->real_escape_string($apepersonal);
            $correopersonal = $this->conn->real_escape_string($correopersonal);
            $profesionpersonal = $this->conn->real_escape_string($profesionpersonal);
            $cargopersonal = $this->conn->real_escape_string($cargopersonal);
    
            $query = "UPDATE " . $this->table_name . " 
                     SET nompersonal = ?, apepersonal = ?, correopersonal = ?, cargopersonal = ?, profesionpersonal = ?
                     WHERE idintegrante = ?";
    
            if($stmt = $this->conn->prepare($query)){
                $stmt->bind_param("sssssi", $nompersonal, $apepersonal, $correopersonal, $cargopersonal, $profesionpersonal, $idintegrante);
    
                if($stmt->execute()){
                    echo "<script>
                            window.alert('Se actualizo correctamente el Integrante.');
                            window.location.href = '../Views/Admin/personaladmin.php';
                        </script>";
                }else{
                    echo "<script>
                            window.alert('No se actualizo correctamente el Integrante.');
                            window.location.href = '../Views/Admin/personaladmin.php';
                        </script>";
                }
    
                $stmt->close();
            }else{
                echo "Error en la actualización del Integrante: " . $this->conn->error;
            }
        }

        public function eliminarPersonal($idintegrante){
            $query = "DELETE FROM " . $this->table_name . " WHERE idintegrante = ?";
            if($stmt = $this->conn->prepare($query)){
                $stmt->bind_param("i", $idintegrante);
                if($stmt->execute()){
                    return true;
                } else{
                    echo "Error al eliminar al integrante: " . $stmt->error;
                    return false;
                }
                
            } else {
                echo "Error al preparar la consulta de eliminación: " . $this->conn->error;
                return false;
            }
        }

        //METODOS PERSONAL
        public function insertarPersonal2($data) {
            $nompersonal = $this->conn->real_escape_string($data['nompersonal']);
            $apepersonal = $this->conn->real_escape_string($data['apepersonal']);
            $correopersonal = $this->conn->real_escape_string($data['correopersonal']);
            $profesionpersonal = $this->conn->real_escape_string($data['profesionpersonal']);
            $cargopersonal = $this->conn->real_escape_string($data['cargopersonal']);
            $foto = $this->conn->real_escape_string($data['foto']);

            $query = "INSERT INTO " . $this->table_name . " 
                      (nompersonal, apepersonal, correopersonal, profesionpersonal, cargopersonal, foto)
                      VALUES (?, ?, ?, ?, ?, ?)";

            if($stmt = $this->conn->prepare($query)){
                $stmt->bind_param("ssssss", $nompersonal, $apepersonal, $correopersonal, $profesionpersonal, $cargopersonal, $foto);

                if($stmt->execute()){
                    echo "<script>
                            window.alert('Se registró correctamente el Integrante.');
                            window.location.href = '../Views/Personal/personalusuario.php';
                        </script>";
                    exit();
                }else{
                    echo "<script>
                            window.alert('No se registró correctamente el Integrante.');
                            window.location.href = '../Views/Personal/personalusuario.php';
                        </script>";
                }
                $stmt->close();
            }else{
                echo "Error en la preparacion de la declaracion: " . $this->conn->error; 
            }
        }

        public function updatePersonal2($idintegrante, $nompersonal, $apepersonal, $correopersonal, $cargopersonal, $profesionpersonal) {
            $idintegrante = $this->conn->real_escape_string($idintegrante);
            $nompersonal = $this->conn->real_escape_string($nompersonal);
            $apepersonal = $this->conn->real_escape_string($apepersonal);
            $correopersonal = $this->conn->real_escape_string($correopersonal);
            $profesionpersonal = $this->conn->real_escape_string($profesionpersonal);
            $cargopersonal = $this->conn->real_escape_string($cargopersonal);
    
            $query = "UPDATE " . $this->table_name . " 
                     SET nompersonal = ?, apepersonal = ?, correopersonal = ?, cargopersonal = ?, profesionpersonal = ?
                     WHERE idintegrante = ?";
    
            if($stmt = $this->conn->prepare($query)){
                $stmt->bind_param("sssssi", $nompersonal, $apepersonal, $correopersonal, $cargopersonal, $profesionpersonal, $idintegrante);
    
                if($stmt->execute()){
                    echo "<script>
                            window.alert('Se actualizo correctamente el Integrante.');
                            window.location.href = '../Views/Personal/personalusuario.php';
                        </script>";
                }else{
                    echo "<script>
                            window.alert('No se actualizo correctamente el Integrante.');
                            window.location.href = '../Views/Personal/personalusuario.php';
                        </script>";
                }
    
                $stmt->close();
            }else{
                echo "Error en la actualización del Integrante: " . $this->conn->error;
            }
        }

    }
?>
