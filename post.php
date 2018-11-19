<?php 
include_once "topopost.php"; 

session_start();

// Está logado?
  if ($_SESSION["logado"] == NULL) {
      header("Location: login.php");
  }

  // Obtem ID
$id = $_SESSION["id_usuario"];  

$nome = $_SESSION["nome_usuario"];

// Conecta ao DB
include_once "bd.php";

// Cria comando SQL
$sql = "SELECT *
		FROM perfil 
		WHERE id = '$id'";

// Executa SQl no DB
$retorno = $con->query($sql);

// Deu erro?
if ($retorno == false){ 
	echo $con->error; 
}

$registro = $retorno->fetch_array();

if($registro){
	
$_SESSION["perfil_usuario"] = $registro["perfil"];
$perfil = $registro["perfil"];

} else{
    $perfil = ""; // poderia criar o perfil aqui logo
}



$sql1 = "SELECT *
		FROM cadastro 
		WHERE id = '$id'";

// Executa SQl no DB
$retorno1 = $con->query($sql1);

// Deu erro?
if ($retorno1 == false){ 
	echo $con->error; 
}

$registro1 = $retorno1->fetch_array();

if($registro1){
	
$foto = $registro1["foto"];
$_SESSION["foto_usuario"] = $registro1["foto"];

} else{
    $perfil = ""; // poderia criar o perfil aqui logo
}

?>

<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

<style>
body,h1,h2,h3,h4,h5,h6 {font-family: "Raleway", sans-serif}
</style>
<body class="w3-light-grey w3-content" style="max-width:1600px">


<h1>É um lindo dia para salvar vidas, <?php echo $nome  ?></h1>



<!-- Sidebar/menu -->
<?php include_once "menu.php";?>
  

<!-- Overlay effect when opening sidebar on small screens -->
<div class="w3-overlay w3-hide-large w3-animate-opacity" onclick="w3_close()" style="cursor:pointer" title="close side menu" id="myOverlay"></div>

