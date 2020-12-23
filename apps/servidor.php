<?php
	$verbo = $_SERVER["REQUEST_METHOD"];
	$token = "4512348";
	

	switch ($verbo) {
		case 'GET':
			if(!empty($_GET["hash"])){
				$hash = $_GET["hash"];
				if($hash == $token){

					$estudiantes = traerDatos();
					$fila = array(2);
					$contador = 0;
					foreach ($estudiantes as $estudiante) {
						$fila[$contador] = array(
							"codigo" => $estudiante["codigo"],
							"nombres" => $estudiante["nombres"],
							"apellidos" => $estudiante["apellidos"],
							"PA"=>$estudiante["id_pa"]
						);
						$contador++;
					}

			
					echo json_encode($fila);
				}
				else{
					echo json_encode(array("datos"=>"hash incorrecto"));
				}
			}
			else{
				echo json_encode(array("datos"=>"Incluya el campo hash"));
			}
			
			break;

		case 'POST':
			$codigo = $_POST["codigo"];
			$nombres = $_POST["nombres"];
			$apellidos = $_POST["apellidos"];
			$pa = $_POST["pa"];
			if (!guardarDatos($codigo, $nombres,$apellidos,$pa)) {
				echo "error";
			}else{
				echo "ok";
			}
			break;
		
		default:
			echo "imprimir otra cosa";
			break;
	}	

function guardarDatos($codigo, $nombres, $apellidos, $pa){
	$usuariodb = "root";
	$passdb ="";
	$nombredb = "universidad";
	try{
	$conn = new PDO("mysql:host=localhost;dbname=".$nombredb, $usuariodb, $passdb);
		$sql = "INSERT INTO estudiantes(codigo, nombres, apellidos, telefono, correo, id_pa) VALUES($codigo, '$nombres', '$apellidos', '11112222', 'algo@gmail.com', $pa)";
		return $conn->exec($sql);
	}
	catch(PDOException $e){
		echo $e->getMessage();
	}
}


function traerDatos(){
	$usuariodb = "root";
	$passdb ="";
	$nombredb = "universidad";
	$datos = null;
	try{
	$conn = new PDO("mysql:host=localhost;dbname=".$nombredb, $usuariodb, $passdb);
		$sql = "SELECT * FROM estudiantes";
		$datos = $conn->query($sql);
	}
	catch(PDOException $e){
		echo $e->getMessage();
	}
	return $datos;
}
?>






