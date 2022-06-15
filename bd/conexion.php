<?php 

	class Conexion {

		private $conn;

		public function __construct() {
			$conexionsql = "mysql:host=localhost;dbname=nombre_base_datos;";
			try {
				$this->conn = new PDO($conexionsql,"Usuario","Contraseña");
				$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			} catch (Exception $e) {
				$this->conn = "Error en la conexión";
				echo "Error:".$e->getMessage() ;
			}
		}

		public function conexion(){
			return $this->conn;
		}
	}

 ?>
