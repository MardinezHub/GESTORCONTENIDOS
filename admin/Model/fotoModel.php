<?php 
    include_once __DIR__ . '../../conexion.php';

    class fotoModel{
        private $conn;

        public function __construct()
        {   
            $this->conn = conectarse();
        }

        //ADMINISTRADOR
        public function listarfotos(){
            $query = "SELECT tbfoto.idfoto,tbfoto.foto,tbfoto.fk_idpagina,tbfoto.fk_idsubpagina,
                      tbpagina.idpagina,tbpagina.nombrepagina,tbsubpagina.idsubpagina,tbsubpagina.nombresub
                      FROM tbfoto
                      LEFT JOIN tbpagina
                      ON tbpagina.idpagina = tbfoto.fk_idpagina
                      LEFT JOIN tbsubpagina
                      ON tbsubpagina.idsubpagina = tbfoto.fk_idsubpagina";

            $result = $this->conn->query($query);

            $fotos = array();

            if($result->num_rows > 0){
                while($row = $result->fetch_assoc()){
                    $fotos[] = $row;
                }
            }

            return $fotos;
        }

        public function insertarfoto($data){
            $foto = $this->conn->real_escape_string($data['foto']);
            $fk_idpagina = $this->conn->real_escape_string($data['fk_idpagina']);
            $fk_idsubpagina = $this->conn->real_escape_string($data['fk_idsubpagina']);

            $query = "INSERT INTO tbfoto(foto,fk_idpagina,fk_idsubpagina) VALUES(?,?,?)";

            if($stmt = $this->conn->prepare($query)){
                $stmt->bind_param("sss",$foto,$fk_idpagina,$fk_idsubpagina);

                if($stmt->execute()){
                    echo "<script>
                                window.alert('Se registró correctamente la foto para la Pagina o SubPagina.');
                                window.location.href = '../Views/Admin/fotoadmin.php';
                          </script>"; 
                    exit();
                }else{
                    echo "<script>
                                window.alert('No se registró correctamente la foto para la Pagina o SubPagina.');
                                window.location.href = '../Views/Admin/fotoadmin.php';
                          </script>"; 
                }
                $stmt->close();
            }else{
                echo "Error en la preparacion de la declaracion" . $this->conn->error;
            }
        }

        public function updatefoto($idfoto,$fk_idpagina,$fk_idsubpagina){
            $idfoto = $this->conn->real_escape_string($idfoto);
            $fk_idpagina = $this->conn->real_escape_string($fk_idpagina);
            $fk_idsubpagina = $this->conn->real_escape_string($fk_idsubpagina);

            $query = "UPDATE tbfoto SET fk_idpagina = ?, fk_idsubpagina = ? WHERE idfoto = ?";

            if($stmt = $this->conn->prepare($query)){
                $stmt->bind_param("ssi", $fk_idpagina, $fk_idsubpagina, $idfoto);

                if($stmt->execute()){
                    echo "<script>
                                window.alert('Se actualizo correctamente la informacion de la foto de la Pagina o SubPagina.');
                                window.location.href = '../Views/Admin/fotoadmin.php';
                          </script>"; 
                }else{
                    echo "<script>
                                window.alert('No se actualizo correctamente la informacion de la foto de la Pagina o SubPagina.');
                                window.location.href = '../Views/Admin/fotoadmin.php';
                          </script>"; 
                }

                $stmt->close();
            }else{
                echo "Error en la actualizacion de la lista" . $this->conn->error;
            }
        }

        public function eliminarfoto($idfoto){
            $query = "DELETE FROM tbfoto WHERE idfoto = ?";

            if($stmt = $this->conn->prepare($query)){
                $stmt->bind_param("i",$idfoto);

                if($stmt->execute()){
                    return true;
                }else{
                    echo "Error al eliminar la foto" . $stmt->error;
                    return false;
                }
                
            }else{
                echo "Error al preparar la consulta de eliminacion" . $this->conn->error;
                return false;
            }
        }

        //PERSONAL
        public function insertarfotoPersonal($data){
            $foto = $this->conn->real_escape_string($data['foto']);
            $fk_idpagina = $this->conn->real_escape_string($data['fk_idpagina']);
            $fk_idsubpagina = $this->conn->real_escape_string($data['fk_idsubpagina']);

            $query = "INSERT INTO tbfoto(foto,fk_idpagina,fk_idsubpagina) VALUES(?,?,?)";

            if($stmt = $this->conn->prepare($query)){
                $stmt->bind_param("sss",$foto,$fk_idpagina,$fk_idsubpagina);

                if($stmt->execute()){
                    echo "<script>
                                window.alert('Se registró correctamente la foto de la Pagina o SubPagina.');
                                window.location.href = '../Views/Personal/fotopersonal.php';
                          </script>"; 
                    exit();
                }else{
                    echo "<script>
                                window.alert('No se registró correctamente la foto de la Pagina o SubPagina.');
                                window.location.href = '../Views/Personal/fotopersonal.php';
                          </script>"; 
                }
                $stmt->close();
            }else{
                echo "Error en la preparacion de la declaracion" . $this->conn->error;
            }
        }

        public function updatefotoPersonal($idfoto,$fk_idpagina,$fk_idsubpagina){
            $idfoto = $this->conn->real_escape_string($idfoto);
            $fk_idpagina = $this->conn->real_escape_string($fk_idpagina);
            $fk_idsubpagina = $this->conn->real_escape_string($fk_idsubpagina);

            $query = "UPDATE tbfoto SET fk_idpagina = ?, fk_idsubpagina = ? WHERE idfoto = ?";

            if($stmt = $this->conn->prepare($query)){
                $stmt->bind_param("ssi", $fk_idpagina, $fk_idsubpagina, $idfoto);

                if($stmt->execute()){
                    echo "<script>
                                window.alert('Se actualizo correctamente la informacion de la foto de la Pagina o SubPagina.');
                                window.location.href = '../Views/Personal/fotopersonal.php';
                          </script>"; 
                }else{
                    echo "<script>
                                window.alert('No se actualizo correctamente la informacion de la foto de la Pagina o SubPagina.');
                                window.location.href = '../Views/Personal/fotopersonal.php';
                          </script>"; 
                }

                $stmt->close();
            }else{
                echo "Error en la actualizacion de la lista" . $this->conn->error;
            }
        }
    }
?>