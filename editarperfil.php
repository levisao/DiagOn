<?php 

include_once "topo.php";

// Não exibe msg de notificação
error_reporting(1);

// Inicia a sessão
session_start();

// Está logado?
if ($_SESSION["logado"] == NULL) {
  header("Location: login.php");
}

// Obtem ID
$id = $_SESSION["id_usuario"];  
// Passou ID
if ($id == NULL) {
	echo "ID não foi passado! <br>";
}

// Conecta ao DB
include_once "bd.php";

// Cria comando SQL
$sql = "SELECT *
		FROM perfil 
		WHERE id = '$id'";

// Executa SQl no DB
$retorno = $con->query($sql);

// Deu erro?
if ($retorno == false){ 
	echo $con->error; 
}
if($retorno){  //como fazer para se n retornar nada adicionar o campo?
}


// Obtem registro
$registro = $retorno->fetch_array();



if($registro == NULL){


		
			$sql2 = "INSERT INTO perfil (id, perfil) VALUES ('$id', '')";
			
			$return = $con->query($sql2);
			if($return==false){
			echo $con->error;
			}


}

// Obtem campos do registro
$perfil = $registro["perfil"];

// Clicou em salvar?
if ($_POST != NULL) {     //NAO TA ENTRANDO AQUI


	// Obtém dados do POST
	$perfil = $_POST["perfil"];
	
	

	// Valida campos obrigatórios
	if ($perfil == "") {

	    echo "<script> 
	            alert('Preencha corretamente!');
	          </script>";

	} else {

	  // Cria comando SQL
	  $sql3 = "UPDATE perfil 
	  		  SET perfil = ?
	  		   WHERE id = ?";

	  // Prepara query
	  $preparacao = $con->prepare($sql3);

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


?>
<div id="cadastro">
<h1>Editar perfil</h1>

<form method="post">
	<table class="table table-bordered">
	

	<textarea name="perfil"><?php echo $perfil;?></textarea>
	
	</table>
	<a class="btn btn-light" href="post.php">Cancelar</a>
	<input type="submit" value="Salvar">
</form>
</div>
