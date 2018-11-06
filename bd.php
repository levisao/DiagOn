<?php

$host = "localhost";
$usuario = "root";
$senha = "";
$base_dados = "diagon";

// conecta ao BD
$con = new mysqli($host, $usuario, $senha, $base_dados);

// Erro ao conectar?
if ($con->connect_error) {
  echo "Erro ao conectar<br>";
}

?>