<?php

session_start();

$id_usuario_1 = $_SESSION["id_usuario"];
$id_usuario_2 = $_GET["id_pessoa"];
$status = 0;

include_once "bd.php";

// Cria comando SQL
      $sql = "INSERT INTO amigo (
									id_usuario_1, 
									id_usuario_2, 
									data_convite,
									status
									)
              VALUES ( ?,?,?,?)";

      // Prepara query
      $preparacao = $con->prepare($sql);

      // Deu erro?
      if ($preparacao) {

        // Passa os parâmetros para a query
        $preparacao->bind_param("iisi",
								$id_usuario_1, 
								$id_usuario_2,
								date("Y-m-d H:i:s"),
								$status);

        // Executa query no BD
        $retorno = $preparacao->execute();

        // Salvou no BD?
        if ($retorno) {

          echo "<script> 
                  alert('Solicitação Enviada!');
                  location.href = 'buscar.php';
                </script>";

        // Deu erro..
        } else {

          echo "<script> 
                  alert('Erro!');
                </script>";

          echo $preparacao->error;

        }

      // Erro na query
      } else {
        echo $con->error;
      }


?>
