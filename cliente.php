<?php
  include("conexion.php");
  session_start();
  if(isset($_GET["cod"])){
    $codCliente = $_GET["cod"];
    $codUsuario = $_SESSION["usuario"];
    $queryUsuario = mysqli_query($conexion, "SELECT * FROM usuario WHERE CodigoUsuario = '$codUsuario'")or die(mysqli_error());
    while($row = mysqli_fetch_assoc($queryUsuario)){
      $nombreU = $row["Nombre"];
    }
    $queryNomCliente = mysqli_query($conexion, "SELECT a.Nombre, b.Nombre, a.NivelInt, a.Contacto, a.Rubro,
    a.Motivo, a.fechaRegistro, b.CodigoNegocio FROM cliente a, negociacion b WHERE a.CodigoCliente = '$codCliente' AND
    a.CodigoNegocio = b.CodigoNegocio");
    while($row = mysqli_fetch_row($queryNomCliente)){
      $nombreCliente = $row[0];
      $negociacion = $row[1];
      $nivelInteres = $row[2];
      $contacto = $row[3];
      $rubro = $row[4];
      $motivo = $row[5];
      $fecha = $row[6];
      $codNegocio = $row[7];
    }
    $queryActi = mysqli_query($conexion, "SELECT b.Nombre, a.NivelInt, a.Contacto, a.Motivo, DATE_FORMAT(a.fechaRegistro, '%d-%m-%Y') FROM actividad a, negociacion b WHERE a.CodigoCliente = '$codCliente' AND
    b.CodigoNegocio = '$codNegocio'")or die(mysqli_error());

  	if(isset($_SESSION["usuario"])){
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Cliente</title>
    <link rel="stylesheet" href="css/bootstrap.min.css" media="screen" title="no title" charset="utf-8">
    <link rel="stylesheet" href="css/styles.css" media="screen" title="no title" charset="utf-8">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
  </head>
  <body>
    <header>
      <div class="container">
        <div class="row">
          <div class="col-md-12">
            <div class="logo">
              <h1>Blitz</h1>
            </div>
            <div class="menu-nav">
              <nav>
                <ul>
                  <li><a href="index.php">Inicio</a></li>
                  <li><a href="cerrar.php" id="logout">Cerrar Sesión</a></li>
                </ul>
              </nav>
            </div>
          </div>
        </div>
      </div>
    </header>
    <main>
      <div class="container">
        <div class="row">
          <div class="col-md-12 separar">
            <h2 class="tittle-cliente"><span class="glyphicon glyphicon-user"></span>Cliente: <?php echo $nombreCliente; ?></h2>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <div class="contenido">
              <h3>PRIMER REGISTRO REALIZADO</h3>
              <div class="contenido-cliente col-md-4 col-sm-4 col-xs-10">
                <ul>
                  <li>Registrado por: <span><?php echo $nombreU; ?></span></li>
                  <li>Negociación: <span><?php echo $negociacion; ?></span></li>
                  <li>Nivel de interés: <span><?php echo $nivelInteres; ?></span></li>
                  <li>Contacto: <span><?php echo $contacto; ?></span></li>
                  <li>Rubro: <span><?php echo $rubro; ?></span></li>
                  <li>Motivo: <span><?php echo $motivo; ?></span></li>
                  <li>Fecha de registro: <span><?php echo date("d-m-Y",strtotime($fecha)); ?></span></li>
                </ul>
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <h3>HISTORIAL DE ACTIVIDADES</h3>
            <section class="enlacesDescarga">
              <a target="_blank" href="javascript:reportePDF();" class="fa fa-file-pdf-o" title="descargar pdf"></a>
              <a target="_blank" href="javascript:reporteExcel();" class="fa fa-file-excel-o" title="descargar Excel"></a>
            </section>
            <table class="table table-hover tablesorter" id="myTable">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Negociación</th>
                  <th>Motivo</th>
                  <th>Interés</th>
                  <th>Contacto</th>
                  <th>Fecha</th>
                </tr>
              </thead>
              <?php
                $i = 1;
                while($row = mysqli_fetch_row($queryActi)){
                  echo "<tr>";
                  echo "<td>".$i++."</td>";
                  echo "<td>".$row[0]."</td>";
                  echo "<td>".$row[3]."</td>";
                  echo "<td>".$row[1]."</td>";
                  echo "<td>".$row[2]."</td>";
                  echo "<td>".$row[4]."</td>";
                  echo "</tr>";
                }
              ?>
            </table>

          </div>
        </div>
      </div>
    </main>
    <script src="js/jquery-2.2.1.min.js"></script>
    <script src="js/jquery.tablesorter.min.js"></script>
    <script src="js/tablesorter.js"></script>
    <script type="text/javascript">
      function reportePDF(){
        var opcion = '<?php echo "3"; ?>';
        var nomU = '<?php echo $nombreU; ?>';
        var nomC = '<?php echo $nombreCliente; ?>';
        var codCli = '<?php echo $codCliente; ?>';
        var codNeg = '<?php echo $codNegocio; ?>';
        var name = '<?php echo $nombreCliente; ?>';
        var neg = '<?php echo $negociacion; ?>';
        var inte = '<?php echo $nivelInteres; ?>';
        var con = '<?php echo $contacto; ?>';
        var rub = '<?php echo $rubro; ?>';
        var mot = '<?php echo $motivo; ?>';
        var fec = '<?php echo $fecha; ?>';
        window.open('descargaPDF.php?op='+opcion+'&nomU='+nomU+'&nomC='+nomC+'&codC='+codCli+'&codN='+codNeg+'&nom='+name+'&neg='+neg+'&inte='+inte+'&con='+con+'&rub='+rub+'&mot='+mot+'&fec='+fec);
      }
      function reporteExcel(){
        var opcion = '<?php echo "3"; ?>';
        var nomU = '<?php echo $nombreU; ?>';
        var nomC = '<?php echo $nombreCliente; ?>';
        var codCli = '<?php echo $codCliente; ?>';
        var codNeg = '<?php echo $codNegocio; ?>';
        var name = '<?php echo $nombreCliente; ?>';
        var neg = '<?php echo $negociacion; ?>';
        var inte = '<?php echo $nivelInteres; ?>';
        var con = '<?php echo $contacto; ?>';
        var rub = '<?php echo $rubro; ?>';
        var mot = '<?php echo $motivo; ?>';
        var fec = '<?php echo $fecha; ?>';
        window.open('descargaExcel.php?op='+opcion+'&nomU='+nomU+'&nomC='+nomC+'&codC='+codCli+'&codN='+codNeg+'&nom='+name+'&neg='+neg+'&inte='+inte+'&con='+con+'&rub='+rub+'&mot='+mot+'&fec='+fec);
      }
    </script>
  </body>
</html>
<?php
    	}else{
    		header("Location:login.php");
    	}
  }else{
    header("Location:index.php");
  }
?>
