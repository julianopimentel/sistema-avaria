<?php
require 'funcoes/init.php';

	$PDO = db_connect();
	$sql = 'SELECT * FROM avaria
			INNER JOIN produto ON avaria.cod_produto = produto.codigo_erp
			INNER JOIN tipo_avaria ON avaria.cod_tipoavaria = tipo_avaria.id_tipoavaria
			INNER JOIN empresa ON avaria.cod_empresa = empresa.id_empresa
			INNER JOIN estoque ON avaria.cod_estoque = estoque.id_estoque
			INNER JOIN situacao_avaria ON avaria.cod_situacao = situacao_avaria.id_situacao
			INNER JOIN login ON avaria.cadastro_avaria_cod = login.id_login WHERE 
			codigo_erp LIKE :codigo_erp OR 
			descricao_produto LIKE :descricao_produto OR 
			descricao_estoque LIKE :descricao_estoque OR 
			descricao_empresa LIKE :descricao_empresa OR
			descricao_situacao LIKE :descricao_situacao OR
			nome LIKE :nome OR 
			descricao_tipoavaria LIKE :descricao_tipoavaria';
	$stm = $PDO->prepare($sql);
	$stm->execute();
	$clientes = $stm->fetchAll(PDO::FETCH_OBJ);
?>


<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="icon/favicon.ico">

    <title>Configurações  - Sistema de Avaria</title>

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/offcanvas.css" rel="stylesheet">
  </head>

  <body class="bg-light">

    <nav class="navbar navbar-expand-lg fixed-top navbar-dark bg-dark">
      <a class="navbar-brand mr-auto mr-lg-0" href="#">DeskApps</a>
      <button class="navbar-toggler p-0 border-0" type="button" data-toggle="offcanvas">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="navbar-collapse offcanvas-collapse" id="navbarsExampleDefault">
        <ul class="navbar-nav mr-auto">
          <li class="nav-item">
            <a class="nav-link" href="index.php">Dashboard</a>
          </li>
		<li class="nav-item">
            <a class="nav-link" href="avaria.php">Avarias</a>
          </li>
          <li class="nav-item active">
            <a class="nav-link" href="cadastro.php">Cadastro<span class="sr-only">(current)</span></a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="relatorios.php">Relatórios</a>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="https://example.com" id="dropdown01" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Settings</a>
            <div class="dropdown-menu" aria-labelledby="dropdown01">
              <a class="dropdown-item" href="settings.php">Empresa</a>
              <a class="dropdown-item" href="settings.php">Sistema</a>
              <a class="dropdown-item" href="settings.php">Usuários</a>
              <a class="dropdown-item" href="settings.php">Permissões</a>
            </div>
          </li>
            <li class="nav-item">
            <a class="nav-link" href="funcao/logout.php">Sair</a>
          </li>
        </ul>
      </div>
    </nav>

    <div class="nav-scroller bg-white shadow-sm">
      <nav class="nav nav-underline">
        <a class="nav-link active" href="index.php">Dashboard</a>
        <a class="nav-link" data-toggle="tab" href="#empresa" role="empresa">Empresa</a>
        <a class="nav-link" data-toggle="tab" href="#sistema" role="sistema">Sistema</a>
        <a class="nav-link" data-toggle="tab" href="#usuario" role="usuario">Usuários</a>
        <a class="nav-link" data-toggle="tab" href="#permissoes" role="permissoes">Permissões</a>
      </nav>
    </div>

    <main role="main" class="container">
      <div class="my-5 p-5 bg-white rounded shadow-sm">
       <div class="col">
          <div class="tab-content" id="nav-tabContent">
           	
            <div class="tab-pane fade show active" id="produto" role="tabpanel" aria-labelledby="list-home-list">

		<fieldset>

			<!-- Cabeçalho da Listagem -->
			<legend><h1>Empresas</h1></legend>
				<?php if(!empty($clientes)):?>

				<!-- Tabela de Clientes -->
				<table class="table table-striped">
					<tr class='active'>
						<th>Código ERP</th>
						<th>Descrição</th>
						<th>Código de Barra</th>
						<th>Situação</th>
						<th>Cadastro</th>
						<th>Local</th>
						<th>Tipo</th>
						<th>Data</th>
						<th>Ação</th>
					</tr>
					<?php foreach($clientes as $cliente):?>
						<tr>
							<td><?=$cliente->codigo_erp?></td>
							<td><?=$cliente->descricao_produto?></td>
							<td><?=$cliente->codigobarra?></td>
							<td><?=$cliente->descricao_situacao?></td>
							<td><?=$cliente->nome?></td>
							<td><?=$cliente->descricao_estoque?></td>
							<td><?=$cliente->descricao_tipoavaria?></td>
							<td><?=$cliente->cadastro_avaria_date?></td>
							<td>
								<a href='info.php?id=<?=$cliente->cod_erp?>' class="btn btn-primary">+Info</a>
								<a href='editar.php?id=<?=$cliente->cod_erp?>' class="btn btn-primary">Editar</a>
							</td>
						</tr>	
					<?php endforeach;?>
				</table>

			<?php else: ?>

				<!-- Mensagem caso não exista clientes ou não encontrado  -->
				<h3 class="text-center text-primary">Avaria não encontrada, tente novamente!</h3>
			<?php endif; ?>
		</fieldset>


            </div>

            <div class="tab-pane fade" id="fornecedor" role="tabpanel" aria-labelledby="list-profile-list">
 			<fieldset>
			<legend><h1>Cadastro de Fornecedores</h1></legend>
			
			<form action="action_cliente.php" method="post" id="form-contato" enctype="multipart/form-data">

			    <div class="form-group">
			      <label for="nome">Fornecedor</label>
			      <input type="text" class="form-control" id="descricao_fornecedor" name="descricao_fornecedor" placeholder="Infome o Fornecedor.">
			      <span class="msg-erro msg-nome"></span>
			    </div>

			    <div class="form-group">
			      <label for="status">Status</label>
			      <select class="form-control" name="status" id="status">
				    <option value="">Selecione o Status</option>
				    <option value="Ativo">Ativo</option>
				    <option value="Inativo">Inativo</option>
				  </select>
				  <span class="msg-erro msg-status"></span>
			    </div>

			    <input type="hidden" name="acao" value="incluir_fornecedor">
			    <button type="submit" class="btn btn-primary" id="botao"> 
			      Gravar
			    </button>
			</form>
		</fieldset>
            </div>
            <div class="tab-pane fade" id="tipoavaria" role="tabpanel" aria-labelledby="list-messages-list">
			<fieldset>
			<legend><h1>Cadastro de Tipos de Avarias</h1></legend>
			
			<form action="action_cliente.php" method="post" id="form-contato" enctype="multipart/form-data">

			    <div class="form-group">
			      <label for="nome">Tipos de Avaria</label>
			      <input type="text" class="form-control" id="descricao_tipoavaria" name="descricao_tipoavaria" placeholder="Infome o novo tipo de Avaria.">
			      <span class="msg-erro msg-nome"></span>
			    </div>

			    <input type="hidden" name="acao" value="incluir_tipoavaria">
			    <button type="submit" class="btn btn-primary" id="botao"> 
			      Gravar
			    </button>
			</form>
		</fieldset>
            </div>
            <div class="tab-pane fade" id="estoque" role="tabpanel" aria-labelledby="list-settings-list">
              <fieldset>
			<legend><h1>Cadastro de Estoques</h1></legend>
			
			<form action="action_cliente.php" method="post" id="form-contato" enctype="multipart/form-data">

			    <div class="form-group">
			      <label for="nome">Local de Estoque</label>
			      <input type="text" class="form-control" id="descricao_estoque" name="descricao_estoque" placeholder="Infome o novo Local de Estoque.">
			      <span class="msg-erro msg-nome"></span>
			    </div>

			    <div class="form-group">
			      <label for="status">Status</label>
			      <select class="form-control" name="status" id="status">
				    <option value="">Selecione o Status</option>
				    <option value="Ativo">Ativo</option>
				    <option value="Inativo">Inativo</option>
				  </select>
				  <span class="msg-erro msg-status"></span>
			    </div>

			    <input type="hidden" name="acao" value="incluir_estoque">
			    <button type="submit" class="btn btn-primary" id="botao"> 
			      Gravar
			    </button>
			</form>
			</fieldset>
            </div>
            </div>
          </div>
        </div>
        </div>
      </div>
    </main>

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script>window.jQuery || document.write('<script src="../../assets/js/vendor/jquery-slim.min.js"><\/script>')</script>
    <script src="js/vendor/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/vendor/holder.min.js"></script>
    <script src="js/offcanvas.js"></script>
  </body>
</html>
