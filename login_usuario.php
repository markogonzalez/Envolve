<?php
require_once 'bd/sql.php';
$correo=limpia_cadena($_POST['correo']);
$contrasena=limpia_cadena($_POST['contrasena']);
$new_contrasena = hash("SHA256", $_POST['contrasena']);

//-------------
class datos {
 public $success;
 public $id_registrado;
 public $mensaje;
}
 
$respuesta = new datos();

    if($_POST['correo'] =="" || $_POST['contrasena'] ==""){
        $respuesta->success = false;
        $respuesta->id_registrado = 0;
        $respuesta->mensaje="Error en los datos enviados, intenta de nuevo.";
    }else{
        $mysql = new Mysql;
        $request_user = $mysql->select("usuarios","correo = '".$correo."' AND contrasena ='".$new_contrasena."'");
        
        if(!empty($request_user)){
            session_start();
            $_SESSION['usuario']['login']=true;
            $respuesta->success = true;
            $respuesta->mensaje="En un momento serás redireccionado al sistema.";
        }else{
            $respuesta->success = false;
            $respuesta->mensaje="Usuario o contraseña incorrectos.";
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