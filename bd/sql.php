<?php 
	require_once("conexion.php");
	class Mysql extends Conexion{
		
		private $conexion;
		private $condicion;
		private $tabla;
		private $campos;
		private $valores;

		function __construct(){

			$this->conexion = new Conexion();
			$this->conexion = $this->conexion->conexion();

		}

		//INSERTAR REGISTROS
		public function insert(string $tabla, string $campos, array $valores){

			$this->tabla = $tabla;
			$this->campos = $campos;
			$this->valores = $valores;
			$data="";

			$talValores=count($this->valores);
			$arrCampos = explode(",",$this->campos);
			
			if(count($arrCampos) != $talValores){ 
				echo "imposible continuar el numero de columnas no coincide";
			}else{
				for($i=0;$i <$talValores; $i++){
				
					$data.="'".addslashes($valores[$i])."',";
				}
				
				$data = substr ($data, 0, strlen($data) - 1);
				$qry="INSERT INTO ".$this->tabla." (".$this->campos.") VALUES (".$data.")";

				$insert = $this->conexion->prepare($qry);
				$resinsert = $insert->execute($this->valores);
				
				if($resinsert){
					$lastid = $this->conexion->lastInsertId();
				}else{
					$lastid = 0;
				}
			}

			return $lastid;
			
		}

		// ACTUALIZAR REGISTROS
		public function update(string $tabla,string $campos, array $valores, string $condicion){

			$this->tabla = $tabla;
			$this->campos = $campos;
			$this->valores = $valores;
			$this->condicion = $condicion;
			$data="";

			$arrCampos = explode(",",$this->campos);
			$talValores=count($this->valores);
			
			for($i=0;$i < $talValores;$i++){
				$data.=$arrCampos[$i]." = '".addslashes($valores[$i])."', ";
			}
			
			$data = substr ($data, 0, strlen($data) - 2);
			
			$qry="UPDATE ".$this->tabla." SET ".$data ." WHERE ".$condicion;

			// echo $qry;

			$update = $this->conexion->prepare($qry);
			$resupdate = $update->execute($this->valores);

			return $resupdate;
		}
					

		// SELECCIONAR UN REGISTRO
		public function select(string $tabla, string $condicion){

			$this->tabla = $tabla;
			$this->condicion = $condicion;

			$qry = "SELECT * FROM ".$this->tabla." WHERE ".$this->condicion;
			
			$result = $this->conexion->prepare($qry);
			$result->execute();
			$data = $result->fetch(\PDO::FETCH_ASSOC);
			return $data;
		}

		// SELECCIONAR TODOS LOS REGISTROS
		public function select_all(string $tabla, string $condicion=""){

			$this->tabla = $tabla;
			$this->condicion = $condicion;
			if ($this->condicion!="") {
				$qry = "SELECT * FROM ".$this->tabla." WHERE ".$this->condicion;
			}else{
				$qry = "SELECT * FROM ".$this->tabla;	
			}

			$result = $this->conexion->prepare($qry);
			$result->execute();
			$data = $result->fetchall(PDO::FETCH_ASSOC);
			return $data;

		}

		// QUERY VARIOS REGISTROS
		public function query_all(string $query){

			$this->query = $query;
			$result = $this->conexion->prepare($query);
			$result->execute();
			$data = $result->fetchall(PDO::FETCH_ASSOC);
			return $data;

		}

		// QUERY SOLO UNO
		public function query(string $query){

			$this->query = $query;
			// echo $query;
			$result = $this->conexion->prepare($query);
			$result->execute();
			$data = $result->fetch(PDO::FETCH_ASSOC);
			return $data;

		}

		// ELIMINAR REGISTRO

		public function delete(string $tabla, string $condicion){

			$this->tabla = $tabla;
			$this->condicion = $condicion;

			$qry="DELETE FROM ".$this->tabla." WHERE ".$this->condicion;
			$result = $this->conexion->prepare($qry);
			$result->execute();
			return $result;
		}


	}

 ?>