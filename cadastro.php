
	
	<?php
	include_once "topo_2.php"; 

  // Não exibe msg de notificação
  error_reporting(1);

  // Inicia a sessão
  session_start();

  /*Está logado?
  if ($_SESSION["logado"] == NULL) {
      header("Location: ../index.php");
  }*/

  // Clicou em salvar?
  if ($_POST != NULL) {

    // conecta ao BD
    include_once "bd.php";

    // Obtém dados do POST
    $nome = $_POST["nome"];
    $email = $_POST["email"];
    $login = $_POST["login"];
	$senha = $_POST["senha"];
	$foto = "http://www.amigoviajante.com.br/img/usuario-sem-foto.png";
	$_SESSION["foto_usuario"] = $foto;
	
	$_SESSION["login_cadastro"] = $login;
	$_SESSION["senha_cadastro"] = md5($senha);
	
	
    // Valida campos obrigatórios
    if ($login == "" || $senha == "") {

        echo "<script> 
                alert('Preencha corretamente!');
              </script>";

    } else {

      // Cria comando SQL
      $sql = "INSERT INTO cadastro (
									nome, 
									email, 
									login,
									senha,
									foto
									)
              VALUES ( ?,?,?,?,?)";

      // Prepara query
      $preparacao = $con->prepare($sql);

      // Deu erro?
      if ($preparacao) {

        // Passa os parâmetros para a query
        $preparacao->bind_param("sssss",
								$nome, 
								$email, 
								$login,
								md5($senha),
								$foto);

        // Executa query no BD
        $retorno = $preparacao->execute();
		
	

        // Salvou no BD?
        if ($retorno) {
		
		
		
		

          echo "<script> 
                  alert('Cadastrado com Sucesso!');
                  location.href = 'add_table_amigo_usuario.php';
                </script>";

        // Deu erro..
        } else {

          echo "<script> 
                  alert('Erro ao Cadastrar!');
                </script>";

          echo $preparacao->error;

        }

      // Erro na query
      } else {
        echo $con->error;
      }

    }

  }

?>

<div id="cadastro">
<h1>Cadastro de usuário</h1>
<form method="post" class="w3-container">
  <label>Nome</label>
  <input class="w3-input" type="text" name="nome" maxlength="100" required>
  
 <label>Login</label>
  <input class="w3-input" type="text" name="login" maxlength="100" required>
   
  <label>Email</label>
  <input type="email" name="email" class="w3-input">

  <label>Senha</label>
   <input class="w3-input" type="password" name="senha" maxlength="100" required>
<br><br>
  <a class="w3-button w3-blue w3-border w3-border-Blue w3-round-large" href="iniciar.php">Cancelar</a>
  <button class="w3-button w3-blue w3-border w3-border-Blue w3-round-large">Salvar</button>
</form>
</div>


	</body>
</html>

