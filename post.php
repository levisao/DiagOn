<?php 
include_once "topo.php"; 

session_start();

// Está logado?
  if ($_SESSION["logado"] == NULL) {
      header("Location: login.php");
  }


$nome = $_SESSION["nome_usuario"];


?>


<h1>Olá, <?php echo $nome  ?></h1>

</body>
</html>
