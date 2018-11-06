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
		$_SESSION["nome_cadastro"] = $registro["nome"];
		$_SESSION["id_cadastro"] = $registro["id"];

		// Redireciona para a página principal
		header("Location: post.php");

	} else {

		echo "<script>
				alert('Login ou Senha Inválido!');
		     </script>";

	}

}

?>

<h1>Login</h1>

<form method="post">
	<label>Login</label>
	<input type="text" name="login" class="form-control" required>

	<label>Senha</label>
	<input type="password" name="senha" class="form-control" required>

	<br>
	<button class="btn btn-primary" type="submit">Entrar</button>
</form>

