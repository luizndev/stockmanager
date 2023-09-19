<?php
$host = "127.0.0.1"; 
$usuario = "root"; 
$senha = ""; 
$banco = "teste"; 

$conexao = mysqli_connect($host, $usuario, $senha, $banco);

if (!$conexao) {
    die("Erro na conexão com o banco de dados: " . mysqli_connect_error());
}
?>
