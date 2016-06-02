<?php
  include("conexion.php");
  session_start();
  if(isset($_GET["nom"])){
    $codigo = $_SESSION["usuario"];
    $name = $_GET["nom"];
    $query = mysqli_query($conexion, "SELECT DISTINCT a.Nombre, c.Nombre, a.NivelInt, a.Contacto, a.Rubro, a.Motivo, DATE_FORMAT(a.fechaRegistro, '%d-%m-%Y') FROM cliente a,
    usuarioCliente b, negociacion c WHERE b.CodigoUsuario = '$codigo' AND b.CodigoCliente = a.CodigoCliente AND a.CodigoNegocio = c.CodigoNegocio ORDER BY a.CodigoCliente")or die(mysqli_error());

	  if(isset($_SESSION["usuario"])){
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Ejecutivos</title>
    <link rel="stylesheet" href="css/bootstrap.min.css" media="screen" title="no title" charset="utf-8">
    <link rel="stylesheet" href="css/styles.css" media="screen" title="no title" charset="utf-8">
    <script src="js/jquery-2.2.1.min.js"></script>
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
          <div class="col-md-12 ejecutive">
            <h2>Clientes del Ejecutivo: <?php echo $name; ?></h2>
          </div>
        </div>
        <div class="row">
          <div class="col-md-9 ejecutiveContent">
            <table class="table table-hover" id="myTable">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Empresa</th>
                  <th>Negociación</th>
                  <th>Motivo</th>
                  <th>Interés</th>
                  <th>Contacto</th>
                  <th>Rubro</th>
                  <th>Fecha</th>
                </tr>
              </thead>
              <tbody>
                <?php
                    $i = 1;
                    while($row = mysqli_fetch_row($query)){
                ?>
                  <tr>
                    <td><?php echo $i++; ?></td>
                    <td><?php echo $row[0]; ?></td>
                    <td><?php echo $row[1]; ?></td>
                    <td><?php echo $row[5]; ?></td>
                    <td><?php echo $row[2]; ?></td>
                    <td><?php echo $row[3]; ?></td>
                    <td><?php echo $row[4]; ?></td>
                    <td><?php echo $row[6]; ?></td>
                  </tr>
                <?php
                    }
                ?>
              </tbody>
            </table>
          </div>
          <div class="col-md-3">
            <h3>Otros Ejecutivos:</h3>
            <ul class="moreEjecutives">
              <?php
                $query = mysqli_query($conexion, "SELECT * FROM usuario WHERE CodigoUsuario <> '$codigo' ");
                while($row = mysqli_fetch_array($query)){
                  echo "<li><a href='ejecutivos.php?cod=$row[0]&nom=$row[2]'>&raquo; $row[2]</a></li>";
                }
              ?>
            </ul>
          </div>
        </div>
      </div>
    </main>
    <script src="js/jquery-2.2.1.min.js"></script>
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
