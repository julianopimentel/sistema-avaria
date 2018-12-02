<?php
session_start();
 
require_once 'funcoes/init.php';
require 'funcoes/check.php';


 /* Constantes de configuração */  
 define('QTDE_REGISTROS', 5);   
 define('RANGE_PAGINAS', 1);   
   
 /* Recebe o número da página via parâmetro na URL */  
 $pagina_atual = (isset($_GET['page']) && is_numeric($_GET['page'])) ? $_GET['page'] : 1;   
   
 /* Calcula a linha inicial da consulta */  
 $linha_inicial = ($pagina_atual -1) * QTDE_REGISTROS;  

	 /* Conta quantos registos existem na tabela */  

	$PDO = db_connect();
	$sqlContador = "SELECT COUNT(*) AS total_registros FROM avaria";   
 	$stmt = $PDO->prepare($sqlContador);   
 	$stmt->execute();   
 	$valor = $stmt->fetch(PDO::FETCH_OBJ); 

 	/* Idêntifica a primeira página */  
 $primeira_pagina = 1;   
   
 /* Cálcula qual será a última página */  
 $ultima_pagina  = ceil($valor->total_registros / QTDE_REGISTROS);   
   
 /* Cálcula qual será a página anterior em relação a página atual em exibição */   
 $pagina_anterior = ($pagina_atual > 1) ? $pagina_atual -1 : 0 ;   
   
 /* Cálcula qual será a pŕoxima página em relação a página atual em exibição */   
 $proxima_pagina = ($pagina_atual < $ultima_pagina) ? $pagina_atual +1 : 0 ;  
   
 /* Cálcula qual será a página inicial do nosso range */    
 $range_inicial  = (($pagina_atual - RANGE_PAGINAS) >= 1) ? $pagina_atual - RANGE_PAGINAS : 1 ;   
   
 /* Cálcula qual será a página final do nosso range */    
 $range_final   = (($pagina_atual + RANGE_PAGINAS) <= $ultima_pagina ) ? $pagina_atual + RANGE_PAGINAS : $ultima_pagina ;   
   
 /* Verifica se vai exibir o botão "Primeiro" e "Pŕoximo" */   
 $exibir_botao_inicio = ($range_inicial < $pagina_atual) ? 'mostrar' : 'esconder'; 
   
 /* Verifica se vai exibir o botão "Anterior" e "Último" */   
 $exibir_botao_final = ($range_final > $pagina_atual) ? 'mostrar' : 'esconder';  


$termo = (isset($_GET['termo'])) ? $_GET['termo'] : '';

// Verifica se o termo de pesquisa está vazio, se estiver executa uma consulta completa
// Verifica se o termo de pesquisa está vazio, se estiver executa uma consulta completa
if (empty($termo)):

	$PDO = db_connect();
	$sql = 'SELECT * FROM avaria
			INNER JOIN produto ON avaria.cod_produto = produto.codigo_erp
			INNER JOIN tipo_avaria ON avaria.cod_tipoavaria = tipo_avaria.id_tipoavaria
			INNER JOIN empresa ON avaria.cod_empresa = empresa.id_empresa
			INNER JOIN estoque ON avaria.cod_estoque = estoque.id_estoque
			INNER JOIN situacao_avaria ON avaria.cod_situacao = situacao_avaria.id_situacao
			INNER JOIN login ON avaria.cadastro_avaria_cod = login.id_login';
	$stmt = $PDO->prepare($sql);
	$stmt->execute();
	$avaria = $stmt->fetchAll(PDO::FETCH_OBJ);

else:

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
	$stmt = $PDO->prepare($sql);
	$stmt->bindValue(':codigo_erp', $termo.'%');
	$stmt->bindValue(':descricao_produto', $termo.'%');
	$stmt->bindValue(':descricao_estoque', $termo.'%');
	$stmt->bindValue(':descricao_empresa', $termo.'%');
	$stmt->bindValue(':descricao_situacao', $termo.'%');
	$stmt->bindValue(':nome', $termo.'%');
	$stmt->bindValue(':descricao_tipoavaria', $termo.'%');
	$stmt->execute();
	$avaria = $stmt->fetchAll(PDO::FETCH_OBJ);
