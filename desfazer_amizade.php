<?php

session_start();

// Está logado?
  if ($_SESSION["logado"] == NULL) {
      header("Location: login.php");
  }

  
$id_usuario = $_SESSION["id_usuario"];
$id_pessoa = $_GET["id_pessoa"];
$status = 2;

include_once "bd.php";

        // Cria comando SQL
    $sql3 = "UPDATE amigo 
          SET status = ?, id_usuario_1 = ?, id_usuario_2 = ?
           WHERE id_usuario_1 = ? and id_usuario_2 = ? OR id_usuario_1 = ? and id_usuario_2 = ?";
    

    // Prepara query
    $preparacao3 = $con->prepare($sql3);
    

    // Deu erro?
    if ($preparacao3) {

      // Passa os parâmetros para a query
      $preparacao3->bind_param("iiiiiii", 
                              $status,
                              $id_usuario,
                              $id_pessoa,
                              $id_usuario,
                              $id_pessoa,
							  $id_pessoa,
							  $id_usuario);

      // Executa query no BD
      $retorno3 = $preparacao3->execute();
    
    
    if ($retorno3) {
    
    
        echo "<script> 
                alert('Amizade desfeita!');
                location.href = 'post.php';
              </script>";

      // Deu erro..
      } else {

        echo $preparacao3->error;

      }
  }

 
?>