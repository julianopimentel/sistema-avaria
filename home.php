<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="icon/favicon.ico">

    <title>Dashboard  - Sistema de Avaria</title>

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
        <form class="form-inline my-2 my-lg-0">
          <input class="form-control mr-sm-2" type="text" placeholder="Search" aria-label="Search">
          <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
        </form>
      </div>
    </nav>

    <div class="nav-scroller bg-white shadow-sm">
      <nav class="nav nav-underline">
        <a class="nav-link active" href="index.php">Dashboard</a>
        <a class="nav-link" data-toggle="tab" href="#produto" role="produto">Produto</a>
        <a class="nav-link" data-toggle="tab" href="#fornecedor" role="fornecedor">Fornecedor</a>
        <a class="nav-link" data-toggle="tab" href="#tipoavaria" role="tipoavaria">Tipo de Avaria</a>
        <a class="nav-link" data-toggle="tab" href="#estoque" role="estoque">Estoque</a>
      </nav>
    </div>

    <main role="main" class="container">
      <div class="my-3 p-3 bg-white rounded shadow-sm">
       <div class="col">
          <div class="tab-content" id="nav-tabContent">
           	
            <div class="tab-pane fade show active" id="produto" role="tabpanel" aria-labelledby="list-home-list">
			<fieldset>
			<legend><h1>Cadastro de Produtos</h1></legend>
			
			<form action="action_cliente.php" method="post" id="form-contato" enctype="multipart/form-data">
				<div class="row">
					<label for="nome">Selecionar Foto</label>
			      	<div class="col-md-2">
					    <a href="#" class="thumbnail">
					      <img src="img/padrao.jpg" height="190" width="150" id="foto-cliente">
					    </a>
				  	</div>
				  	<input type="file" name="foto" id="foto" value="foto" >
			  	</div>

			    <div class="form-group">
			      <label for="nome">Descrição do produto</label>
			      <input type="text" class="form-control" id="maquina" name="maquina" placeholder="Infome a descrição do produto">
			      <span class="msg-erro msg-nome"></span>
			    </div>
			    <div class="form-group">
			      <label for="modelo">Código ERP</label>
			      <input type="modelo" class="form-control" id="modelo" name="modelo" placeholder="Informe o código do seu ERP">
			      <span class="msg-erro msg-modelo"></span>
			    </div>
			      <div class="form-group">
			      <label for="modelo">Código Fornecedor (Opcional)</label>
			      <input type="modelo" class="form-control" id="modelo" name="modelo" placeholder="Informe o código do Fornecedor">
			      <span class="msg-erro msg-modelo"></span>
			    </div>
			    <div class="form-group">
			      <label for="ip">Fornecedor (Opcional)</label>
			      <input type="ip" class="form-control" id="ip" maxlength="20" name="ip" placeholder="Informe o Forecedor">
			      <span class="msg-erro msg-ip"></span>
			    </div>
			    <div class="form-group">
			      <label for="status">Situação (Opcional)</label>
			      <select class="form-control" name="status" id="status">
				    <option value="">Selecione o Status</option>
				    <option value="Ativo">Ativo</option>
				    <option value="Inativo">Inativo</option>
				  </select>
			    </div>
			    <input type="hidden" name="acao" value="incluir">
			    <button type="submit" class="btn btn-primary" id="botao">Gravar</button>
			</form>
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
