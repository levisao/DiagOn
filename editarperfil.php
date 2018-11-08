<?php 
// Conecta ao DB
include_once "topo.php";

// Não exibe msg de notificação
error_reporting(1);

// Inicia a sessão
session_start();

// Está logado?
if ($_SESSION["logado"] == NULL) {
  header("Location: ../index.php");
}

// Obtem ID da URL
$id = $_SESSION["id_usuario"];
// Passou ID via GET?
if ($id == NULL) {
	echo "ID não foi passado!<br>";
}

// Conecta ao DB
include_once "bd.php";

// Cria comando SQL
$sql = "SELECT *
		FROM cadastro 
		WHERE id = $id";

// Executa SQl no DB
$retorno = $con->query($sql);

// Deu erro?
if ($retorno == false) {
	echo $con->error;
}

// Obtem registro
$registro = $retorno->fetch_array();

// Obtem campos do registro
$perfil = $registro["perfil"];

// Clicou em salvar?
if ($_POST != NULL) {

	// Obtém dados do POST
	$perfil = $_POST["perfil"];
	
	

	// Valida campos obrigatórios
	if ($perfil == "") {

	    echo "<script> 
	            alert('Preencha corretamente!');
	          </script>";

	} else {

	  // Cria comando SQL
	  $sql = "UPDATE perfil 
	  		  SET perfil = ?,
	  		   WHERE id = ?";

	  // Prepara query
	  $preparacao = $con->prepare($sql);

	  // Deu erro?
	  if ($preparacao) {

	    // Passa os parâmetros para a query
	    $preparacao->bind_param("si", 
	                          $perfil,  
	                          $id);

	    // Executa query no BD
	    $retorno = $preparacao->execute();

	    // Salvou no BD?
	    if ($retorno) {

	      echo "<script> 
	              alert('Atualizado com Sucesso!');
	              location.href = 'post.php';
	            </script>";

	    // Deu erro..
	    } else {

	      echo "<script> 
	              alert('Erro ao Atualizar!');
	            </script>";

	      echo $preparacao->error;

	    }

	  // Erro na query
	  } else {
	    echo $con->error;
	  }

	}

}

include_once "/topo.php"; 

?>
<div id="cadastro">
<h1>Editar perfil</h1>

<table class="table table-bordered">
	

	<textarea>	<?php echo $perfil; ?></textarea>
	
</table>
<form method="post">
	<a class="btn btn-light" href="post.php">Cancelar</a>
	<button class="btn btn-primary" type="submit" onclick="post.php">Salvar</button>
</form>
</div>
