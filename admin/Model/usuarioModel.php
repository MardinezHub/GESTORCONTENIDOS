<?php
    include_once __DIR__ . '../../conexion.php';

    class usuarioModel {
        private $conn;
        private $table_name = "tbusuario";

        public function __construct() {
            $this->conn = conectarse();
        }

        public function listarUsuario() {
            $query = "SELECT tbusuario.dniusuario, tbusuario.nomusuario, tbusuario.apusuario, tbusuario.correousuario, tbusuario.direccion, tbusuario.telefono, tbusuario.fk_idrol,tbrol.idrol,tbrol.nomrol, tbusuario.estado
                FROM " . $this->table_name . "
                INNER JOIN tbrol ON tbusuario.fk_idrol = tbrol.idrol";
            
            $result = $this->conn->query($query);

            $usuarios = array();

            if($result->num_rows > 0)
            {
                while($row = $result->fetch_assoc())
                {
                    $usuarios[] = $row;
                }
            }
            return $usuarios;
        }

        public function updateUsuario($dniusuario,$nomusuario,$apusuario,$correousuario,$telefono,$direccion,$estado) {
            $dniusuario = $this->conn->real_escape_string($dniusuario);
            $nomusuario = $this->conn->real_escape_string($nomusuario);
            $apusuario = $this->conn->real_escape_string($apusuario);
            $correousuario = $this->conn->real_escape_string($correousuario);
            $telefono = $this->conn->real_escape_string($telefono);
            $direccion = $this->conn->real_escape_string($direccion);
            $estado = $this->conn->real_escape_string($estado);

            $query = "UPDATE " . $this->table_name . "
                      SET nomusuario = ?, apusuario = ?, correousuario = ?, telefono = ?, direccion = ?,estado = ?
                      WHERE dniusuario = ?";

            if($stmt = $this->conn->prepare($query))
            {
                $stmt->bind_param("ssssssi", $nomusuario, $apusuario, $correousuario, $telefono, $direccion, $estado, $dniusuario);


                if($stmt->execute())
                {
                    echo "<script>
                            window.alert('Se actualizo correctamente la informacion del Usuario.');
                            window.location.href = '../Views/Admin/usuariosadmin.php';
                        </script>";
                }else{
                    echo "<script>
                            window.alert('No se actualizo correctamente la informacion del Usuario.');
                            window.location.href = '../Views/Admin/usuariosadmin.php';
                        </script>";
                }

                $stmt->close();
            }
            else
            {
                echo "Error en la actualización del usuario: " . $this->conn->error;
            }
        }

        public function modificarPerfilAdmin($dniusuario,$nomusuario,$apusuario,$correousuario,$telefono,$direccion) {
            $dniusuario = $this->conn->real_escape_string($dniusuario);
            $nomusuario = $this->conn->real_escape_string($nomusuario);
            $apusuario = $this->conn->real_escape_string($apusuario);
            $correousuario = $this->conn->real_escape_string($correousuario);
            $telefono = $this->conn->real_escape_string($telefono);
            $direccion = $this->conn->real_escape_string($direccion);

            $query = "UPDATE " . $this->table_name . "
                      SET nomusuario = ?, apusuario = ?, correousuario = ?, telefono = ?, direccion = ?
                      WHERE dniusuario = ?";

            if($stmt = $this->conn->prepare($query))
            {
                $stmt->bind_param("sssssi", $nomusuario, $apusuario, $correousuario, $telefono, $direccion, $dniusuario);


                if($stmt->execute())
                {
                    echo "<script>
                            window.alert('Se actualizo correctamente su informacion Administrador.');
                            window.location.href = '../Views/Admin/indexadmin.php';
                        </script>";
                }else{
                    echo "<script>
                            window.alert('No se actualizo correctamente su informacion Administrador.');
                            window.location.href = '../Views/Admin/indexadmin.php';
                        </script>";
                }

                $stmt->close();
            }
            else
            {
                echo "Error en la actualización del perfil: " . $this->conn->error;
            }
        }

        public function modificarPerfilUsuario($dniusuario,$nomusuario,$apusuario,$correousuario,$telefono,$direccion) {
            $dniusuario = $this->conn->real_escape_string($dniusuario);
            $nomusuario = $this->conn->real_escape_string($nomusuario);
            $apusuario = $this->conn->real_escape_string($apusuario);
            $correousuario = $this->conn->real_escape_string($correousuario);
            $telefono = $this->conn->real_escape_string($telefono);
            $direccion = $this->conn->real_escape_string($direccion);

            $query = "UPDATE " . $this->table_name . "
                      SET nomusuario = ?, apusuario = ?, correousuario = ?, telefono = ?, direccion = ?
                      WHERE dniusuario = ?";

            if($stmt = $this->conn->prepare($query))
            {
                $stmt->bind_param("sssssi", $nomusuario, $apusuario, $correousuario, $telefono, $direccion, $dniusuario);


                if($stmt->execute())
                {
                    echo "<script>
                            window.alert('Se actualizo correctamente su informacion Personal.');
                            window.location.href = '../Views/Personal/indexpersonal.php';
                        </script>";                    
                }else{
                    echo "<script>
                            window.alert('No se actualizo correctamente su informacion Personal.');
                            window.location.href = '../Views/Personal/indexpersonal.php';
                        </script>";
                }

                $stmt->close();
            }
            else
            {
                echo "Error en la actualización del perfil: " . $this->conn->error;
            }
        }

        //MODIFICAR HEADER INICIO
        public function headerlista() {
            $sql = "SELECT * FROM tbheader WHERE idheader = 1";
            $result = $this->conn->query($sql);
    
            if ($result->num_rows > 0) {
                return $result->fetch_assoc();
            } else {
                return null;
            }
        }

        public function headerinicio($correo, $telefono, $color){
            $correo = $this->conn->real_escape_string($correo);
            $telefono = $this->conn->real_escape_string($telefono);
            $color = $this->conn->real_escape_string($color);

            $query = "UPDATE tbheader SET correo = ?, telefono = ?, color = ? WHERE idheader = 1";

            if($stmt = $this->conn->prepare($query)){
                
                $stmt->bind_param("sis", $correo, $telefono, $color);

                if($stmt->execute()){
                    echo "<script>
                            window.alert('Se actualizo correctamente la informacion de contacto,color,correo.');
                            window.location.href = '../Views/Admin/indexadmin.php';
                        </script>";

                }else{
                    echo "<script>
                            window.alert('No se actualizo correctamente la informacion de contacto,color,correo.');
                            window.location.href = '../Views/Admin/indexadmin.php';
                        </script>";
                }

                $stmt->close();
            }else{
                echo "Error en la actualizacion del header" . $this->conn->error;
            }
        }
    }
?>