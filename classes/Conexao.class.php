<?php
//CRIANDO A CLASSE DE CONEXAO
class Conexao{
	//ATRIBUTO PRIVADOS
	private $usuario;
	private $senha;
	private $banco;
	private $servidor;
	private static $pdo;
	//CONSTRUTOR
	public function __construct(){		
		$this->servidor = "localhost";
		$this->banco = "u617793640_cocil";
		$this->usuario = "u617793640_acess"; 
		$this->senha = "fHtjYbni84Xs";
	}
	//METODO PARA CONECTAR
	public function conectar(){
		try{
			if(is_null(self::$pdo)){
				self::$pdo = new PDO("mysql:host=".$this->servidor.";dbname=".$this->banco, $this->usuario, $this->senha);
			}
			return self::$pdo;
		}catch(PDOException $e){
			echo 'Error: '.$e->getMessage();
		}
	}
}
?>