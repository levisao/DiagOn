<?php 
include_once "topo.php"; 

// Não exibe msg de notificação
error_reporting(1);

// Clicou em enviar?
if ($_POST != NULL) {

	// Conecta ao BD
	include_once "bd.php";

	// Obtem dados do POST
	$login = addslashes($_POST["login"]);
	$senha = addslashes($_POST["senha"]);

	// Criptografa usando MD5
	$senha = md5($senha);

	// Cria comando SQL
	$sql = "SELECT * 
			FROM cadastro 
			WHERE login = '$login' 
			AND senha = '$senha'";
//echo $sql; exit;
	// Executa comando SQL
	$retorno = $con->query($sql);

	// Erro no SQL?
	if ($retorno == false) {
		echo $retorno->error;
	}

	// Obtem registro no banco
	$registro = $retorno->fetch_array();

	// Encontrou usuário?
	if ($registro) {

		// Inicia a sessão
		session_start();

		// Guarda variáveis na sessão
		$_SESSION["logado"] = true;
		$_SESSION["nome_usuario"] = $registro["nome"];
		$_SESSION["id_usuario"] = $registro["id"];
		
		
		
			

		// Redireciona para a página principal
		header("Location: post.php");

	} else {

		echo "<script>
				alert('Login ou Senha Inválido!');
		     </script>";

	}

}

?>

<div id="inicio">
<h1><b>Login</b></h1>

<form method="post" class="w3-container">
	
	<input type="text" name="login"  class="w3-input" required>
<label>Login</label>
	
	<input type="password" name="senha" class="w3-input" required>
<label>Senha</label>
<br>	<br>
	<button class="w3-button w3-green w3-border w3-border-Blue w3-round-large">Entrar</button>
	<a class="w3-button w3-green w3-border w3-border-Blue w3-round-large" href="iniciar.php">Cancelar</a>
</form>
</div>
</body>
</html>

