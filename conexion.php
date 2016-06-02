<?php
	$localhost = "localhost";
	$user = "root";
	$password = "";
	$bd = "bdsistemas";
	$conexion = mysqli_connect($localhost,$user,$password) or die("problemas al conectar server");
	mysqli_select_db($conexion, $bd);


?>
