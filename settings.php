<?php
require 'funcoes/init.php';

	$PDO = db_connect();
	$sql = 'SELECT * FROM empresa';
	$stmt = $PDO->prepare($sql);
	$stmt->execute();
	$empresa = $stmt->fetchAll(PDO::FETCH_OBJ);
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
          <li class="nav-item">
            <a class="nav-link" href="cadastro.php">Cadastro</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="relatorios.php">Relatórios</a>
          </li>
         <li class="nav-item">
            <a class="nav-link" href="relatorios.php">Configurações</a>
          </li>
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
           	
            <div class="tab-pane fade show active" id="empresa" role="tabpanel" aria-labelledby="list-home-list">

			<fieldset>
			<!-- Cabeçalho da Listagem -->
			<legend><h1>Empresa</h1></legend>
				<?php if(!empty($empresa)):?>

				<!-- Tabela de Clientes -->
				<table class="table table-striped">
					<tr class='active'>
						<th>Empresa</th>
						<th>Nome Fantasia</th>
						<th>CNPJ</th>
						<th>Endereço</th>
						<th>Número</th>
						<th>Cidade</th>
						<th>Estado</th>
						<th>Ação</th>
					</tr>
					<?php foreach($empresa as $empresa):?>
						<tr>
							<td><?=$empresa->id_empresa?></td>
							<td><?=$empresa->descricao_empresa?></td>
							<td><?=$empresa->cnpj?></td>
							<td><?=$empresa->endereco_empresa?></td>
							<td><?=$empresa->numero_empresa?></td>
							<td><?=$empresa->cidade_empresa?></td>
							<td><?=$empresa->estado_empresa?></td>
							<td>
								<a href='info.php?id=<?=$cliente->cod_erp?>' class="btn btn-primary">+Info</a>
								<a href='editar.php?id=<?=$cliente->cod_erp?>' class="btn btn-primary">Editar</a>
							</td>
						</tr>	
					<?php endforeach;?>
				</table>
				</fieldset>
            </div>

            <div class="tab-pane fade" id="sistema" role="tabpanel" aria-labelledby="list-profile-list">
 			<fieldset>
			<legend><h1>Sistema</h1></legend>
			
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

            <div class="tab-pane fade" id="usuario" role="tabpanel" aria-labelledby="list-messages-list">
			<fieldset>
			<legend><h1>Usuários</h1></legend>
			
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
            <div class="tab-pane fade" id="permissoes" role="tabpanel" aria-labelledby="list-settings-list">
             
			<legend><h1>Permissões</h1></legend>
			<H1>Página em desenvolvimento</H1>
			
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
