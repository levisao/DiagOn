<?php 

include_once "topo.php";

// Não exibe msg de notificação
error_reporting(1);


// Inicia a sessão
session_start();

$id_usuario = $_SESSION["id_usuario"];

// Está logado?
if ($_SESSION["logado"] == NULL) {
  header("Location: login.php");
}

// Conecta ao DB
include_once "bd.php";
// Clicou em enviar?

if ($_POST != NULL) {

	$nome = $_POST["nome"];
	
// Cria comando SQL
$sql = "SELECT *
		FROM cadastro 
		WHERE nome like '%$nome%'";

// Executa SQl no DB
$retorno = $con->query($sql);

// Deu erro?
if ($retorno == false){ 
	echo $con->error; 
	
}


	
	

}


?>

<form method="post">

<h1 align="center">Buscar usuários </h1>
<div align="center" > 
<input type="text" name="nome" maxlength="100">
<input type="submit" class="w3-button w3-green w3-border w3-border-Blue w3-round-large" value="Buscar">
</div>
</form>

<?php
if ($_POST != NULL) {

	    	echo "<table border='1'>";
	
	while ($registro = $retorno->fetch_array()) {

    	// obtem campos do registro
    	
    	$nome = $registro["nome"];
    	$foto = $registro["foto"];
		$id_pessoa = $registro["id"];
		
		
		$sql1 = "SELECT *
		FROM amigo 
		WHERE id_usuario_1 = '$id_usuario' AND id_usuario_2 = '$id_pessoa' 
		OR 
		id_usuario_1 = '$id_pessoa' AND id_usuario_2 = '$id_usuario'";

			// Executa SQl no DB
			$retorno1 = $con->query($sql1);

			// Deu erro?
			if ($retorno1 == false){ 
				echo $con->error; 
				
			}

         $registro1 = $retorno1->fetch_array();
		 
		 $status = $registro1["status"];
		
    	// imprime linha em HTML
    	echo "<tr>
			<td>$nome</td>
				<td><img src='$foto'></td>
				<td><a href = 'perfil_pessoa.php'>Ver Perfil</a></td>
				<td>";
				
				if($registro1){


					if($status == 1){
				echo "<a href='deixar_seguir.php?id_pessoa=$id_pessoa'>Deixar de seguir";
					}else{
						if($status == 0){
						echo "<a href='retirar_solicitacao.php?id_pessoa=$id_pessoa'>Retirar Solicitação";	
										
				}else{
					if($status == 3){
					
				echo "<a href='post.php?id_pessoa=$id_pessoa'>Voltar para Perfil";
				}
			}
			}
		}else{
			echo "<a href='adicionar_amigo.php?id_pessoa=$id_pessoa'>Adicionar";
		}
				
				echo "</a></td>
				
			</tr>";
	
}

	    	echo "</table>";
	}		

?>

</body>
</html>
