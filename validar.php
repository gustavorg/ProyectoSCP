<?php
	session_start();
	require("conexion.php");

	$usuari = $_POST['usuari'];
	$pass = $_POST['pass'];

	if($usuari == "jromero"){
		$codigo = "C0001";
	}else if($usuari == "ocrispin"){
		$codigo = "C0002";
	}else if($usuari == "tnovoa"){
		$codigo = "C0003";
	}else{
		$codigo = "";
	}
	$row=mysqli_query($conexion, "SELECT * FROM usuario WHERE CodigoUsuario='$codigo' AND Password ='$pass'");

	if(mysqli_fetch_array($row)>0)
	  {
	  	$_SESSION["usuario"] = $codigo;

	    	//header("Location:gallery.php?cod=$codigo");

	    echo "<script>location.href='index.php'</script>";
	  }
	else
	  {
	    echo "<p>Ingrese los datos correctamente!</p>";
	  }
?>
