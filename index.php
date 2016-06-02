<?php
  include("conexion.php");
  session_start();

  $codigo = $_SESSION["usuario"];

  $queryUsuario = mysqli_query($conexion, "SELECT * FROM usuario WHERE CodigoUsuario = '$codigo'")or die(mysqli_error());
  $queryClientes = mysqli_query($conexion, "SELECT DISTINCT a.CodigoCliente, a.Nombre, a.NivelInt, a.Contacto, a.Rubro, a.Motivo, DATE_FORMAT(a.fechaRegistro, '%d-%m-%Y'), c.Nombre FROM cliente a,
  usuarioCliente b, negociacion c WHERE b.CodigoUsuario = '$codigo' AND b.CodigoCliente = a.CodigoCliente AND a.CodigoNegocio = c.CodigoNegocio ORDER BY a.CodigoCliente")or die(mysqli_error());
  while($row = mysqli_fetch_assoc($queryUsuario)){
    $nombre = $row["Nombre"];
  }
  $queryCodCli = mysqli_query($conexion, "SELECT * FROM cliente")or die(mysqli_error());
  while($row = mysqli_fetch_row($queryCodCli)){$lastCode = $row[0];}
  $queryActividad = mysqli_query($conexion, "SELECT * FROM actividad")or die(mysqli_error());
  while($row = mysqli_fetch_assoc($queryActividad)){$ultimoCod = $row["CodigoActividad"];}

  if(isset($_SESSION["usuario"])){
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Inicio</title>
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
            <div class="presentacion">
              <div class="ejecNombre">
                <p>Bienvenido: <span><?php echo $nombre; ?></span></p>
                <p><a href="cerrar.php" id="logout">Cerrar Sesión</a></p>
              </div>
              <div class="ejecImage">
                <figure>
                  <img src="img/admin.png" alt="ejecutivo" />
                </figure>
              </div>
            </div>
          </div>
        </div>
      </div>
    </header>
    <main>
      <div class="container">
        <div class="row">
          <div class="col-md-9">
            <section id="clientes">
              <h2 class="tittle"><span class="glyphicon glyphicon-user"></span> Clientes:</h2>
              <table class="table table-hover tablesorter" id="myTable">
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
                    <th>Ver</th>
                  </tr>
                </thead>
                <tbody class="content" id="content">
                  <?php
                    $i = 1;
                    while($row = mysqli_fetch_row($queryClientes)){
                  ?>
                    <tr>
                      <td><?php echo $i++; ?></td>
                      <td><?php echo $row[1]; ?></td>
                      <td><?php echo $row[7]; ?></td>
                      <td><?php echo $row[5]; ?></td>
                      <td><?php echo $row[2]; ?></td>
                      <td><?php echo $row[3]; ?></td>
                      <td><?php echo $row[4]; ?></td>
                      <td><?php echo $row[6]; ?></td>
                      <td>
                        <?php echo "<a href='cliente.php?cod=$row[0]'>" ?>
                        <?php
                          $queryColor = mysqli_query($conexion, "SELECT * FROM actividad WHERE CodigoCliente = '$row[0]'");
                          if(mysqli_fetch_array($queryColor)>0){
                            echo "<b style='color:green;'>ver</b>";
                          }else{
                            echo "<b style='color:gray;'>ver</b>";
                          }
                        ?>
                        </a>
                      </td>
                    </tr>
                  <?php
                    }
                  ?>
                </tbody>
                <tfoot class="page_navigation"></tfoot>
              </table>
            </section>
          </div>
          <div class="col-md-3">
            <section id="opcionesAyuda">
              <h2 class="tittle"><span class="fa fa-bookmark"></span> Acceso Rápido</h2>
              <div class="enlacesDescarga">
                <a target="_blank" href="javascript:reportePDF();" title="descargar pdf">
                  <span class="fa fa-file-pdf-o"></span>
                  <span> Exportar a PDF</span>
                </a>
                <a target="_blank" href="javascript:reporteExcel();" title="descargar Excel">
                  <span class="fa fa-file-excel-o"></span>
                  <span> Exportar a Excel</span>
                </a>
              </div>
              <div class="newCliente">
                <a id="newCliente" href="#">Agregar Cliente / Actividad</a>
              </div>
              <div class="buscarTodo">
                <a id="buscar"  href="#">Buscar</a>
              </div>
            </section>
            <section id="ejecutivos">
              <h2 class="tittle"><span class="fa fa-users"></span> Ejecutivos</h2>
              <div class="ejecutivos">
                <ul>
                  <?php
                    $i = 1;
                    $todosUsuarios = mysqli_query($conexion, "SELECT * FROM usuario WHERE CodigoUsuario <> '$codigo'");
                    while($row = mysqli_fetch_array($todosUsuarios)){
                      echo "<li>".$i++.". "."<a href='ejecutivos.php?nom=$row[2]'>$row[2]</a></li>";
                    }
                  ?>
                </ul>
              </div>
            </section>
          </div>

          <!-- FORMULARIO DE REGISTRAR CLIENTE -->

          <div class="register">
            <div class="elegir">
              <div class="form-group">
                <input type="radio" name="radio1" class="activar"  data-id="cliente" id="cliente">
                <label for="cliente">Cliente</label>
              </div>
              <div class="form-group">
                <input type="radio" name="radio1" class="activar" data-id="actividad" id=actividad>
                <label for="actividad">Actividad</label>
              </div>
            </div>
            <div class="register-cliente">
              <h2>Registrar Nuevo Cliente</h2>
              <form action="addClienteValidator.php" method="post">
                <input type="hidden" name="codUser" value="<?php echo $codigo; ?>">
                <input type="hidden" name="lastCode" value="<?php echo $lastCode; ?>">
                <div class="form-group">
                  <label for="nombre">Nombre de la empresa</label>
                  <input type="text" name="nombre" id="nombre" class="form-control" placeholder="Ejemplo: Juan Ramon Riveyro" required>
                </div>
                <div class="form-group">
                  <label for="concepto">Concepto de negociación</label>
                  <select class="form-control" name="concepto" id="concepto" required>
                    <?php
                      $query = mysqli_query($conexion, "SELECT * from negociacion");
                      while($row = mysqli_fetch_assoc($query)){
                        echo "<option value='".$row["CodigoNegocio"]."'>".$row["Nombre"]."</option>";
                      }
                    ?>
                  </select>
                </div>
                <div class="form-group">
                  <label for="motivo">Motivo</label>
                  <select class="form-control" name="motivo" id="motivo" required>
                    <option value="Comercial">Comercial</option>
                    <option value="Prensa">Prensa</option>
                    <option value="Prensa y Comercial">Prensa y Comercial</option>
                  </select>
                </div>
                <div class="form-group">
                  <label for="interes">Nivel de interés</label>
                  <select class="form-control" name="interes" id="interes" required>
                    <option value="Muy Interesado">Muy Interesado</option>
                    <option value="Regular">Regular</option>
                    <option value="No quiere">No quiere</option>
                  </select>
                </div>
                <div class="form-group">
                  <label for="contacto">Modo de contacto</label>
                  <select class="form-control" name="contacto" id="contacto" required>
                    <option value="Fono Fijo">Fono Fijo</option>
                    <option value="Celular">Celular</option>
                    <option value="Whatsapp">Whatsapp</option>
                    <option value="Correo">Correo</option>
                    <option value="Personal">Personal</option>
                    <option value="Redes Sociales">Redes Sociales</option>
                  </select>
                </div>
                <div class="form-group">
                  <label for="rubro">Rubro</label>
                  <select class="form-control" name="rubro" id="rubro" required>
                    <option value="Educacion">Educación</option>
                    <option value="Alimentos">Alimentos</option>
                    <option value="Moda y Textil">Moda y Textil</option>
                    <option value="Industrias">Industrias</option>
                    <option value="Deportes">Deportes</option>
                    <option value="Arte">Arte</option>
                    <option value="Tecnologia">Tecnología</option>
                    <option value="Comunicaciones">Comunicaciones</option>
                  </select>
                </div>
                <button type="submit" name="submit" class="btn btn-default">Registrar</button>
              </form>
            </div>
            <div class="register-actividad">
              <h2>Registrar Nueva Actividad</h2>
              <form action="addActiValidator.php" method="post">
                <input type="hidden" name="codigoU" value="<?php echo $codigo; ?>">
                <input type="hidden" name="ultimoCod" value="<?php echo $ultimoCod; ?>">
                <div class="form-group">
                  <label for="cliente">Cliente</label>
                  <select class="form-control" name="cliente" id="cliente" required>
                    <?php
                      $queryCli = mysqli_query($conexion, "SELECT DISTINCT a.CodigoCliente, a.Nombre FROM cliente a, usuarioCliente b WHERE b.CodigoUsuario = '$codigo' AND b.CodigoCliente = a.CodigoCliente")or die(mysqli_error());
                      while($row = mysqli_fetch_row($queryCli)){
                        echo "<option value='".$row[0]."'>".$row[1]."</option>";
                      }
                    ?>
                  </select>
                </div>
                <div class="form-group">
                  <label for="concept">Concepto de negociación</label>
                  <select class="form-control" name="concept" id="concept" required>
                    <?php
                      $query = mysqli_query($conexion, "SELECT * from negociacion");
                      while($row = mysqli_fetch_assoc($query)){
                        echo "<option value='".$row["CodigoNegocio"]."'>".$row["Nombre"]."</option>";
                      }
                    ?>
                  </select>
                </div>
                <div class="form-group">
                  <label for="motiv">Motivo</label>
                  <select class="form-control" name="motiv" id="motiv" required>
                    <option value="Comercial">Comercial</option>
                    <option value="Prensa">Prensa</option>
                    <option value="Prensa y Comercial">Prensa y Comercial</option>
                  </select>
                </div>
                <div class="form-group">
                  <label for="inter">Nivel de interés</label>
                  <select class="form-control" name="inter" id="inter" required>
                    <option value="Muy Interesado">Muy Interesado</option>
                    <option value="Regular">Regular</option>
                    <option value="No quiere">No quiere</option>
                  </select>
                </div>
                <div class="form-group">
                  <label for="contac">Modo de contacto</label>
                  <select class="form-control" name="contac" id="contac" required>
                    <option value="Fono Fijo">Fono Fijo</option>
                    <option value="Celular">Celular</option>
                    <option value="Whatsapp">Whatsapp</option>
                    <option value="Correo">Correo</option>
                    <option value="Personal">Personal</option>
                    <option value="Redes Sociales">Redes Sociales</option>
                  </select>
                </div>
                <button type="submit" name="submit2" class="btn btn-default">Registrar</button>
              </form>
            </div>
            <a href="#" id="button">Cerrar</a>
          </div>
          <!-- FIN DE REGISTRO -->

          <!-- BUSCADOR -->
          <div class="buscador">
            <h2>Búsqueda de?</h2>
            <form action="resultado.php" method="get">
              <div class="form-group">
                <label for="cli">Cliente</label>
                <input type="text" name="cli" id="cli" class="form-control">
              </div>
              <div class="form-group">
                <label for="ejec">Ejecutivo</label>
                <select type="text" name="ejec" id="ejec" class="form-control">
                  <option value="">-- Elegir --</option>
                  <?php
                    $query = mysqli_query($conexion, "SELECT * from usuario");
                    while($row = mysqli_fetch_assoc($query)){
                      echo "<option value='".$row["Nombre"]."'>".$row["Nombre"]."</option>";
                    }
                  ?>
                </select>
              </div>
              <div class="form-group">
                <label for="con">Concepto de negociación</label>
                <select name="con" id="con" class="form-control">
                  <option value="">-- Elegir --</option>
                  <?php
                    $query = mysqli_query($conexion, "SELECT * from negociacion");
                    while($row = mysqli_fetch_assoc($query)){
                      echo "<option value='".$row["Nombre"]."'>".$row["Nombre"]."</option>";
                    }
                  ?>
                </select>
              </div>
              <div class="form-group">
                <label for="mot">Motivo</label>
                <select name="mot" id="mot" class="form-control">
                  <option value="">-- Elegir --</option>
                  <option value="Comercial">Comercial</option>
                  <option value="Prensa">Prensa</option>
                  <option value="Prensa y Comercial">Prensa y Comercial</option>
                </select>
              </div>
              <div class="form-group">
                <label for="inte">Nivel de interés</label>
                <select name="inte" id="inte" class="form-control">
                  <option value="">-- Elegir --</option>
                  <option value="Muy Interesado">Muy Interesado</option>
                  <option value="Regular">Regular</option>
                  <option value="No quiere">No quiere</option>
                </select>
              </div>
              <div class="form-group">
                <label for="modo">Modo de contacto</label>
                <select name="modo" id="modo" class="form-control">
                  <option value="">-- Elegir --</option>
                  <option value="Fono Fijo">Fono Fijo</option>
                  <option value="Celular">Celular</option>
                  <option value="Whatsapp">Whatsapp</option>
                  <option value="Correo">Correo</option>
                  <option value="Personal">Personal</option>
                  <option value="Redes Sociales">Redes Sociales</option>
                </select>
              </div>
              <div class="form-group">
                <label for="rub">Rubro</label>
                <select name="rub" id="rub" class="form-control">
                  <option value="">-- Elegir --</option>
                  <option value="Educacion">Educación</option>
                  <option value="Alimentos">Alimentos</option>
                  <option value="Moda y Textil">Moda y Textil</option>
                  <option value="Industrias">Industrias</option>
                  <option value="Deportes">Deportes</option>
                  <option value="Arte">Arte</option>
                  <option value="Tecnologia">Tecnología</option>
                  <option value="Comunicaciones">Comunicaciones</option>
                </select>
              </div>
              <div class="form-group">
                <label for="desde">Desde</label>
                <input type="date" name="desde" id="desde" class="form-control">
              </div>
              <div class="form-group">
                <label for="hasta">Hasta</label>
                <input type="date" name="hasta" id="hasta" class="form-control">
              </div>
              <button type="submit" class="btn btn-default">Buscar</button>
            </form>
            <a href="#" id="cerrar">Cerrar</a>
          </div>

          <!-- ESTADISTICA
          <div class="estadistica">
            <div id="estadistica">

            </div>
          </div>
          FIN ESTADISTICA -->
        </div>
      </div>
    </main>
    <script src="js/jquery-2.2.1.min.js"></script>
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/modules/exporting.js"></script>
    <script src="js/jquery.pajinate.js"></script>
    <script src="js/main.js"></script>
    <script src="js/paginator.js"></script>
    <script src="js/jquery.tablesorter.min.js"></script>
    <script type="text/javascript">
      function reportePDF(){
        var opcion = '<?php echo "2"; ?>';
        var cod = '<?php echo $codigo; ?>';
        var nom = '<?php echo $nombre; ?>';
        window.open('descargaPDF.php?op='+opcion+'&codi='+cod+'&nom='+nom);
      }
      function reporteExcel(){
        var opcion = '<?php echo "2"; ?>';
        var cod = '<?php echo $codigo; ?>';
        var nom = '<?php echo $nombre; ?>';
        window.open('descargaExcel.php?op='+opcion+'&codi='+cod+'&nom='+nom);
      }
    </script>

    <!--<script type="text/javascript" id="pasarDatos" src="js/estadistica.js?nom=<?php echo $nombre; ?>&cod=<?php echo $codigo; ?>"></script>-->
  </body>
</html>
<?php
	}else{
		header("Location:login.php");
	}
?>
