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

    /*if ($_GET["status"] == 1) {
        $filtro = "WHERE status = 'Aberto'";
    } else if ($_GET["status"] == 2) {
        $filtro = "WHERE status = 'Em Andamento'";
    } else if ($_GET["status"] == 3) {
        $filtro = "WHERE status = 'Fechado'";
    }
*/

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

<h1>Seus Amigos</h1>

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
    	$id_pessoa = $registro["id"];
    	$nome = $registro["nome"];
    	$login = $registro["login"];
    	$email = $registro["email"];
		$foto = $registro["foto"];

		
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
				<td><img src='$foto'></td>
                <td><a  href='post.php'>Visualizar Perfil</a></td>
                <td><a class='btn btn-warning' href='post.php'>Deixar de Seguir</a></td>   
                <td><a onclick=\"return confirm('Deseja Apagar?');\" class='btn btn-danger' href='logoff.php'>Sair</a></td>
			</tr>";
			}
    }
// href='post.php?id=$id'

?>
	
</table>


<br>
<br>

<h2>Solicitações de Amizade</h2>
<table border = 1>


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
		WHERE id_usuario_1 = '$id_usuario' AND id_usuario_2 = '$id_pessoa' AND status = 0 OR id_usuario_1 = '$id_pessoa' AND id_usuario_2 = '$id_usuario' AND status = 0";

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
			<td><img src='$foto_soli'></td>
			<td><a href= 'post.php'>Aceitar</a></td>
			<td><a href= 'post.php'>Declinar</a></td>
		</tr>";
		 }
		 }
	?>

</table>

</body>
</html>
