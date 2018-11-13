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
    

		
    	// imprime linha em HTML
    	echo "<tr>
			<td>$nome</td>
				<td><img src='$foto'></td>
				
			</tr>";
	}
	    	echo "</table>";
			
}
?>

</body>
</html>
