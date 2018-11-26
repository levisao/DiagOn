<?php
session_start();

// Está logado?
  if ($_SESSION["logado"] == NULL) {
      header("Location: login.php");
  }

  

include_once "topo_1.php";


$foto = $_SESSION["foto_usuario"];
$nome = $_SESSION["nome_usuario"];

include_once "menu.php";

$id_postagem = $_GET["id_postagem"];
$id_usuario_postagem = $_GET["id_pessoa"];


include_once "bd.php";


$sql = "SELECT * FROM curtir WHERE id_postagem = '$id_postagem'";

		$retorno = $con->query($sql);

			// Deu erro?
			if ($retorno == false){ 
				echo $con->error; 
				
			}
			
?>
		
		<div id = "amigos">
		<h1>Pessoas que curtiram</h1>
		<br>
		
		 <table>
		 
<?php
		 while($registro = $retorno->fetch_array()){
					
			$id_pessoa = $registro["id_autor"];

$sql1 = "SELECT * FROM cadastro WHERE id = '$id_pessoa'";

		$retorno1 = $con->query($sql1);

			// Deu erro?
			if ($retorno1 == false){ 
				echo $con->error; 
				
			}
			
			$registro1 = $retorno1->fetch_array();
			
			$foto_pessoa = $registro1["foto"];
			$nome_pessoa = $registro1["nome"];
			
			echo"
			<tr>
			<td>$nome_pessoa</td>
			<td><img width='200px' height='200px'src = '$foto_pessoa'</td>
			</tr>
			";
						 
		 }

		 

?>
</div>
</table>
</body>
</html>
