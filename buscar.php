<?php 

include_once "topo_1.php";

// Não exibe msg de notificação
error_reporting(1);


// Inicia a sessão
session_start();


// Está logado?
if ($_SESSION["logado"] == NULL) {
  header("Location: login.php");
}
$id_usuario = $_SESSION["id_usuario"];


$foto = $_SESSION["foto_usuario"];
$nome = $_SESSION["nome_usuario"];

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
<?php include_once "menu.php"?>
<form method="post">

<h1 align="center">Buscar usuários </h1>
<div align="center" > 
<input type="text" name="nome" maxlength="100">
<input type="submit" class="w3-button w3-blue w3-border w3-border-Blue w3-round-large" value="Buscar">

<br>
<a href="post.php">Voltar</a>
<div id="busca">
</form>

<?php
if ($_POST != NULL) {

	    	echo "<table>";
	
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
		 $id_dono = $registro1["id_usuario_1"];
		
    	// imprime linha em HTML
    	echo "<tr>
			<td>$nome</td>
				<td><img style = 'width:220px; height:auto' src='$foto'></td>
				<td><a href = 'perfil_pessoa.php?id_pessoa=$id_pessoa&foto_pessoa=$foto&nome_pessoa=$nome' style='font-size:24px' class='far fa-eye'></a></td>
				<td>";
				
				if($registro1){


					if($status == 1){
				echo "<a href='desfazer_amizade.php?id_pessoa=$id_pessoa' style='font-size:24px' class='fas fa-user-alt-slash'>";
					}else{
						if($status == 0 && $id_dono != $id_usuario){
						echo "
						<a style='font-size:24px' href= 'aceitar_solicitacao.php?id_pessoa=$id_pessoa&id_usuario=$id_usuario'  class='fas fa-hand-point-up'></a></td>
						<td><a style='font-size:24px' href= 'declinar_solicitacao.php?id_pessoa=$id_pessoa&id_usuario=$id_usuario' class='fas fa-hand-point-down'>";	
										
				}else{
					if($status == 3){
					
				echo "<a href='post.php?id_pessoa=$id_pessoa' style='font-size:24px' class='fas fa-home'>";
				}else{
					if($status == 2){
					echo "<a href='adicionar_amigo.php?id_pessoa=$id_pessoa' style='font-size:24px' class='fas fa-plus'>";
					}
					else{
						if($status == 0 && $id_dono == $id_usuario){
						echo "
							<td><a style='font-size:24px' href= 'retirar_solicitacao.php?id_pessoa=$id_pessoa&id_usuario=$id_usuario' class='fas fa-user-times'>";	
												
						}
					}
				}
			}
			}
		}else{
			echo "<a href='adicionar_amigo.php?id_pessoa=$id_pessoa' style='font-size:24px' class='fas fa-plus'>";
		}
				
				echo "</a></td>
				
			</tr>";
	
}

	    	echo "</table>";
	}		

?>
</div></div>

</body>
</html>
