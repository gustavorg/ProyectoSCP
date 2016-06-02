<?php
	session_start();
	include("conexion.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Login</title>
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<link rel="stylesheet" href="css/stylessubir.css">
</head>
<body>
	<section id="logueo">
		<form action="" method="POST">
			<div class="form-group">
				<label for="usuari">Usuario:</label>
				<input type="text" id="usuari" name="usuari" class="form-control" required>
			</div>
			<div class="form-group">
				<label for="pass">Password:</label>
				<input type="password" id="pass" name="pass" class="form-control" required>
			</div>
			<button type="submit" name="submit" class="btn btn-default">Ingresar</button>
		</form>
		<?php
			if(isset($_POST["submit"])){
				require("validar.php");
			}
		?>
	</section>
</body>
</html>
