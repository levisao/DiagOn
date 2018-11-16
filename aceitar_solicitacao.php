<?php

	session_start();


	$id_usuario = $_GET["id_usuario"];

	$id_pessoa = $_GET["id_pessoa"];

	$status = 1;

	//echo "$status";

	include_once "bd.php";

	  // Cria comando SQL
	  $sql = "UPDATE amigo 
	  		  SET status = ?
	  		   WHERE id_usuario_1 = ? and id_usuario_2 = ?";
		

	  // Prepara query
	  $preparacao = $con->prepare($sql);
	  

	  // Deu erro?
	  if ($preparacao) {

	    // Passa os parâmetros para a query
	    $preparacao->bind_param("iii", 
	                          	$status,
								$id_pessoa,
	                          	$id_usuario);

	    // Executa query no BD
	    $retorno = $preparacao->execute();
		
		
		if ($retorno) {
		
		
	      echo "<script> 
	              alert('Agora vocês são amigos!');
	              location.href = 'amigos.php';
	            </script>";

	    // Deu erro..
	    } else {

	      echo $preparacao->error;

	    }
	}


?>