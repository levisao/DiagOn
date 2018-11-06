

<?php

	//não exibe mensagem de alerta
	error_reporting(1);

?>

<!doctype html>
<html lang="pt-br">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

    <title>Sistema de Cadastro</title>
  </head>
  <body>
    
	
	<div class="container">

<h1>Listar Chamados</h1>




 
</ul>

<br>
<a class="btn btn-success" href="cadastrar.php">Abrir Tela de Cadastro</a>
<br>
<br>

<table class="table table-bordered table-striped">
	
	<tr>
		<th>ID</th>
		<th>Nome</th>
		<th>Ações</th>

	</tr>
	
	<?php

	
	
	//conecta no BD
			$con = new mysqli("localhost", "andrecos_unifacs", "unifacs123", "andrecos_unifacs"); //onde está, o usuario, senha e o sistema, botar as informaçoes q ele der aqui
			
//Deu erro na conexão
			if($con->connection_error){   // -> igual ao . no java
				
			echo"Erro ao conectar!<br>";
			}
			
			$id = $_GET['id'];
			if($id != NULL){		
			
			
			
			
			$sql = "DELETE FROM aluno where id=".$id;
				
			$retorno = $con->query($sql);
			if($retorno == true){
				echo "<script>
						alert('Usuário excluído com sucesso')
						location.href = 'apagar.php';
					</script>";
					}
			}
			
			if($_GET["rb1_sexo"] == 1){
				$filtro = "WHERE sexo = 'Masculino' or sexo = 'M'";
			} else if($_GET["rb1_sexo"] == 2){
				$filtro = "WHERE sexo = 'Feminino' or sexo = 'F'";
			}
			
			// Cria comando SQL
			$sql = "SELECT * FROM aluno $filtro ORDER BY id DESC";
			
			// executa a query no BD
			$retorno = $con->query($sql);
			
			if($retorno == false){  // mesma coisa de !$retorno
				echo $con->error;				
			}
			
			// percorre todos os registros retornados 
			while ($registro = $retorno->fetch_array()){
				
				//obtém campos do registro
				$id = $registro["id"];
				$nome_aluno = $registro["nome"];
		
				
			
				
				
				
				
				echo "
				<tr>
					<td>$id</td>
					<td>$nome_aluno</td>
					<td><a onclick='return confirm(\"Deseja apagar mesmo??\");' href = 'apagar.php?id=$id'>Apagar</a></td>
				</tr>
				";
				
			}
?>

	

</table>

			
			
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
  </body>
</html>