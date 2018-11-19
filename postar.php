
	
	<?php
	include_once "topo.php"; 

  // Não exibe msg de notificação
  error_reporting(1);

  // Inicia a sessão
  session_start();

  //Está logado?
  if ($_SESSION["logado"] == NULL) {
      header("Location: login.php");
  }
	
	$id = $_SESSION["id_usuario"];
  // Clicou em salvar?
  if ($_POST != NULL) {

    // conecta ao BD
    include_once "bd.php";

    // Obtém dados do POST
    $titulo = $_POST["titulo"];
    $texto = $_POST["texto"];
    $foto = $_POST["foto"];
	    // Valida campos obrigatórios

    if ($texto == "" || $foto == "") {

        echo "<script> 
                alert('Precisa ao menos escrever algo! E poste uma foto.');
              </script>";

    } else {

      // Cria comando SQL
      $sql = "INSERT INTO postagem (
									titulo, 
									texto, 
									foto,
									data,
									id_usuario
									)
              VALUES ( ?,?,?,?,?)";

      // Prepara query
      $preparacao = $con->prepare($sql);

      // Deu erro?
      if ($preparacao) {

        // Passa os parâmetros para a query
        $preparacao->bind_param("ssssi",
								$titulo, 
								$texto,
								$foto,
								date("Y-m-d H:i:s"),
								$id);

        // Executa query no BD
        $retorno = $preparacao->execute();

        // Salvou no BD?
        if ($retorno) {

          echo "<script> 
                  alert('Postado com sucesso!');
                  location.href = 'post.php';
                </script>";

        // Deu erro..
        } else {

          echo "<script> 
                  alert('Erro na postagem!');
                </script>";

          echo $preparacao->error;

        }

      // Erro na query
      } else {
        echo $con->error;
      }

    }

  }

?>



<div id="cadastro">
<h1>Postagem</h1>

<form method="post" class="w3-container">
	<label>Título</label>
	<input class="w3-input" type="text" name="titulo" maxlength="100">
 
 <br>  
	<label>Texto</label>
	<textarea class="w3-input" name="texto" maxlength="10000"></textarea>
   
<br>  
	<label>URL da foto</label>
	<textarea class="w3-input" name="foto"></textarea>
  
  
  <br>
  <a class="w3-button w3-green w3-border w3-border-Blue w3-round-large" href="post.php">Cancelar</a>
  <button class="w3-button w3-green w3-border w3-border-Blue w3-round-large">Salvar</button>
</form>
</div>

