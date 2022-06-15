<?php
require_once 'bd/sql.php';
$correo=limpia_cadena($_POST['correo']);
$contrasena=limpia_cadena($_POST['contrasena']);
$color=limpia_cadena($_POST['color']);
$new_contrasena = hash("SHA256", $_POST['contrasena']);

date_default_timezone_set('America/Mexico_City');
$fecha_registro= date("Y-m-d H:i:s");
//-------------
class datos {
 public $success;
 public $id_registrado;
 public $mensaje;
}
 
$respuesta = new datos();

    if($_POST['correo'] =="" || $_POST['contrasena'] =="" || $_POST['color']==""){
        $respuesta->success = false;
        $respuesta->id_registrado = 0;
        $respuesta->mensaje="Error en los datos enviados, intenta de nuevo.";
    }else{

        $campos="correo,contrasena,id_color,fecha_registro";
        $valores= array(
            $correo,
            $new_contrasena, 
            $color,
            $fecha_registro
        );
        $mysql = new Mysql;
        
        $registrados  = $mysql->select_all("usuarios","correo='".$correo."'");
        foreach ($registrados as &$registrado) {}

        if (empty($registrado)) {
            if ($mysql->insert("usuarios",$campos,$valores)) {
                $respuesta->success = true;
                $respuesta->mensaje="Tu registro se realizo exitosamente, ahora puedes iniciar sesión con tus datos registrados.";
            }else{
                $respuesta->success = false;
                $respuesta->mensaje="Error al registrarse, intente nuevamente.";
            }
        }else{
            $respuesta->success = false;
            $respuesta->mensaje="El correo ya se encuentra previamente registrado.";
        }
    }


    function limpia_cadena(string $cadena){
        if($cadena != ''){
            $basura = array('?', '[', ']', '/', "\\", '=', '<', '>', ':', ';', "'", '\'', '&', '´', '$', '#', '*', '|', '~', '`', '!', '{', '}', '%', '+', '"', chr(0));
            $salida = str_replace($basura, "", $cadena);
            return $salida;
        }
    }

echo json_encode($respuesta);
?>