<!-- !PAGE CONTENT! -->
<div class="w3-main" style="margin-left:300px">

  <!-- Header -->
  <header id="portfolio">
    <a href="#"><img src="/w3images/avatar_g2.jpg" style="width:65px;" class="w3-circle w3-right w3-margin w3-hide-large w3-hover-opacity"></a>
    <span class="w3-button w3-hide-large w3-xxlarge w3-hover-text-grey" onclick="w3_open()"><i class="fa fa-bars"></i></span>
    <div class="w3-container">
    <h1><b>Diagnóstico</b></h1>
   </div>
  </header>
  
  
  <?php
	
	
	$sql2 = "SELECT *, DATE_FORMAT(data,'%d/%m/%Y %H:%i') as data_p
		FROM postagem 
		ORDER BY data desc";
		
		$retorno3 = $con->query($sql2);

		// Deu erro?
		if ($retorno3 == false){ 
			echo $con->error; 
	
		}
		$cont = 1;
		
		echo "<div class='w3-row-padding'>";
		
		while ($registro3 = $retorno3->fetch_array()){ 
			

		if($cont <= 8){
			
			
    	// obtem campos do registro
    	
		$id_postagem = $registro3["id"];
    	$titulo_postagem = $registro3["titulo"];
    	$texto_postagem = $registro3["texto"];
		$foto_postagem = $registro3["foto"];
		$data_postagem = $registro3["data_p"];
		$id_usuario_postagem = $registro3["id_usuario"];
		
			$sql4 = "SELECT *
		FROM cadastro 
		WHERE id = '$id_usuario_postagem'";

		// Executa SQl no DB
		$retorno4 = $con->query($sql4);

		// Deu erro?
		if ($retorno4 == false){ 
			echo $con->error; 
		}

		$registro4 = $retorno4->fetch_array();
		
		$nome_usuario_postagem = $registro4["nome"];
    $foto_usuario_postagem = $registro4["foto"];

		

			$sql5 = "SELECT *
		FROM amigo 
		WHERE id_usuario_1 = '$id' AND id_usuario_2 = '$id_usuario_postagem' 
    OR 
    id_usuario_1 = '$id_usuario_postagem' AND id_usuario_2 = '$id'";

		// Executa SQl no DB
		$retorno5 = $con->query($sql5);

		// Deu erro?
		if ($retorno5 == false){ 
			echo $con->error; 
		}


		$registro5 = $retorno5->fetch_array();

		$status = $registro5["status"];
		
		if($registro5 && $status == 1){
    	// imprime linha em HTML
    	echo "    
					<div class='w3-third w3-container w3-margin-bottom'>
				  <img src='$foto_postagem' alt='Norway' style='width:100% ' class='w3-hover-opacity'>
				  <div class='w3-container w3-white'>
				  <p><b><a href = 'perfil_pessoa.php?id_pessoa=$id_usuario_postagem&foto_pessoa=$foto_usuario_postagem&nome_pessoa=$nome_usuario_postagem'>$nome_usuario_postagem</a></b></p>
					<p><b>$titulo_postagem</b></p>
					<p>$texto_postagem</p>
          
          <p>$data_postagem</p>
          <br>";
		  
		  $sql6 = "SELECT COUNT(id) AS qtd_likes 
				FROM curtir 
				WHERE id_postagem = '$id_postagem'";
				
				$retorno6 = $con->query($sql6);

			// Deu erro?
			if ($retorno6 == false){ 
				echo $con->error; 
				
			}

         $registro6 = $retorno6->fetch_array();
		 
		 $qtd_likes = $registro6["qtd_likes"];
		 
		 
		 
		  echo "
          <a href = 'curtir_postagem.php?id_postagem=$id_postagem'><b><font color='blue'>$qtd_likes curtir</font></b></a>
          <a href = 'comentarios_postagem.php?foto_postagem=$foto_postagem&titulo_postagem=$titulo_postagem&texto_postagem=$texto_postagem&id_postagem=$id_postagem&id_pessoa=$id_usuario_postagem'><b><font color='green'> comentar</font></b></a>
          </div>
				</div>";
			
		 
		$cont = $cont + 1;
		 
		}
    if($registro5 && $status == 3)	{
            // imprime linha em HTML
      echo "    
          <div class='w3-third w3-container w3-margin-bottom'>
          <img src='$foto_postagem' alt='Norway' style='width:100%' class='w3-hover-opacity'>
          <div class='w3-container w3-white'>
          <p><b><a href = 'perfil_pessoa.php?id_pessoa=$id_usuario_postagem&foto_pessoa=$foto_usuario_postagem&nome_pessoa=$nome_usuario_postagem'>$nome_usuario_postagem</a></b></p>
          <p><b>$titulo_postagem</b></p>
          <p>$texto_postagem</p>
          
          <p>$data_postagem</p>
          <br>";
		  
		  
		  $sql6 = "SELECT COUNT(id) AS qtd_likes 
				FROM curtir 
				WHERE id_postagem = '$id_postagem'";
				
				$retorno6 = $con->query($sql6);

			// Deu erro?
			if ($retorno6 == false){ 
				echo $con->error; 
				
			}

         $registro6 = $retorno6->fetch_array();
		 
		 $qtd_likes = $registro6["qtd_likes"];
		 
		 
		 
		  echo "
		  
		  
		  
          <a href = 'curtir_postagem.php?id_postagem=$id_postagem'><b><font color='blue'>$qtd_likes curtir</font></b></a>
          <a href = 'comentarios_postagem.php?foto_postagem=$foto_postagem&titulo_postagem=$titulo_postagem&texto_postagem=$texto_postagem&id_postagem=$id_postagem&id_pessoa=$id_usuario_postagem'><b><font color='green'> comentar</font></b></a>
          <a href = 'excluir_postagem.php'> excluir</a>
          <a href = 'editar_postagem.php'> editar</a>
          
          </div>
        </div>";

    $cont = $cont + 1;
    }	
		}
		} 
	    
		echo "</div>";
  
  ?>
  
 
  <!-- Pagination -->
  <div class="w3-center w3-padding-32">
    <div class="w3-bar">
      <a href="#" class="w3-bar-item w3-button w3-hover-black">«</a>
      <a href="#" class="w3-bar-item w3-black w3-button">1</a>
      <a href="#" class="w3-bar-item w3-button w3-hover-black">2</a>
      <a href="#" class="w3-bar-item w3-button w3-hover-black">3</a>
      <a href="#" class="w3-bar-item w3-button w3-hover-black">4</a>
      <a href="#" class="w3-bar-item w3-button w3-hover-black">»</a>
    </div>
  </div>



  <div class="w3-container w3-padding-large" style="margin-bottom:32px">
    <h4><b>Sobre mim</b></h4>
     <?php echo $perfil; ?>
    <hr>
    
  
  <!-- Contact Section -->
  <div class="w3-container w3-padding-large w3-grey">
    <h4 id="creators"><b>Criadores</b></h4>
    <div class="w3-row-padding w3-center w3-padding-24" style="margin:0 -16px">
      <div class="w3-third w3-dark-grey">
        <p><i class="fa fa-envelope w3-xxlarge w3-text-light-grey"></i></p>
        <p>amandanfsoares@gmail.com</p>
		<p>levi.paganucci@gmail.com</p>
      </div>
      <div class="w3-third w3-teal">
        <p><i class="fa fa-map-marker w3-xxlarge w3-text-light-grey"></i></p>
        <p>Salvador, BA</p>
		<p>Salvador, BA</p>
      </div>
      <div class="w3-third w3-dark-grey">
        <p><i class="fa fa-phone w3-xxlarge w3-text-light-grey"></i></p>
        <p>991922456</p>
        <p>999624185</p>
      </div>
    </div>

  
  <div class="w3-black w3-center w3-padding-24">Feito por <a href="http://andrecosta.info/unifacs/gamifica/usuarios/foto_perfil/512_20180808142933.jpeg" title="W3.CSS" target="_blank" class="w3-hover-opacity">Amanda </a> e <a href="http://andrecosta.info/unifacs/gamifica/usuarios/foto_perfil/515_20180826200751.jpeg" title="W3.CSS" target="_blank" class="w3-hover-opacity">Levi </a></div>

<!-- End page content -->
</div>

<script>
// Script to open and close sidebar
function w3_open() {
    document.getElementById("mySidebar").style.display = "block";
    document.getElementById("myOverlay").style.display = "block";
}
 
function w3_close() {
    document.getElementById("mySidebar").style.display = "none";
    document.getElementById("myOverlay").style.display = "none";
}
</script>






</body>
</html>
