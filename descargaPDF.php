<?php
	require('fpdf/fpdf.php');
	require('conexion.php');

	//DECLARAR LIBRERIA Y PROPIEDADES

	$pdf = new FPDF('P', 'mm', 'A4');
	$pdf->SetMargins(2, 2, 2);
	$pdf->SetAutoPageBreak(true,25);
	$pdf->AddPage();
	$pdf->SetFont('Arial', '', 9);
	$pdf->Cell(50, 10, 'Fecha: '.date('d-m-Y').'', 0);
	$pdf->Ln(15);
	$pdf->SetFont('Arial', 'B', 11);
	$pdf->Cell(70, 8, '', 0);


	if(isset($_GET["op"]) && ($_GET["op"] == "1")){ //VIENE DE RESULTADO.PHP

		/*DECLARAR VARIABLES*/

		$name = $_GET["op1"];
		$ejecutive = $_GET["op2"];
		$negotation = $_GET["op3"];
		$interes = $_GET["op4"];
		$contact = $_GET["op5"];
		$category = $_GET["op6"];
		$motive = $_GET["op7"];
		$since = $_GET["op8"];
		$until = $_GET["op9"];

		/*PROPIEDADES DE FPDF*/
		$pdf->Cell(100, 8, utf8_decode('LISTADO DE BÚSQUEDA'), 0);
		$pdf->Ln(10);
		$pdf->SetFont('Arial', 'B', 8);
		$pdf->Ln(7);
		$pdf->Cell(7, 8, '#', 1);
		$pdf->Cell(21, 8, 'Ejecutivo', 1);
		$pdf->Cell(32, 8, 'Empresa', 1);
		$pdf->Cell(28, 8, utf8_decode('Negociación'), 1);
		$pdf->Cell(27, 8, 'Motivo', 1);
		$pdf->Cell(25, 8, utf8_decode('Interés'), 1);
		$pdf->Cell(22, 8, 'Contacto', 1);
		$pdf->Cell(25, 8, 'Rubro', 1);
		$pdf->Cell(20, 8, 'Fecha', 1);
		$pdf->Ln(8);
		$pdf->SetFont('Arial', '', 8);

		/*CUESTIONAR SI LOS CAMPOS DE FECHA ESTAN VACIO O NO*/
		/*CONSULTAS*/

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

		$i = 1;
		while($row = mysqli_fetch_array($query)){
			$pdf->Cell(7, 8, $i, 1);
			$pdf->Cell(21, 8, $row[0], 1);
			$pdf->Cell(32, 8,$row[1], 1);
			$pdf->Cell(28, 8, $row[2], 1);
			$pdf->Cell(27, 8, $row[6], 1);
			$pdf->Cell(25, 8, $row[3], 1);
			$pdf->Cell(22, 8, $row[4], 1);
		  $pdf->Cell(25, 8, $row[5], 1);
		  $pdf->Cell(20, 8, $row[7], 1);
			$pdf->Ln(8);
			$i++;
		}

	}else if(isset($_GET["op"]) && ($_GET["op"] == "2")){ //VIENE DE INDEX.PHP

			/*DECLARAR VARIABLES*/

			$codigo = $_GET["codi"];
			$nom = $_GET["nom"];

			/*PROPIEDADES DE FPDF*/

			$pdf->Cell(100, 8, 'CLIENTES', 0);
			$pdf->Ln(10);
			$pdf->SetFont('Arial', 'B', 8);
			$pdf->Cell(100,12,"EJECUTIVO: ". $nom);
			$pdf->Ln(10);
			$pdf->Cell(10, 8, '#', 1);
			$pdf->Cell(32, 8, 'Empresa', 1);
			$pdf->Cell(30, 8, utf8_decode('Negociación'), 1);
			$pdf->Cell(27, 8, 'Motivo', 1);
			$pdf->Cell(25, 8, utf8_decode('Interés'), 1);
			$pdf->Cell(22, 8, 'Contacto', 1);
			$pdf->Cell(25, 8, 'Rubro', 1);
			$pdf->Cell(20, 8, 'Fecha', 1);
			$pdf->Ln(8);
			$pdf->SetFont('Arial', '', 8);

			/*CONSULTA*/

			$query = mysqli_query($conexion, "SELECT DISTINCT  a.Nombre, a.NivelInt, a.Contacto, a.Rubro, a.Motivo, DATE_FORMAT(a.fechaRegistro, '%d-%m-%Y'), c.Nombre FROM cliente a,
		  usuarioCliente b, negociacion c WHERE b.CodigoUsuario = '$codigo' AND b.CodigoCliente = a.CodigoCliente AND a.CodigoNegocio = c.CodigoNegocio ORDER BY a.CodigoCliente")or die(mysqli_error());

			$i = 1;
			while($row = mysqli_fetch_array($query)){
				$pdf->Cell(10, 8, $i, 1);
				$pdf->Cell(32, 8,$row[0], 1);
				$pdf->Cell(30, 8, $row[6], 1);
				$pdf->Cell(27, 8, $row[4], 1);
				$pdf->Cell(25, 8, $row[1], 1);
				$pdf->Cell(22, 8, $row[2], 1);
			  $pdf->Cell(25, 8, $row[3], 1);
			  $pdf->Cell(20, 8, $row[5], 1);
				$pdf->Ln(8);
				$i++;
			}
	}else{ //VIENE DE CLIENTE.PHP

		/*DECLARAR VARIABLES*/

		$nomU = $_GET["nomU"];
		$nomC = $_GET["nomC"];
		$codC = $_GET["codC"];
		$codN = $_GET["codN"];
		$nom = $_GET["nom"];
		$neg = $_GET["neg"];
		$inte = $_GET["inte"];
		$con = $_GET["con"];
		$rub = $_GET["rub"];
		$mot = $_GET["mot"];
		$fec = date("d-m-Y",strtotime($_GET["fec"]));

		/*PROPIEDADES DE FPDF*/
		//CUADRO DE PRIMER REGISTRO
		$pdf->Cell(100, 8, 'CLIENTE: '.$nomC, 0);
		$pdf->Ln(10);
		$pdf->SetFont('Arial', 'B', 8);
		$pdf->Ln(7);
		$pdf->Cell(100,12,"Registrado por: ". $nomU);
		$pdf->Ln(7);
		$pdf->Cell(100,12,utf8_decode("Negociación: "). $neg);
		$pdf->Ln(7);
		$pdf->Cell(100,12,utf8_decode("Nivel de Interés: "). $inte);
		$pdf->Ln(7);
		$pdf->Cell(100,12,"Contacto: ". $con);
		$pdf->Ln(7);
		$pdf->Cell(100,12,"Rubro: ". $rub);
		$pdf->Ln(7);
		$pdf->Cell(100,12,"Motivo: ". $mot);
		$pdf->Ln(7);
		$pdf->Cell(100,12,"Fecha de registro: ". $fec);
		$pdf->Ln(10);
		$pdf->Cell(100, 8, 'HISTORIAL DE REGISTRO', 0);
		$pdf->Ln(10);
		//ACTIVIDADES

		$pdf->Cell(10, 8, '#', 1);
		$pdf->Cell(30, 8, utf8_decode('Negociación'), 1);
		$pdf->Cell(27, 8, 'Motivo', 1);
		$pdf->Cell(25, 8, utf8_decode('Interés'), 1);
		$pdf->Cell(22, 8, 'Contacto', 1);
		$pdf->Cell(20, 8, 'Fecha', 1);
		$pdf->Ln(8);
		$pdf->SetFont('Arial', '', 8);

		/*CONSULTA*/

		$query = mysqli_query($conexion, "SELECT b.Nombre, a.NivelInt, a.Contacto, a.Motivo, DATE_FORMAT(a.fechaRegistro, '%d-%m-%Y') FROM actividad a, negociacion b WHERE a.CodigoCliente = '$codC' AND
	  b.CodigoNegocio = '$codN'")or die(mysqli_error());

		$i = 1;
		while($row = mysqli_fetch_array($query)){
			$pdf->Cell(10, 8, $i, 1);
			$pdf->Cell(30, 8,$row[0], 1);
			$pdf->Cell(27, 8, $row[3], 1);
			$pdf->Cell(25, 8, $row[1], 1);
			$pdf->Cell(22, 8, $row[2], 1);
			$pdf->Cell(20, 8, $row[4], 1);
			$pdf->Ln(8);
			$i++;
		}

	}
	$pdf->Output('reporte.pdf','D');
?>
