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
	$_SESSION["perfil_usuario"] = $perfil;
	$foto = $_POST["foto"];
	$_SESSION["foto_usuario"] =  $foto;

	

	// Valida campos obrigatórios
	if ($perfil == "") {
	
	    echo "<script> 
	            alert('Preencha corretamente!');
	          </script>";

	} else {
		
	
	  // Cria comando SQL
	  $sql3 = "UPDATE perfil 
	  		  SET perfil = ?, data = ?
	  		   WHERE id = ?";
		
	if($foto != ""){
		
		
		
		$sql4 = "UPDATE cadastro 
	  		  SET foto = ?
	  		   WHERE id = ?";	

	$preparacao1 = $con->prepare($sql4);
	
	if($preparacao1){
		
		$preparacao1->bind_param("si", 
	                          $foto,
							  $id);
							  
	$retorno1 = $preparacao1->execute();
	
	}
	} else {
	$foto = $_SESSION["foto_usuario"];
	}

	  // Prepara query
	  $preparacao = $con->prepare($sql3);
	  

	  // Deu erro?
	  if ($preparacao) {

	    // Passa os parâmetros para a query
	    $preparacao->bind_param("ssi", 
	                          $perfil,
								date("Y-m-d H:i:s"),
	                          $id);

	    // Executa query no BD
	    $retorno = $preparacao->execute();
		
		
		if ($retorno1) {
		
		
	      echo "<script> 
	              alert('Foto Atualizada com Sucesso!');
	            </script>";

	    // Deu erro..
	    } else {

	      echo $preparacao1->error;

	    }

	    // Salvou no BD?
	    if ($retorno) {
		
		
	      echo "<script> 
	              alert('Perfil Atualizado com Sucesso!');
	              location.href = 'post.php';
	            </script>";

	    // Deu erro..
	    } else {

	      echo "<script> 
	              alert('Erro ao Atualizar Perfil!');
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
	Digite url da foto:
	<textarea name="foto"></textarea> 
	Atualize seu perfil:
	<textarea name="perfil"><?php echo $perfil;?></textarea>
	
	<!-- <input type="file" name="foto" id="fileToUpload"> -->
	
	</table>
		  <a class="w3-button w3-green w3-border w3-border-Blue w3-round-large" href="post.php">Cancelar</a>
  <button class="w3-button w3-green w3-border w3-border-Blue w3-round-large">Salvar</button>
</form>
</div>
