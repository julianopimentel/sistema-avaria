<?php
require 'funcoes/init.php';

	$PDO = db_connect();
	$sql = 'SELECT * FROM empresa';
	$stmt = $PDO->prepare($sql);
	$stmt->execute();
	$empresa = $stmt->fetchAll(PDO::FETCH_OBJ);

	$PDO = db_connect();
	$sql = 'SELECT * FROM login';
	$stmt = $PDO->prepare($sql);
	$stmt->execute();
	$usuario = $stmt->fetchAll(PDO::FETCH_OBJ);

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
							<a href='editar.php?id=<?=$cliente->cod_erp?>' class="btn btn-primary">Editar</a>
							</td>
						</tr>	
					<?php endforeach;?>
				</table>
				<?php else: ?>

				<!-- Mensagem caso não exista clientes ou não encontrado  -->
				<h3 class="text-center text-primary">Não encontrada, contactar o suporte!</h3>
			<?php endif; ?>
		</fieldset>
            </div>

            <div class="tab-pane fade" id="sistema" role="tabpanel" aria-labelledby="list-profile-list">
 			<fieldset>
			<legend><h1>Sistema</h1></legend>
			
			<form action="action_cliente.php" method="post" id="form-contato" enctype="multipart/form-data">

			    <div class="form-group">
			      <label for="status">Envio por E=mail - Relatório</label>
			      <select class="form-control" name="status" id="status">
				    <option value="">Selecione o tempo</option>
				    <option value="nao">Não</option>
				    <option value="dia">Dia</option>
				    <option value="dia">Mês</option>
				    <option value="dia">Ano</option>
				  </select>
				  <span class="msg-erro msg-status"></span>
			    </div>

			    <div class="form-group">
			      <label for="status">Envio por E=mail - Cadastro de Novas Avarias</label>
			      <select class="form-control" name="status" id="status">
				    <option value="">Selecione o Status</option>
				    <option value="Sim">Sim</option>
				    <option value="Nao">Não</option>
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
			<!-- Cabeçalho da Listagem -->
			<legend><h1>Usuários</h1></legend>
				<?php if(!empty($usuario)):?>

				<!-- Tabela de Clientes -->
				<table class="table table-striped">
					<tr class='active'>
						<th>ID</th>
						<th>Nome</th>
						<th>Sobrenome</th>
						<th>E-Mail</th>
						<th>Situação</th>
						<th>Nível</th>
						<th>Ação</th>
					</tr>
					<?php foreach($usuario as $usuario):?>
						<tr>
							<td><?=$usuario->id_login?></td>
							<td><?=$usuario->nome?></td>
							<td><?=$usuario->sobrenome?></td>
							<td><?=$usuario->email?></td>
							<td><?=$usuario->situacao?></td>
							<td><?=$usuario->nivel?></td>
							<td>
							<a href='editar.php?id=<?=$cliente->cod_erp?>' class="btn btn-primary">Editar</a>
							</td>
						</tr>	
					<?php endforeach;?>
				</table>
				<?php else: ?>

				<!-- Mensagem caso não exista clientes ou não encontrado  -->
				<h3 class="text-center text-primary">Não encontrada, contactar o suporte!</h3>
			<?php endif; ?>
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
