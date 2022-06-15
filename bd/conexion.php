<?php 

	class Conexion {

		private $conn;

		public function __construct() {
			$conexionsql = "mysql:host=localhost;dbname=u844642392_mg;";
			try {
				$this->conn = new PDO($conexionsql,"u844642392_mg","Markogonzalez15");
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