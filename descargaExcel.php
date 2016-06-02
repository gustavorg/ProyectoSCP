<?php
  include("conexion.php");
  require_once 'phpexcel/Classes/PHPExcel.php';

  // LLAMANDO A LA LIBRERIA Y PROPIEDADES

  $objPHPExcel = new PHPExcel();
  $objPHPExcel->
    getProperties()
        ->setCreator("Blitzperu.com")
        ->setLastModifiedBy("Blitzperu.com")
        ->setTitle("Reporte de Clientes")
        ->setSubject("Reporte de Clientes")
        ->setDescription("Reporte de Clientes")
        ->setKeywords("usuarios phpexcel")
        ->setCategory("reportes");

  //PREGUNTAR ACUERDO DE QUE PAGINA VIENE

  if(isset($_GET["op"]) && ($_GET["op"] == "1")){ //VIENE DE RESULTADO.PHP

    /*DECLARACION DE VARIABLES*/

    $name = $_GET["op1"];
  	$ejecutive = $_GET["op2"];
  	$negotation = $_GET["op3"];
  	$interes = $_GET["op4"];
  	$contact = $_GET["op5"];
  	$category = $_GET["op6"];
  	$motive = $_GET["op7"];
  	$since = $_GET["op8"];
  	$until = $_GET["op9"];

    /*LLENAR CELDAS DEL EXCEL -> CABECERA*/

    $objPHPExcel->setActiveSheetIndex(0)
                ->mergeCells('A1:I1');
    $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A1', 'RESULTADO DE BUSQUEDA')
                ->setCellValue('A3', '#')
                ->setCellValue('B3', 'Ejecutivo')
                ->setCellValue('C3', 'Cliente')
                ->setCellValue('D3', 'Negociación')
                ->setCellValue('E3', 'Interés')
                ->setCellValue('F3', 'Contacto')
                ->setCellValue('G3', 'Rubro')
                ->setCellValue('H3', 'Motivo')
                ->setCellValue('I3', 'Fecha');

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

    $i = 1; //INDICE
    $j = 4; //COMENZAR DE LA 4TA FILA

    /*LLENAR CELDAS CON LOS DATOS*/
    while($row = mysqli_fetch_array($query)){
      $objPHPExcel->setActiveSheetIndex(0)
                  ->setCellValue('A'.$j, $i)
                  ->setCellValue('B'.$j, $row[0])
                  ->setCellValue('C'.$j, $row[1])
                  ->setCellValue('D'.$j, $row[2])
                  ->setCellValue('E'.$j, $row[3])
                  ->setCellValue('F'.$j, $row[4])
                  ->setCellValue('G'.$j, $row[5])
                  ->setCellValue('H'.$j, $row[6])
                  ->setCellValue('I'.$j, $row[7]);
      $i++;
      $j++;
    }

    $contador = 0; //variable para estilos

  }else if(isset($_GET["op"]) && ($_GET["op"] == "2")){ //VIENE DE INDEX.PHP

    /*DECLARACION DE VARIABLES*/

    $codigo = $_GET["codi"];
    $nom = $_GET["nom"];

    /*LLENAR CELDAS DEL EXCEL -> CABECERA*/

    $objPHPExcel->setActiveSheetIndex(0)
                ->mergeCells('A1:H1');
    $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A1', 'CLIENTES DE: '.$nom)
                ->setCellValue('A3', '#')
                ->setCellValue('B3', 'Nombre')
                ->setCellValue('C3', 'Negociación')
                ->setCellValue('D3', 'Interés')
                ->setCellValue('E3', 'Contacto')
                ->setCellValue('F3', 'Rubro')
                ->setCellValue('G3', 'Motivo')
                ->setCellValue('H3', 'Fecha');

    /*CONSULTA*/

    $query = mysqli_query($conexion, "SELECT DISTINCT  a.Nombre, a.NivelInt, a.Contacto, a.Rubro, a.Motivo, DATE_FORMAT(a.fechaRegistro, '%d-%m-%Y'), c.Nombre FROM cliente a,
    usuarioCliente b, negociacion c WHERE b.CodigoUsuario = '$codigo' AND b.CodigoCliente = a.CodigoCliente AND a.CodigoNegocio = c.CodigoNegocio ORDER BY a.CodigoCliente")or die(mysqli_error());

    $i = 1;//INDICE
    $j = 4;//NUMERO DE FILA A COMENZAR

    /*LLENAR CELDAS CON LOS DATOS*/

    while($row = mysqli_fetch_array($query)){
      $objPHPExcel->setActiveSheetIndex(0)
                  ->setCellValue('A'.$j, $i)
                  ->setCellValue('B'.$j, $row[0])
                  ->setCellValue('C'.$j, $row[6])
                  ->setCellValue('D'.$j, $row[1])
                  ->setCellValue('E'.$j, $row[2])
                  ->setCellValue('F'.$j, $row[3])
                  ->setCellValue('G'.$j, $row[4])
                  ->setCellValue('H'.$j, $row[5]);
      $i++;
      $j++;
    }

    $contador = 1;

  }else{ //VIENE DE CLIENTE.PHP

    /*DECLARACION DE VARIABLES*/

    $nomU = $_GET["nomU"];
    $nomC = $_GET["nomC"];
  	$codC = $_GET["codC"];
  	$codN = $_GET["codN"];
  	$nom = $_GET["nom"];
  	$nomneg = $_GET["neg"];
  	$inte = $_GET["inte"];
  	$con = $_GET["con"];
  	$rub = $_GET["rub"];
  	$mot = $_GET["mot"];
  	$fec = $_GET["fec"];

    /*LLENAR CELDAS DEL EXCEL -> CABECERA*/

    $objPHPExcel->setActiveSheetIndex(0)
                ->mergeCells('A1:F1');
    $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A1', 'HISTORIAL DE ACTIVIDADES DE: '.$nomC);
    $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A3', '#')
                ->setCellValue('B3', 'Negociación')
                ->setCellValue('C3', 'Interés')
                ->setCellValue('D3', 'Contacto')
                ->setCellValue('E3', 'Motivo')
                ->setCellValue('F3', 'Fecha');

    /*LLENAR CELDAS DEL EXCEL -> CUADRO DE CLIENTE*/

    $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('H3', 'Registrado por: ')
                ->setCellValue('I3', $nomU)
                ->setCellValue('H4', 'Negociación: ')
                ->setCellValue('I4', $nomneg)
                ->setCellValue('H5', 'Nivel de interés: ')
                ->setCellValue('I5', $inte)
                ->setCellValue('H6', 'Contacto: ')
                ->setCellValue('I6', $con)
                ->setCellValue('H7', 'Rubro: ')
                ->setCellValue('I7', $rub)
                ->setCellValue('H8', 'Motivo: ')
                ->setCellValue('I8', $mot)
                ->setCellValue('H9', 'Fecha de registro: ')
                ->setCellValue('I9', $fec);

    /*CONSULTA*/

    $query = mysqli_query($conexion, "SELECT b.Nombre, a.NivelInt, a.Contacto, a.Motivo, DATE_FORMAT(a.fechaRegistro, '%d-%m-%Y') FROM actividad a, negociacion b WHERE a.CodigoCliente = '$codC' AND
    b.CodigoNegocio = '$codN'")or die(mysqli_error());

    $i = 1; //INDICE
    $j = 4; //FILA A EMPEZAR

    while($row = mysqli_fetch_array($query)){
      $objPHPExcel->setActiveSheetIndex(0)
                  ->setCellValue('A'.$j, $i)
                  ->setCellValue('B'.$j, $row[0])
                  ->setCellValue('C'.$j, $row[1])
                  ->setCellValue('D'.$j, $row[2])
                  ->setCellValue('E'.$j, $row[3])
                  ->setCellValue('F'.$j, $row[4]);
      $i++;
      $j++;
    }

    $contador = 2;
  }

  //DECLARAR ESTILOS PARA EXCEL

  $estiloTituloReporte = array(
    'font' => array(
        'name'      => 'Verdana',
        'bold'      => true,
        'italic'    => false,
        'strike'    => false,
        'size' =>16,
        'color'     => array(
            'rgb' => 'FFFFFF'
        )
    ),
    'fill' => array(
      'type'  => PHPExcel_Style_Fill::FILL_SOLID,
      'color' => array(
            'argb' => 'FF220835')
    ),
    'borders' => array(
        'allborders' => array(
            'style' => PHPExcel_Style_Border::BORDER_NONE
        )
    ),
    'alignment' => array(
        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
        'rotation' => 0,
        'wrap' => TRUE
    )
  );
  $estiloTituloColumnas = array(
    'font' => array(
        'name'  => 'Arial',
        'bold'  => true,
        'color' => array(
            'rgb' => 'FFFFFF'
        )
    ),
    'fill' => array(
        'type'       => PHPExcel_Style_Fill::FILL_GRADIENT_LINEAR,
        'rotation'   => 90,
        'startcolor' => array(
            'rgb' => 'c47cf2'
        ),
        'endcolor' => array(
            'argb' => 'FF431a5d'
        )
    ),
    'borders' => array(
        'top' => array(
            'style' => PHPExcel_Style_Border::BORDER_MEDIUM ,
            'color' => array(
                'rgb' => '143860'
            )
        ),
        'bottom' => array(
            'style' => PHPExcel_Style_Border::BORDER_MEDIUM ,
            'color' => array(
                'rgb' => '143860'
            )
        )
    ),
    'alignment' =>  array(
        'horizontal'=> PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
        'vertical'  => PHPExcel_Style_Alignment::VERTICAL_CENTER,
        'wrap'      => TRUE
    )
  );
  $estiloInfAct = new PHPExcel_Style();
  $estiloInfAct->applyFromArray( array(
    'font' => array(
        'name'  => 'Arial',
        'color' => array(
            'rgb' => '000000'
        )
    ),
    'borders' => array(
        'top' => array(
            'style' => PHPExcel_Style_Border::BORDER_MEDIUM ,
            'color' => array(
                'rgb' => '143860'
            )
        ),
        'bottom' => array(
            'style' => PHPExcel_Style_Border::BORDER_MEDIUM ,
            'color' => array(
                'rgb' => '143860'
            )
        ),
        'left' => array(
            'style' => PHPExcel_Style_Border::BORDER_MEDIUM ,
            'color' => array(
                'rgb' => '143860'
            )
        ),
        'right' => array(
            'style' => PHPExcel_Style_Border::BORDER_MEDIUM ,
            'color' => array(
                'rgb' => '143860'
            )
        )
    )
  ));
  $estiloInformacion = new PHPExcel_Style();
  $estiloInformacion->applyFromArray( array(
    'font' => array(
        'name'  => 'Arial',
        'color' => array(
            'rgb' => '000000'
        )
    ),
    'fill' => array(
    'type'  => PHPExcel_Style_Fill::FILL_SOLID,
    'color' => array(
            'argb' => 'FFd9b7f4')
    ),
    'borders' => array(
        'left' => array(
            'style' => PHPExcel_Style_Border::BORDER_THIN ,
      'color' => array(
              'rgb' => '3a2a47'
            )
        )
    )
  ));

  //INCLUIR LOS ESTILOS

  if($contador == 1){ // INDEX.PHP
    $objPHPExcel->getActiveSheet()->getStyle('A1:H1')->applyFromArray($estiloTituloReporte);
    $objPHPExcel->getActiveSheet()->getStyle('A3:H3')->applyFromArray($estiloTituloColumnas);
    $objPHPExcel->getActiveSheet()->setSharedStyle($estiloInformacion, "A4:H".($i+2));

    for($i = 'A'; $i <= 'H'; $i++){
      $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension($i)->setAutoSize(TRUE);
    }
  }else if($contador == 2){ // CLIENTE.PHP
    $objPHPExcel->getActiveSheet()->getStyle('A1:F1')->applyFromArray($estiloTituloReporte);
    $objPHPExcel->getActiveSheet()->getStyle('A3:F3')->applyFromArray($estiloTituloColumnas);
    $objPHPExcel->getActiveSheet()->setSharedStyle($estiloInformacion, "A4:F".($i+2));

    $objPHPExcel->getActiveSheet()->setSharedStyle($estiloInfAct, "H3:I9");

    for($i = 'A'; $i <= 'F'; $i++){
      $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension($i)->setAutoSize(TRUE);
    }
    for($i = 'H'; $i <= 'I'; $i++){
      $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension($i)->setAutoSize(TRUE);
    }
  }else{ // RESULTADO.PHP
    $objPHPExcel->getActiveSheet()->getStyle('A1:I1')->applyFromArray($estiloTituloReporte);
    $objPHPExcel->getActiveSheet()->getStyle('A3:I3')->applyFromArray($estiloTituloColumnas);
    $objPHPExcel->getActiveSheet()->setSharedStyle($estiloInformacion, "A4:I".($i+2));

    for($i = 'A'; $i <= 'I'; $i++){
      $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension($i)->setAutoSize(TRUE);
    }
  }


  // Se asigna el nombre a la hoja
  $objPHPExcel->getActiveSheet()->setTitle('Busqueda');

  // Se activa la hoja para que sea la que se muestre cuando el archivo se abre
  $objPHPExcel->setActiveSheetIndex(0);

  // Inmovilizar paneles
  //$objPHPExcel->getActiveSheet(0)->freezePane('A4');
  $objPHPExcel->getActiveSheet(0)->freezePaneByColumnAndRow(0,4);

  // Se manda el archivo al navegador web, con el nombre que se indica, en formato 2007
  header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
  header('Content-Disposition: attachment;filename="Reporte.xlsx"');
  header('Cache-Control: max-age=0');

  $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
  $objWriter->save('php://output');
  exit;
?>
