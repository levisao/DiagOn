<?php

    // Não exibe msg de notificação
    error_reporting(1);

	
	//inicia sessao (pode botar la no inicio tbm, embaixo de error_reporting - adicionado para o index
	session_start();
	
	
	$id_pessoa = $_GET["id_pessoa"];
	$nome_pessoa = $_GET["nome_pessoa"];

	
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

echo "

<h1>Amigos de $nome_pessoa</h1>

";

?>

<br>

<!--
<ul class="nav nav-tabs">
  <li class="nav-item">
    <a class="nav-link <?php if ($_GET["status"] == null) echo "active";?>" href="listar.php">Todos</a>
  </li>
  <li class="nav-item">
    <a class="nav-link <?php if ($_GET["status"] == 1) echo "active";?>" href="listar.php?status=1">Aberto</a>
  </li>
  <li class="nav-item">
    <a class="nav-link <?php if ($_GET["status"] == 2) echo "active";?>" href="listar.php?status=2">Em Andamento</a>
  </li>
  <li class="nav-item">
    <a class="nav-link <?php if ($_GET["status"] == 3) echo "active";?>" href="listar.php?status=3">Fechado</a>
  </li>
</ul>
-->
<br>
<a  href="post.php">Voltar</a>

<table border = 1>
	<tr>
		<th>Nome</th>
		
		<th>Foto</th>
        <th style="text-align: center;" colspan="3">Ação</th>
	</tr>
<?php



    // percorre todos os registros retornados
    while ($registro = $retorno->fetch_array()) {

    	// obtem campos do registro
    	$id_outra_pessoa = $registro["id"];
    	$nome_outra_pessoa = $registro["nome"];
    	$login_outra_pessoa = $registro["login"];
    	$email_outra_pessoa = $registro["email"];
		$foto_outra_pessoa = $registro["foto"];


		
		/*
        // CSS do Status
    	if ( $status == "Aberto" ) {
    		$css_status = "background-color:#F0F8FF;";
    	} else if ( $status == "Em Andamento" ) {
    		$css_status = "background-color:orange;";
    	} else if ( $status == "Fechado" ) {
    		$css_status = "background-color:green;";
    	}
*/
			
			
			
			$sql2 = "SELECT *
		FROM amigo 
		WHERE id_usuario_1 = '$id_pessoa' AND id_usuario_2 = '$id_outra_pessoa' AND status = 1 OR id_usuario_1 = '$id_outra_pessoa' AND id_usuario_2 = '$id_pessoa' AND status = 1";

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
				<td>$nome_outra_pessoa</td>
				<td><img src='$foto_outra_pessoa'></td>
                <td><a  href='perfil_pessoa.php?id_pessoa=$id_outra_pessoa&foto_pessoa=$foto_outra_pessoa&nome_pessoa=$nome_outra_pessoa'>Visualizar Perfil</a></td>
                <td><a class='btn btn-warning' href='post.php'>Deixar de Seguir</a></td>   
                <td><a onclick=\"return confirm('Deseja Apagar?');\" class='btn btn-danger' href='logoff.php'>Sair</a></td>
			</tr>";
			}
    }
// href='post.php?id=$id'

?>
	
</table>


<br>


</table>

</body>
</html>
