<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
	<title>Sistema de Cadastro</title>
	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="css/custom.css">
</head>
<body>
	<div class='container box-mensagem-crud'>
		<?php 
		require 'funcoes/init.php';

		// Atribui uma conexão PDO
		$PDO = db_connect();

		// Recebe os dados enviados pela submissão
		$acao  = (isset($_POST['acao'])) ? $_POST['acao'] : '';


		//fornecedor
		$descricao_fornecedor = (isset($_POST['descricao_fornecedor'])) ? $_POST['descricao_fornecedor'] : '';
		$codigoerp_fornecedor = (isset($_POST['codigoerp_fornecedor'])) ? $_POST['codigoerp_fornecedor'] : '';
		$cnpj_fornecedor = (isset($_POST['cnpj_fornecedor'])) ? $_POST['cnpj_fornecedor'] : '';

		//tipo de avaria
		$descricao_tipoavaria = (isset($_POST['descricao_tipoavaria'])) ? $_POST['descricao_tipoavaria'] : '';

		//estoque
		$descricao_estoque = (isset($_POST['descricao_estoque'])) ? $_POST['descricao_estoque'] : '';

		//status em geral
		$status    		  = (isset($_POST['status'])) ? $_POST['status'] : '';


		//incluir fornecedor
		if ($acao == 'incluir_fornecedor'):


			$sql = 'INSERT INTO fornecedor (codigoerp_fornecedor, cnpj_fornecedor, descricao_fornecedor, situacao_fornecedor)
			VALUES(:codigoerp_fornecedor, :cnpj_fornecedor, :descricao_fornecedor, :status)';

			$stm = $PDO->prepare($sql);
			$stm->bindValue(':codigoerp_fornecedor', $codigoerp_fornecedor);
			$stm->bindValue(':cnpj_fornecedor', $cnpj_fornecedor);
			$stm->bindValue(':descricao_fornecedor', $descricao_fornecedor);
			$stm->bindValue(':status', $status);
			$retorno = $stm->execute();

			if ($retorno):
				echo "<div class='alert alert-success' role='alert'>Registro inserido com sucesso...</div> ";
		    else:
		    	echo "<div class='alert alert-danger' role='alert'>Erro ao inserir registro!</div> ";
			endif;

			echo "<meta http-equiv=refresh content='1;URL=cadastro.php?cadastro=ok'>";
		endif;


				//incluir tipo_avaria
		if ($acao == 'incluir_tipoavaria'):


			$sql = 'INSERT INTO tipo_avaria (descricao_tipoavaria)
							   VALUES(:descricao_tipoavaria)';

			$stm = $PDO->prepare($sql);
			$stm->bindValue(':descricao_tipoavaria', $descricao_tipoavaria);
			$retorno = $stm->execute();

			if ($retorno):
				echo "<div class='alert alert-success' role='alert'>Registro inserido com sucesso...</div> ";
		    else:
		    	echo "<div class='alert alert-danger' role='alert'>Erro ao inserir registro!</div> ";
			endif;

			echo "<meta http-equiv=refresh content='1;URL=cadastro.php?cadastro=ok'>";
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

			echo "<meta http-equiv=refresh content='1;URL=cadastro.php?cadastro=ok'>";
		endif;
		?>

	</div>
</body>
</html>