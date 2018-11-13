<?php



include_once "bd.php";

session_start();

$login = $_SESSION["login_cadastro"];
$senha = $_SESSION["senha_cadastro"];

			$sql3 = "SELECT * 
			FROM cadastro 
			WHERE login = '$login' 
			AND senha = '$senha'";
//echo $sql; exit;
	// Executa comando SQL
	$retorno3 = $con->query($sql3);

	// Erro no SQL?
	if ($retorno3 == false) {
		echo $retorno3->error;
	}

	// Obtem registro no banco
	$registro3 = $retorno3->fetch_array();

	// Encontrou usuário?
	if ($registro3) {


		// Guarda variáveis na sessão
		
		$id = $registro3["id"];
		$status = 1;
		$data_convite = "";
	}
		
		
		
		
		
		
		
		
				$sql2 = "INSERT INTO amigo (
									id_usuario_1, 
									id_usuario_2, 
									data_convite,
									status
									)
              VALUES ( ?,?,?,?)";

      // Prepara query
      $preparacao2 = $con->prepare($sql2);

      // Deu erro?
      if ($preparacao2) {

        // Passa os parâmetros para a query
        $preparacao2->bind_param("iisi",
								$id, 
								$id, 
								$data_convite,
								$status);

        // Executa query no BD
        $retorno2 = $preparacao2->execute();
		
	   if ($retorno2) {
		
		
		
		

          echo "<script> 
                  location.href = 'login.php';
                </script>";

        // Deu erro..
        } else {

          echo "<script> 
                  alert('Erro!');
				  location.href = 'cadastro.php';
                </script>";

          echo $preparacao->error;

        }

      // Erro na query
      } else {
        echo $con->error;
      }
		




?>