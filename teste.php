<?php
require "conexao.php";

$nome = 'admin teste';
$email = 'admin@admin.com';
$senha = password_hash('teste', PASSWORD_DEFAULT);


$conexao = conexao::getInstance();
$sql = "INSERT INTO tab_usuario(nome, email, senha, status)VALUES('{$nome}', '{$email}', '{$senha}', 'Ativo')";
$stm = $conexao->prepare($sql);
$stm->execute();