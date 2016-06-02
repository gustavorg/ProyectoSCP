<?php
  include("conexion.php");
  session_start();
  $codUser = $_POST["codigoU"];
  $lastCode = $_POST["ultimoCod"];
  $codCliente = $_POST["cliente"];
  $interes= $_POST["inter"];
  $contacto = $_POST["contac"];
  $motivo = $_POST["motiv"];
  $fecha = date("Y-m-d");

  //GENERAR NEW CODIGO

  eregi('^([a-z]+)([0-9]+)$', $lastCode, $arreglo);
	$arreglo[2] = $arreglo[2] + 1;
	$arreglo[2] = str_pad($arreglo[2], 4, 0, STR_PAD_LEFT);
	$newCode= 'A'.$arreglo[2];

  //INSERTAR DATOS

  mysqli_query($conexion, "INSERT INTO actividad VALUES('$newCode','$interes', '$contacto', '$motivo', '$fecha', '$codCliente')")or die(mysqli_error());
  header("Location:cliente.php?cod=$codCliente");
?>
