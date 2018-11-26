<?php

session_start();

// Está logado?
  if ($_SESSION["logado"] == NULL) {
      header("Location: login.php");
  }
  
$id_usuario = $_SESSION["id_usuario"];
$id_pessoa = $_GET["id_pessoa"];
$status = 0;

include_once "bd.php";



      
    $sql2 = "SELECT *
            FROM amigo 
            WHERE id_usuario_1 = '$id_usuario' AND id_usuario_2 = '$id_pessoa' AND status = 2
             OR 
             id_usuario_1 = '$id_pessoa' AND id_usuario_2 = '$id_usuario' AND status = 2";

    // Executa a query no BD
    $retorno2 = $con->query($sql2);

    // Deu erro no SQL?
    if ($retorno2 == false) {
        echo $con->error;
    }


    $registro2 = $retorno2->fetch_array();

    if($registro2){

          // Cria comando SQL
    $sql3 = "UPDATE amigo 
          SET status = ?
           WHERE id_usuario_1 = ? and id_usuario_2 = ? OR id_usuario_1 = ? and id_usuario_2 = ?";
    

    // Prepara query
    $preparacao3 = $con->prepare($sql3);
    

    // Deu erro?
    if ($preparacao3) {

      // Passa os parâmetros para a query
      $preparacao3->bind_param("iiiii", 
                              $status,
                              $id_usuario,
                              $id_pessoa,
                              $id_pessoa,
                              $id_usuario);

      // Executa query no BD
      $retorno3 = $preparacao3->execute();
    
    
    if ($retorno3) {
    
    
        echo "<script> 
                alert('Solicitação Enviada! Hum...');
                location.href = 'amigos.php';
              </script>";

      // Deu erro..
      } else {

        echo $preparacao3->error;

      }
  }

    } else{

    

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
								$id_usuario, 
								$id_pessoa,
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


}
?>
