<?php

    // Não exibe msg de notificação
    error_reporting(1);

	
	//inicia sessao (pode botar la no inicio tbm, embaixo de error_reporting - adicionado para o index
	session_start();
	
	// Está logado?
  if ($_SESSION["logado"] == NULL) {
      header("Location: login.php");
  }
  
	$foto = $_SESSION["foto_usuario"];
	$nome = $_SESSION["nome_usuario"];
	
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

    include_once "topo_1.php";
	
include_once "menu.php"
?>

<h1 style = "text-align:center">Seus Amigos</h1>


<br>
<br>
<div id="bordar" style = "text-align:center">


<br>



<div id="amigos" >
<!--<br><br><br>
 <a class="w3-button w3-blue w3-border w3-border-Blue w3-round-large" href="post.php">Voltar</a>

<br>-->
<table style = "text-align:center">
	

	


<?php



    // percorre todos os registros retornados
    while ($registro = $retorno->fetch_array()) {

    	// obtem campos do registro
    	$id_pessoa = $registro["id"];
    	$nome = $registro["nome"];
    	$login = $registro["login"];
    	$email = $registro["email"];
		$foto = $registro["foto"];


		
			
			$sql2 = "SELECT *
		FROM amigo 
		WHERE id_usuario_1 = '$id_usuario' AND id_usuario_2 = '$id_pessoa' AND status = 1 OR id_usuario_1 = '$id_pessoa' AND id_usuario_2 = '$id_usuario' AND status = 1";

			// Executa SQl no DB
			$retorno2 = $con->query($sql2);

			// Deu erro?
			if ($retorno2 == false){ 
				echo $con->error; 
				
			}

         $registro2 = $retorno2->fetch_array();
		 
		 $status = $registro2["status"];
		
			
			if($registro2){
			
			
			

    	// imprime linha em HTML
    	echo "<tr>
				<td>$nome</td>
				<td><img width='200px' height='200px'  src='$foto'></td>
                <td><a  style='font-size:24px' class='far fa-eye'href='perfil_pessoa.php?id_pessoa=$id_pessoa&foto_pessoa=$foto&nome_pessoa=$nome'></a></td>
               <td><a onclick=\"return confirm('Deseja desfazer amizade?');\" style='font-size:24px' class='fas fa-user-alt-slash' href='desfazer_amizade.php?id_pessoa=$id_pessoa'></a></td>
			</tr> <br>";
			}

    }

?>
	
</table>


</body>
</html>
