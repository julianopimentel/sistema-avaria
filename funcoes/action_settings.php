<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
	<title>Sistema de Cadastro</title>
	<link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="../css/custom.css">
</head>
<body>
	<div class='container box-mensagem-crud'>
		<?php 
		require 'init.php';

		// Atribui uma conexão PDO
		$PDO = db_connect();

		// Recebe os dados enviados pela submissão
		$acao  = (isset($_POST['acao'])) ? $_POST['acao'] : '';

		//usuario
		$nome = (isset($_POST['nome'])) ? $_POST['nome'] : '';
		$sobrenome = (isset($_POST['sobrenome'])) ? $_POST['sobrenome'] : '';
		$email = (isset($_POST['email'])) ? $_POST['email'] : '';
		$senha = (isset($_POST['senha'])) ? $_POST['senha'] : '';
		$nivel = (isset($_POST['nivel'])) ? $_POST['nivel'] : '';

		//tipo de avaria
		$descricao_tipoavaria = (isset($_POST['descricao_tipoavaria'])) ? $_POST['descricao_tipoavaria'] : '';

		//estoque
		$descricao_estoque = (isset($_POST['descricao_estoque'])) ? $_POST['descricao_estoque'] : '';

		//status em geral
		$status    		  = (isset($_POST['status'])) ? $_POST['status'] : '';


		//incluir fornecedor
		if ($acao == 'incluir_usuario'):


			$sql = 'INSERT INTO login (nome, sobrenome, email, senha, nivel, situacao)
			VALUES(:nome, :sobrenome, :email, :senha, :nivel, :status)';

			// cria o hash da senha
			$passwordHash = make_hash($senha);

			$stm = $PDO->prepare($sql);
			$stm->bindValue(':nome', $nome);
			$stm->bindValue(':sobrenome', $sobrenome);
			$stm->bindValue(':email', $email);
			$stm->bindValue(':senha', $passwordHash);
			$stm->bindValue(':nivel', $nivel);
			$stm->bindValue(':status', $status);
			$retorno = $stm->execute();

			if ($retorno):
				echo "<div class='alert alert-success' role='alert'>Registro inserido com sucesso...</div> ";
		    else:
		    	echo "<div class='alert alert-danger' role='alert'>Erro ao inserir registro!</div> ";
			endif;

			echo "<meta http-equiv=refresh content='1;URL=../settings.php?cadastro=ok'>";
		endif;


				//incluir tipo_avaria
		if ($acao == 'incluir_tipoavaria'):


			$sql = 'INSERT INTO tipo_avaria (descricao_tipoavaria, situacao_tipoavaria)
							   VALUES(:descricao_tipoavaria, :status)';

			$stm = $PDO->prepare($sql);
			$stm->bindValue(':descricao_tipoavaria', $descricao_tipoavaria);
			$stm->bindValue(':status', $status);
			$retorno = $stm->execute();

			if ($retorno):
				echo "<div class='alert alert-success' role='alert'>Registro inserido com sucesso...</div> ";
		    else:
		    	echo "<div class='alert alert-danger' role='alert'>Erro ao inserir registro!</div> ";
			endif;

			echo "<meta http-equiv=refresh content='1;URL=../settings.php?cadastro=ok'>";
		endif;
		


				//incluir estoque
		if ($acao == 'incluir_estoque'):

			$sql = 'INSERT INTO estoque (descricao_estoque, situacao_estoque)
							   VALUES(:descricao_estoque, :status)';

			$stm = $PDO->prepare($sql);
			$stm->bindValue(':descricao_estoque', $descricao_estoque);
			$stm->bindValue(':status', $status);
			$retorno = $stm->execute();

			if ($retorno):
				echo "<div class='alert alert-success' role='alert'>Registro inserido com sucesso...</div> ";
		    else:
		    	echo "<div class='alert alert-danger' role='alert'>Erro ao inserir registro!</div> ";
			endif;

			echo "<meta http-equiv=refresh content='1;URL=../settings.php?cadastro=ok'>";
		endif;
		?>

	</div>
</body>
</html>