<?php
    include_once '../conexion.php';

    class registroModel {
        private $conn;
        private $table_name = "tbusuario";

        public function __construct() {
            $this->conn = conectarse();
        }

        public function insertUser($data) {
            $dniusuario = $data['dniusuario'];
            $nombreusuario = $data['nombreusuario'];
            $apellidousuario = $data['apellidousuario'];
            $correousuario = $data['correousuario'];
            $contrasenia = $data['contrasenia'];
            $telefono = $data['telefono'];
            $direccion = $data['direccion'];

            if ($this->userExists($dniusuario)) {
                return json_encode(["success" => false, "message" => "Usuario ya existe con el DNI proporcionado"]);
            }

            $query = "INSERT INTO tbusuario (dniusuario, nomusuario, apusuario, correousuario, contrasenia, telefono, direccion, fk_idrol, estado) VALUES (?, ?, ?, ?, ?,? , ?, 2,1)";

            $stmt = $this->conn->prepare($query);
            $stmt->bind_param("sssssss", $dniusuario, $nombreusuario, $apellidousuario, $correousuario, $contrasenia,$telefono,$direccion);

            if ($stmt->execute()) {
                return true;
            } else {
                return json_encode(["success" => false, "message" => "Error: " . $this->conn->error]);
            }
        }

        private function userExists($dni) {
            $query = "SELECT dniusuario FROM " . $this->table_name . " WHERE dniusuario = ?";
            $stmt = $this->conn->prepare($query);
            $stmt->bind_param("s", $dni);
            $stmt->execute();
            $stmt->store_result();
            return $stmt->num_rows > 0;
        }
    }
?>

