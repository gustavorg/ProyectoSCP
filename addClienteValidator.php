<?php
  include("conexion.php");
  session_start();
  $codUser = $_POST["codUser"];
  $lastCode = $_POST["lastCode"];
  $name = strtoupper($_POST["nombre"]);
  $codneg = $_POST["concepto"];
  $interes = $_POST["interes"];
  $contacto = $_POST["contacto"];
  $rubro = $_POST["rubro"];
  $motivo = $_POST["motivo"];
  $fecha = date("Y-m-d");

  //GENERAR NEW CODIGO

  eregi('^([a-z]+)([0-9]+)$', $lastCode, $arreglo);
	$arreglo[2] = $arreglo[2] + 1;
	$arreglo[2] = str_pad($arreglo[2], 4, 0, STR_PAD_LEFT);
	$newCode= 'D'.$arreglo[2];

  //INSERTAR DATOS

  mysqli_query($conexion, "INSERT INTO cliente VALUES('$newCode', '$name', '$interes', '$contacto', '$rubro', '$motivo', '$fecha', '$codneg')");
  mysqli_query($conexion, "INSERT INTO usuarioCliente VALUES('$codUser', '$newCode')");
  header("Location:index.php");
?>
