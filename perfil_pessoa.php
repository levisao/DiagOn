<?php 
include_once "topopost.php"; 

session_start();

// Está logado?
  if ($_SESSION["logado"] == NULL) {
      header("Location: login.php");
  }

  // Obtem ID
//$id = $_SESSION["id_usuario"];  

$nome_pessoa = $_GET["nome_pessoa"];

$foto_pessoa = $_GET["foto_pessoa"];

$id_pessoa = $_GET["id_pessoa"];


// Conecta ao DB
include_once "bd.php";

// Cria comando SQL
$sql = "SELECT *
		FROM perfil 
		WHERE id = '$id_pessoa'";

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
		WHERE id = '$id_pessoa'";

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

<h1>Este é o perfil de <?php echo $nome_pessoa  ?></h1>



<!-- Sidebar/menu -->
<nav class="w3-sidebar w3-collapse w3-white w3-animate-left" style="z-index:3;width:300px;" id="mySidebar"><br>
  <div class="w3-container">
    <a href="#" onclick="w3_close()" class="w3-hide-large w3-right w3-jumbo w3-padding w3-hover-grey" title="close menu">
      <i class="fa fa-remove"></i>
    </a>
    <img src= <?php echo $foto_pessoa ?> style="width:80%;" class="w3-round"><br><br>
	<h4><b><?php echo $nome_pessoa ?></b></h4>
	
  





<?php
echo"
    <a  style='font-size:24px' class='far' href='amigos_pessoa.php?id_pessoa=$id_pessoa&nome_pessoa=$nome_pessoa&foto_pessoa=$foto_pessoa'><i class='fas fa-user-friends'></i></a> Amigos
    ";
    ?>
	<br><br><a  style='font-size:24px' class='far' href="buscar.php" ><i class='fas fa-search'></i></a> Buscar
  <br><br><a  style='font-size:24px' class='far' href="post.php" ><i class="fas fa-home"></i></a> Voltar 
</nav> 

<!-- Overlay effect when opening sidebar on small screens -->
<div class="w3-overlay w3-hide-large w3-animate-opacity" onclick="w3_close()" style="cursor:pointer" title="close side menu" id="myOverlay"></div>

<!-- !PAGE CONTENT! -->
<div class="w3-main" style="margin-left:300px">

  <!-- Header -->
  <header id="portfolio">
    <a href="#"><img src="/w3images/avatar_g2.jpg" style="width:65px;" class="w3-circle w3-right w3-margin w3-hide-large w3-hover-opacity"></a>
    <span class="w3-button w3-hide-large w3-xxlarge w3-hover-text-grey" onclick="w3_open()"><i class="fa fa-bars"></i></span>
    <div class="w3-container">
    
    </div>
  </header>
  



  <!-- Images of Me -->
  <div class="w3-row-padding w3-padding-16" id="about">
    <div class="w3-col m6">
    </div>
    <div class="w3-col m6">
    </div>
<div class="w3-col m6">
    <h2><b>Sobre mim</b></h2>
     <?php echo $perfil; ?>
    <hr>
    </div>
  </div>






  
  <?php
	
	$id_pessoa = $_GET["id_pessoa"];

	$sql2 = "SELECT *, DATE_FORMAT(data,'%d/%m/%Y %H:%i') as data_p
		FROM postagem 
    WHERE id_usuario = $id_pessoa
		ORDER BY data desc";
		
		$retorno3 = $con->query($sql2);

		// Deu erro?
		if ($retorno3 == false){ 
			echo $con->error; 
	
		}
		$cont = 1;
		
		echo "<div class='w3-row-padding'>";

    echo "<div class='w3-section w3-bottombar w3-padding-16'>
    <h2><b>Postagens</b></h2>
     
    <hr>
    </div>";
		
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
		

		

		if($registro3){
    	// imprime linha em HTML
    	echo "    
					<div class='w3-third w3-container w3-margin-bottom'>


				  <img src='$foto_postagem' alt='Norway' style='width:100%' class='w3-hover-opacity'>
				  <div class='w3-container w3-white'>
				  <p><b><a href = 'perfil_amigo.php'>$nome_usuario_postagem</a></b></p>
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
   
    <div class="w3-third">
      
    </div>

  </div>
  </footer>
  

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