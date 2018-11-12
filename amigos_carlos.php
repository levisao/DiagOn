<?php

    // Não exibe msg de notificação
    error_reporting(1);

	
	//inicia sessao (pode botar la no inicio tbm, embaixo de error_reporting - adicionado para o index
	session_start();
	
	// Está logado?     - adicionado para o index
	if($_SESSION["logado"] == NULL){
		
		header("Location: ../index.php");
		
	}
			
    // conecta ao BD
    include_once "../bd.php";

    if ($_GET["status"] == 1) {
        $filtro = "WHERE status = 'Aberto'";
    } else if ($_GET["status"] == 2) {
        $filtro = "WHERE status = 'Em Andamento'";
    } else if ($_GET["status"] == 3) {
        $filtro = "WHERE status = 'Fechado'";
    }

    // Cria comando SQL
    $sql = "SELECT *, DATE_FORMAT(data_chamado, '%d/%m/%Y') AS data_chamado
            FROM chamado 
            $filtro
            ORDER BY id DESC";

    // Executa a query no BD
    $retorno = $con->query($sql);

    // Deu erro no SQL?
    if ($retorno == false) {
        echo $con->error;
    }

    include_once "../topo.php";
?>

<h1>Seus Amigos</h1>

<br>


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

<br>
<a class="btn btn-danger" href="../sair.php">Logoff</a>
<a class="btn btn-success" href="cadastrar.php">Abrir Chamado</a>
<br>
<br>

<table class="table table-bordered table-striped">
	<tr>
		<th>ID</th>
		<th>Data</th>
		<th>Nome</th>
		<th>Status</th>
        <th style="text-align: center;" colspan="3">Ação</th>
	</tr>
<?php
    // percorre todos os registros retornados
    while ($registro = $retorno->fetch_array()) {

    	// obtem campos do registro
    	$id = $registro["id"];
    	$data_chamado = $registro["data_chamado"];
    	$solicitante = $registro["solicitante"];
    	$status = $registro["status"];

        // CSS do Status
    	if ( $status == "Aberto" ) {
    		$css_status = "background-color:#F0F8FF;";
    	} else if ( $status == "Em Andamento" ) {
    		$css_status = "background-color:orange;";
    	} else if ( $status == "Fechado" ) {
    		$css_status = "background-color:green;";
    	}

    	// imprime linha em HTML
    	echo "<tr>
				<td>$id</td>
				<td>$data_chamado</td>
				<td>$solicitante</td>
				<td style='$css_status'>$status</td>
                <td><a class='btn btn-info' href='ver.php?id=$id'><i class='far fa-eye'></i></a></td>
                <td><a class='btn btn-warning' href='editar.php?id=$id'><i class='far fa-edit'></i></a></td>
                <td><a onclick=\"return confirm('Deseja Apagar?');\" class='btn btn-danger' href='apagar.php?id=$id'><i class='far fa-trash-alt'></i></a></td>
			</tr>";
    }


?>
	
</table>

<?php include_once "../rodape.php"; ?>