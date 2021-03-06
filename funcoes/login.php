<?php
 
// inclui o arquivo de inicialização
require 'init.php';
 
// resgata variáveis do formulário
$email = isset($_POST['email']) ? $_POST['email'] : '';
$password = isset($_POST['password']) ? $_POST['password'] : '';
 
if (empty($email) || empty($password))
{
   header('location: ../index.php?login=error');
   exit;
}
 
// cria o hash da senha
$passwordHash = make_hash($password);
 
$PDO = db_connect();
 
$sql = "SELECT id_login, nome, sobrenome FROM login WHERE email = :email AND senha = :password";
$stmt = $PDO->prepare($sql);
 
$stmt->bindParam(':email', $email);
$stmt->bindParam(':password', $passwordHash);
 
$stmt->execute();
 
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);
 
if (count($users) == 0)
{
   header('location: ../index.php?login=error');
   exit;
}
 
// pega o primeiro usuário
$user = $users[0];
 
session_start();
$_SESSION['logged_in'] = true;
$_SESSION['user_id'] = $user['id_login'];
$_SESSION['user_name'] = $user['nome'];
$_SESSION['user_sobrenome'] = $user['sobrenome'];
 
header('Location: ../home.php');