endif;
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="icon/favicon.ico">

    <title>Cadastro  - Sistema de Avaria</title>

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
            <a class="nav-link" href="home.php">Dashboard</a>
          </li>
		<li class="nav-item">
            <a class="nav-link" href="avaria.php">Avarias</a>
          </li>
          <li class="nav-item active">
            <a class="nav-link" href="produto.php">Produto<span class="sr-only">(current)</span></a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="relatorios.php">Relatórios</a>
          </li>
         <li class="nav-item">
            <a class="nav-link" href="settings.php">Configurações</a>
          </li>
            <li class="nav-item">
            <a class="nav-link" href="logout.php">Sair</a>
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
        <a class="nav-link active" href="home.php">Dashboard</a>
        <a class="nav-link" data-toggle="tab" href="#consulta" role="consulta">Consulta</a>
        <a class="nav-link" data-toggle="tab" href="#produto" role="produto">Cadastro</a>
        <a class="nav-link" data-toggle="tab" href="#fornecedor" role="fornecedor">Fornecedor</a>
        <a class="nav-link" data-toggle="tab" href="#transportador" role="transportador">Transportador</a>

      </nav>
    </div>

    <main role="main" class="container">
      <div class="my-5 p-5 bg-white rounded shadow-sm">
       <div class="col">
          <div class="tab-content" id="nav-tabContent">
           	



            <div class="tab-pane fade show active" id="consulta" role="tabpanel" aria-labelledby="list-home-list">
<fieldset>
			<!-- Cabeçalho da Listagem -->
			<legend><h1>Consulta</h1></legend>
  <?php if (!empty($avaria)): ?>  
     <table class="table table-striped table-bordered">    
     <thead>    
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
     </thead>    
     <tbody>    
       <?php foreach($avaria as $dados):?>   
       <tr>    
							<td><?=$dados->codigo_erp?></td>
							<td><?=$dados->descricao_produto?></td>
							<td><?=$dados->codigobarra?></td>
							<td><?=$dados->descricao_situacao?></td>
							<td><?=$dados->nome?></td>
							<td><?=$dados->descricao_estoque?></td>
							<td><?=$dados->descricao_tipoavaria?></td>
							<td><?=$dados->cadastro_avaria_date?></td>
							<td>
							<a href='editar.php?id=<?=$avaria->id_login?>' class="btn btn-primary">Editar</a>
							</td>  
       </tr>    
       <?php endforeach; ?>   
     </tbody>    
     </table>    
     
     <div class='box-paginacao'>     
       <a class='box-navegacao <?=$exibir_botao_inicio?>' href="settings.php?page=<?=$primeira_pagina?>" title="Primeira Página">Primeira</a>    
       <a class='box-navegacao <?=$exibir_botao_inicio?>' href="settings.php?page=<?=$pagina_anterior?>" title="Página Anterior">Anterior</a>     
   
      <?php  
      /* Loop para montar a páginação central com os números */   
      for ($i=$range_inicial; $i <= $range_final; $i++):   
        $destaque = ($i == $pagina_atual) ? 'destaque' : '' ;  
        ?>   
        <a class='box-numero <?=$destaque?>' href="settings.php?page=<?=$i?>"><?=$i?></a>    
      <?php endfor; ?>    
   
       <a class='box-navegacao <?=$exibir_botao_final?>' href="settings.php?page=<?=$proxima_pagina?>" title="Próxima Página">Próxima</a>    
       <a class='box-navegacao <?=$exibir_botao_final?>' href="settings.php?page=<?=$ultima_pagina?>" title="Última Página">Último</a>    
     </div>   
    <?php else: ?>   
	<!-- Mensagem caso não exista clientes ou não encontrado  -->
	<h3 class="text-center text-primary">Não encontrada, contactar o suporte!</h3>
    <?php endif; ?> 
			
            </div>
            
            <div class="tab-pane fade show active" id="produto" role="tabpanel" aria-labelledby="list-home-list">
			<fieldset>
			<legend><h1>Cadastro de Produtos</h1></legend>
			
			<form action="action_cadastro.php" method="post" id="form-contato" enctype="multipart/form-data">
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
			      <label for="ip">Fornecedores (Opcional)</label>
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
			
			<form action="action_cadastro.php" method="post" id="form-contato" enctype="multipart/form-data">

			    <div class="form-group">
			      <label for="nome">Código ERP do Fornecedor</label>
			      <input type="text" class="form-control" id="codigoerp_fornecedor" name="codigoerp_fornecedor" placeholder="Infome o código do ERP do seu Fornecedor.">
			      <span class="msg-erro msg-nome"></span>
			    </div>

			  	<div class="form-group">
			      <label for="nome">CNPJ do Fornecedor (Opcional)</label>
			      <input type="text" class="form-control" id="cnpj_fornecedor" name="cnpj_fornecedor" placeholder="Infome o Fornecedor.">
			      <span class="msg-erro msg-nome"></span>
			    </div>

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

            <div class="tab-pane fade" id="transportador" role="tabpanel" aria-labelledby="list-settings-list">
              <fieldset>
				<legend><h1>Cadastro de Transportador</h1></legend>
			
				<form action="action_cadastro.php" method="post" id="form-contato" enctype="multipart/form-data">

			    <div class="form-group">
			      <label for="nome">Código ERP do Trasportador (FALTA DESENVOLVER O RESTANTE)</label>
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
