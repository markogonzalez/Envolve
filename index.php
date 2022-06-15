<?php 
require_once 'bd/sql.php';
?>
<!doctype html>
<html lang="es">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link href="css/style.css" rel="stylesheet">

    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>



    <title>Registro Usuarios</title>
  </head>
  <body>

    <div class="wrapper_c">
      <div class="container">
        <div class="row">
          <div class="col-md-8 centrar">
            <div class="formulario_wrapper">
              <h2>Llena los datos para poder registrarte y acceder al sistema</h2>
              <form autocomplete="nope" action="" method="POST" onsubmit="return false;" accept-charset="utf-8">
                <div class="formsix-pos">
                  <div class="form-group">
                    <input type="email" class="form-control" name="correo" id="correo" placeholder="Correo *">
                  </div>
                </div>
                <div class="formsix-e">
                  <div class="form-group">
                    <input type="password" class="form-control" name="contrasena" id="contrasena" placeholder="Contraseña *">
                  </div>
                </div>
                <div class="formsix-e">
                  <div class="form-group">
                    <select class="form-control" name="color" id="color">
                      <option value="">Selecciona un color *</option>
                      <?php
                      $mysql = new Mysql;
                      $colores = $mysql->select_all("colores");
                      foreach ($colores as $color) { ?>
                        <option value="<?=$color['id_color']?>"><?=ucfirst($color['color'])?></option>
                      <?php } ?>
                    </select>
                  </div>
                </div>
                <div class="btn_wrapper">
                  <a href="#" id="btn-registro" class="btn btn-primary accion_btn"> REGISTRARSE </a>
                </div>
              </form>
              <div class="login_message">
                <p>Si ya tienes cuenta ingresa <a href="login.php"> ingresa aquí </a> </p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

    <script type="text/javascript">
      $(function() {
        $("#btn-registro").click(function(){
          if($("#correo").val()!="" && $("#contrasena").val()!="" && $("#color").val()!=""){
            if (validarcorreo($("#correo").val())) {
              registrar();
            }else{
              alert("Ingresa un correo valido");
            }  
          }else{
            alert("Todos los campos son obligatorios");
          }
        });
      });

      function registrar(){
        $.ajax({
          url: 'registrar.php',
          type: 'POST',
          dataType: 'json',
          data: {correo: $("#correo").val(), contrasena: $("#contrasena").val(), color: $("#color").val()},
        })
        .done(function(json) {
          alert(json.mensaje);
          if (json.success) {
            window.location = "login.php";
          }
          
        })

        .fail(function() {
          alert("Ups! ocurrio un error, intente de nuevo");
        })

      }

      function validarcorreo(correo) {
        var re = /^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i;
        return re.test(correo);
      }

        
    </script>

  </body>
</html>