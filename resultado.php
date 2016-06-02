<?php
  include("conexion.php");
  session_start();

  if(isset($_GET["cli"])){
    $name = $_GET["cli"];
    $ejecutive = $_GET["ejec"];
    $negotation = $_GET["con"];
    $interes = $_GET["inte"];
    $contact = $_GET["modo"];
    $category = $_GET["rub"];
    $motive = $_GET["mot"];
    $since = $_GET["desde"];
    $until = $_GET["hasta"];


    if($since == "" && $until == ""){
      $query = mysqli_query($conexion, "SELECT d.Nombre, a.Nombre, c.Nombre, a.NivelInt, a.Contacto, a.Rubro, a.Motivo, DATE_FORMAT(a.fechaRegistro, '%d-%m-%Y') FROM cliente a,
      usuarioCliente b, negociacion c, usuario d WHERE (b.CodigoUsuario = d.CodigoUsuario AND b.CodigoCliente = a.CodigoCliente AND a.CodigoNegocio = c.CodigoNegocio)
      AND (a.Nombre LIKE '%$name%' AND c.Nombre LIKE '%$negotation%' AND d.Nombre LIKE '%$ejecutive%' AND a.NivelInt LIKE '%$interes%' AND a.Contacto LIKE '%$contact%'
      AND a.Rubro LIKE '%$category%' AND a.Motivo LIKE '%$motive%')");
    }else{
      $query = mysqli_query($conexion, "SELECT d.Nombre, a.Nombre, c.Nombre, a.NivelInt, a.Contacto, a.Rubro, a.Motivo, DATE_FORMAT(a.fechaRegistro, '%d-%m-%Y') FROM cliente a,
      usuarioCliente b, negociacion c, usuario d WHERE (b.CodigoUsuario = d.CodigoUsuario AND b.CodigoCliente = a.CodigoCliente AND a.CodigoNegocio = c.CodigoNegocio)
      AND (a.Nombre LIKE '%$name%' AND c.Nombre LIKE '%$negotation%' AND d.Nombre LIKE '%$ejecutive%' AND a.NivelInt LIKE '%$interes%' AND a.Contacto LIKE '%$contact%'
      AND a.Rubro LIKE '%$category%' AND a.Motivo LIKE '%$motive%') AND (a.fechaRegistro BETWEEN '$since' AND '$until')");
    }
    $cont = mysqli_num_rows($query);

    if(isset($_SESSION["usuario"])){
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Busqueda</title>
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
          <div class="col-md-12 resultados">
            <h2>Resultados Obtenidos: <?php echo $cont; ?></h2>
            <section class="enlacesDescarga">
              <a target="_blank" href="javascript:reportePDF();" class="fa fa-file-pdf-o" title="descargar pdf"></a>
              <a target="_blank" href="javascript:reporteExcel();" class="fa fa-file-excel-o" title="descargar pdf"></a>
            </section>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <table class="table table-hover" id="myTable">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Ejecutivo</th>
                  <th>Empresa</th>
                  <th>Negociación</th>
                  <th>Motivo</th>
                  <th>Interés</th>
                  <th>Contacto</th>
                  <th>Rubro</th>
                  <th>Fecha</th>
                </tr>
              </thead>
              <tbody id="datos">
                <?php
                  $i = 1;
                  while($row = mysqli_fetch_row($query)){
                    echo "<tr>";
                    echo "<td>$i</td>";
                    echo "<td>$row[0]</td>";
                    echo "<td>$row[1]</td>";
                    echo "<td>$row[2]</td>";
                    echo "<td>$row[6]</td>";
                    echo "<td>$row[3]</td>";
                    echo "<td>$row[4]</td>";
                    echo "<td>$row[5]</td>";
                    echo "<td>$row[7]</td>";
                    echo "</tr>";
                    $i++;
                  }
                ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </main>
    <script src="js/jquery-2.2.1.min.js"></script>
    <script type="text/javascript">
      function reportePDF(){
        var opcion = '<?php echo "1"; ?>';
        var op1 = '<?php echo $name; ?>';
        var op2 = '<?php echo $ejecutive; ?>';
        var op3 = '<?php echo $negotation; ?>';
        var op4 = '<?php echo $interes; ?>';
        var op5 = '<?php echo $contact; ?>';
        var op6 = '<?php echo $category; ?>';
        var op7 = '<?php echo $motive; ?>';
        var op8 = '<?php echo $since; ?>';
        var op9 = '<?php echo $until; ?>';
        window.open('descargaPDF.php?op='+opcion+'&op1='+op1+'&op2='+op2+'&op3='+op3+'&op4='+op4+'&op5='+op5+'&op6='+op6+'&op7='+op7+'&op8='+op8+'&op9='+op9);
      }
      function reporteExcel(){
        var opcion = '<?php echo "1"; ?>';
        var op1 = '<?php echo $name; ?>';
        var op2 = '<?php echo $ejecutive; ?>';
        var op3 = '<?php echo $negotation; ?>';
        var op4 = '<?php echo $interes; ?>';
        var op5 = '<?php echo $contact; ?>';
        var op6 = '<?php echo $category; ?>';
        var op7 = '<?php echo $motive; ?>';
        var op8 = '<?php echo $since; ?>';
        var op9 = '<?php echo $until; ?>';
        window.open('descargaExcel.php?op='+opcion+'&op1='+op1+'&op2='+op2+'&op3='+op3+'&op4='+op4+'&op5='+op5+'&op6='+op6+'&op7='+op7+'&op8='+op8+'&op9='+op9);
      }
    </script>
    <script src="js/jquery.tablesorter.min.js"></script>
    <script src="js/tablesorter.js"></script>
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
