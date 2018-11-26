<?php

error_reporting(1);
session_start();

// Está logado?
  if ($_SESSION["logado"] == NULL) {
      header("Location: login.php");
  }
  
include_once "topo_comentarios_postagem.php";


$foto_postagem = $_GET["foto_postagem"];
$titulo_postagem = $_GET["titulo_postagem"];
$texto_postagem = $_GET["texto_postagem"];

$id_usuario = $_SESSION["id_usuario"];
$id_postagem = $_GET["id_postagem"];
$id_usuario_postagem = $_GET["id_pessoa"];

$foto = $_SESSION["foto_usuario"];
$nome = $_SESSION["nome_usuario"];

include_once "bd.php";


if ($_POST != NULL) {
	
	$comentario = $_POST["comentario"];
	
    if ($comentario == "") {

        echo "<script> 
                alert('Preencha corretamente!');
              </script>";

    } else {

      // Cria comando SQL
      $sql = "INSERT INTO comentarios (
									id_postagem, 
									id_pessoa, 
									comentario,
									data
									)
              VALUES ( ?,?,?,?)";

      // Prepara query
      $preparacao = $con->prepare($sql);

      // Deu erro?
      if ($preparacao) {

        // Passa os parâmetros para a query
        $preparacao->bind_param("iiss",
								$id_postagem, 
								$id_usuario, 
								$comentario,
								date("Y-m-d H:i:s"));

        // Executa query no BD
        $retorno = $preparacao->execute();
		
	

        // Salvou no BD?
        if ($retorno) {
		
		
		
		

          echo "<script> 
                  alert('Comentado com Sucesso!');
                  location.href = 'comentarios_postagem.php?foto_postagem=$foto_postagem&titulo_postagem=$titulo_postagem&texto_postagem=$texto_postagem&id_postagem=$id_postagem&id_pessoa=$id_usuario';
                </script>";

        // Deu erro..
        } else {

          echo "<script> 
                  alert('Erro ao Comentar!');
                </script>";

          echo $preparacao->error;

        }

      // Erro na query
      } else {
        echo $con->error;
      }

    }





}
include_once "topo_1.php";



include_once "menu.php";
?>





<link href="//netdna.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//netdna.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
<!------ Include the above in your HEAD tag ---------->


<div class="container" style="margin-left:350px">
	<?php
	echo "
	<img src = '$foto_postagem' style = 'width:750px; height:auto'>
	";
	
	echo "

  <div class='row'>
    <div class='col-md-8' style = 'background-color:white' >
    <h1>$titulo_postagem</h1>
    <br>
    <p>$texto_postagem</p>
";

    	?>
      <h2 class="page-header">Comentários</h2>


<section class="comment-list">
<form method="POST">

	<textarea name="comentario" ></textarea>
	<br>
	<input type="submit" name="comentar" value="Comentar">
	<a href = "post.php">  Voltar</a>
</form>

<?php

$sql2 = "SELECT * FROM comentarios c INNER JOIN cadastro ca ON c.id_pessoa = ca.id 
WHERE c.id_postagem = '$id_postagem' ORDER BY c.data ASC";

// Executa SQl no DB
			$retorno2 = $con->query($sql2);

			// Deu erro?
			if ($retorno2 == false){ 
				echo $con->error; 
				
			}

         while($registro2 = $retorno2->fetch_array()){
		 
		 $id_pessoa = $registro2["id_pessoa"];
		 $nome_pessoa = $registro2["nome"];
		 $foto_pessoa = $registro2["foto"];
		 $comentario_pessoa = $registro2["comentario"];
		 $data_comentario = $registro2["data"];
		 
			
			if($registro2){
			
			if($id_usuario == $id_pessoa){
			
			//comentario do dono da postagem
			echo "
			<article class='row'>
            <div class='col-md-10 col-sm-10'>
              <div class='panel panel-default arrow right'>
                <div class='panel-body'>
                  <header class='text-right'>
                    <time class='comment-date'><i class='fa fa-clock-o'></i> $data_comentario</time>
                  </header>
                  <div class ='text-right' class='comment-post'>
                    <p>
                      $comentario_pessoa</p>
                  </div>
                </div>
              </div>
            </div>
            <div class='col-md-2 col-sm-2 hidden-xs'>
              <figure class='thumbnail'>
                <img class='img-responsive' src='$foto_pessoa' />
                <figcaption class='text-center'>$nome_pessoa</figcaption>
              </figure>
            </div>
          </article>
			
			
			";
			
			
			
			}else{
				// comentario de outra pessoa
			echo "
			
			
			
			<article class='row'>
            <div class='col-md-2 col-sm-2 hidden-xs'>
              <figure class='thumbnail'>
                <img class='img-responsive' src='$foto_pessoa' />
                <figcaption class='text-center'>$nome_pessoa</figcaption>
              </figure>
            </div>
            <div class='col-md-10 col-sm-10'>
              <div class='panel panel-default arrow left'>
                <div class='panel-body'>
                  <header class='text-left'>
                    <time class='comment-date'><i class='fa fa-clock-o'></i> $data_comentario </time>
                  </header>
                  <div class='comment-post'>
                    <p>
                      $comentario_pessoa</p>
                  </div>
                </div>
              </div>
            </div>
          </article>
			
			
			
			
			
			";
			}
			}
			
		 }
			
			

?>
       
          </section>
    </div>
  </div>
</div>
<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><a class="w3-button w3-green w3-border w3-border-Blue w3-round-large" href="post.php" >Voltar</a>



</body>
</html>