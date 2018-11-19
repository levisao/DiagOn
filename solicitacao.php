<?php

    // Não exibe msg de notificação
    error_reporting(1);

	
	//inicia sessao (pode botar la no inicio tbm, embaixo de error_reporting - adicionado para o index
	session_start();
	
	
	$id_usuario = $_SESSION["id_usuario"];
	
	// Está logado?     - adicionado para o index
	if($_SESSION["logado"] == NULL){
		
		header("Location: login.php");
		
	}
			
    // conecta ao BD
    include_once "bd.php";


    // Cria comando SQL
    $sql = "SELECT *
            FROM cadastro 
            ORDER BY nome ";

    // Executa a query no BD
    $retorno = $con->query($sql);

    // Deu erro no SQL?
    if ($retorno == false) {
        echo $con->error;
    }

    include_once "topo.php";
?>
<h1 style = "text-align:center">Solicitações de Amizade</h1>
<div style = "text-align:center">
<div id="amigos">

<table id="carlos">



<?php


$sql4 = "SELECT *
            FROM cadastro  ";

    // Executa a query no BD
    $retorno4 = $con->query($sql4);

    // Deu erro no SQL?
    if ($retorno4 == false) {
        echo $con->error;
    }


    while ($registro4 = $retorno4->fetch_array()) {

    	// obtem campos do registro
    	$id_pessoa = $registro4["id"];
			 
		 $nome_soli = $registro4["nome"];
		 $foto_soli = $registro4["foto"];
    	
		
		


			$sql3 = "SELECT *
		FROM amigo 
		WHERE id_usuario_1 = '$id_pessoa' AND id_usuario_2 = '$id_usuario' AND status = 0";

			// Executa SQl no DB
			$retorno3 = $con->query($sql3);

			// Deu erro?
			if ($retorno3 == false){ 
				echo $con->error; 
				
			}

         $registro3 = $retorno3->fetch_array();
		 
		 if($registro3){




echo"	<tr>
			<td>$nome_soli</td>
			<td><img style = 'width:220px; height:auto' src='$foto_soli'></td>
			<td><a style='font-size:24px' href= 'aceitar_solicitacao.php?id_pessoa=$id_pessoa&id_usuario=$id_usuario'  class='fas fa-hand-point-up'></a></td>
			<td><a style='font-size:24px'  href= 'declinar_solicitacao.php?id_pessoa=$id_pessoa&id_usuario=$id_usuario' class='fas fa-hand-point-down'></a></td>
		</tr>";
		 }
		 }
	?>
</table>

<br>
<br>
</div>
<a class="w3-button w3-green w3-border w3-border-Blue w3-round-large" href="post.php">Voltar</a>
</div>
<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
