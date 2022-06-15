<?php 
session_start();
if (isset($_SESSION['usuario']['login']) && $_SESSION['usuario']['login']=true) {
 
}else{
  header("location:./");
  exit();
}

require_once 'bd/sql.php';
$mysql = new Mysql;
?>
<!doctype html>
<html lang="es">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link href="css/style.css" rel="stylesheet">

    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.8.0/dist/chart.min.js"></script>

    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/dt-1.10.21/datatables.min.css"/>
    <script type="text/javascript" src="https://cdn.datatables.net/v/bs4/dt-1.10.21/datatables.min.js"></script>



    <title>Home</title>
  </head>
  <body>

    <div class="wrapper_c">
      <div class="container">
        <div class="row">
          <div class="col-md-8 centrar">
            <div class="formulario_wrapper">
              <h2>Información de la base de datos</h2>
              <canvas id="grafica" width="200" height="200"></canvas>

              <table id="registros" class="table" style="width:100%">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Correo</th>
                    <th>Color</th>
                  </tr>
                </thead>
                <tbody>
                  <?php 
                  $registrados =  $mysql->query_all("SELECT u.correo,c.color FROM usuarios u INNER JOIN colores c ON u.id_color = c.id_color");
                  foreach ($registrados as $registrado){ 
                    $i=1;
                    ?>
                    <tr>
                      <td><?=$i?></td>
                      <td><?=$registrado['correo']?></td>
                      <td><?=$registrado['color']?></td>
                    </tr>
                    <?php $i++; } ?>
                </tbody>
            </div>
          </div>
        </div>
      </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <?php
      
      $total_u = array();
      $total_usuarios = $mysql->query("SELECT count(*) as total FROM usuarios");
      $total_u = $total_usuarios['total'];
      $labels = $mysql->query_all("SELECT u.id_color,c.color,c.rgb FROM usuarios u INNER JOIN colores c ON u.id_color = c.id_color GROUP BY c.color ORDER BY id_color");
      $new_labels = array();
      $total=array();
      $background=array();
      $total_sql="";
      foreach ($labels as $label) {
        $new_labels[].=ucfirst($label['color']);
        $background[].=$label['rgb'];
        $total_sql=$mysql->query("SELECT count(id_color) as t_color FROM usuarios WHERE id_color =".$label['id_color']);
        $total[]=$total_sql['t_color'];
      }
      

     ?>
    <script>
      const ctx = document.getElementById('grafica').getContext('2d');
      const grafica = new Chart(ctx, {
        type: 'bar',
        data: {
          labels: <?=json_encode($new_labels)?>,
          datasets: [{
            label: '# de registros',
            data: <?=json_encode($total)?>,
            backgroundColor: <?=json_encode($background)?>,
          }]
        },
        options: {
          indexAxis: 'x',
          scales: {
            y: {
                beginAtZero: true,
                max :<?=$total_u?>,
            }
          }
        }
      });

      $(document).ready(function() {
        $('#registros').DataTable( {
          "pageLength": 5,
          "language": {
            "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"
          }
        });
      });
    </script>

  </body>
</html>