<?php
session_start();

include_once "bd.php";

$id_usuario = $_SESSION["id_usuario"];
$id_postagem = $_GET["id_postagem"];



$sql7 = "SELECT * FROM curtir WHERE id_autor = '$id_usuario' AND id_postagem = '$id_postagem'";
		 
		 $retorno7 = $con->query($sql7);

			// Deu erro?
			if ($retorno7 == false){ 
				echo $con->error; 
				
			}

         $registro7 = $retorno7->fetch_array();
		 
		 if($registro7){
			 
			 echo "<script> 
                  alert('Você já curtiu!');
                  location.href = 'post.php';
                </script>";
				

		 } else{







$sql = "INSERT INTO curtir (
									id_autor, 
									id_postagem
									)
              VALUES ( ?,?)";

      // Prepara query
      $preparacao = $con->prepare($sql);

      // Deu erro?
      if ($preparacao) {

        // Passa os parâmetros para a query
        $preparacao->bind_param("ii",
								$id_usuario, 
								$id_postagem);

        // Executa query no BD
        $retorno = $preparacao->execute();
		
	

        // Salvou no BD?
        if ($retorno) {
		
		
		
		

          echo "<script> 
                  alert('Curtido!');
                  location.href = 'post.php';
                </script>";

        // Deu erro..
        } else {

          echo "<script> 
                  alert('Erro ao Curtir!');
                </script>";

          echo $preparacao->error;

        }

      // Erro na query
      } else {
        echo $con->error;
      }
		 }
?>