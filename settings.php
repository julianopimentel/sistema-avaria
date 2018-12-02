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

 //Informações da empresa
	$PDO = db_connect();
	$sql = 'SELECT * FROM empresa';
	$stmt = $PDO->prepare($sql);
	$stmt->execute();
	$empresa = $stmt->fetchAll(PDO::FETCH_OBJ);

  //informações de tipo de avaria
  $PDO = db_connect();
  $sql = 'SELECT * FROM tipo_avaria WHERE situacao_tipoavaria = "Ativo"';
  $stmt = $PDO->prepare($sql);
  $stmt->execute();
  $tipo_avaria = $stmt->fetchAll(PDO::FETCH_OBJ);

  //informações estoque
  $PDO = db_connect();
  $sql = 'SELECT * FROM estoque WHERE situacao_estoque = "Ativo"';
  $stmt = $PDO->prepare($sql);
  $stmt->execute();
  $estoque = $stmt->fetchAll(PDO::FETCH_OBJ);

	/* Instrução de consulta para paginação com MySQL */  
  $PDO = db_connect();
 	$sql = "SELECT * FROM login LIMIT {$linha_inicial}, " . QTDE_REGISTROS;  
 	$stm = $PDO->prepare($sql);   
 	$stm->execute();   
 	$dados = $stm->fetchAll(PDO::FETCH_OBJ); 

	 /* Conta quantos registos existem na tabela */  
	$sqlContador = "SELECT COUNT(*) AS total_registros FROM login";   
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
            <a class="nav-link" href="home.php">Dashboard</a>
          </li>
	       	<li class="nav-item">
            <a class="nav-link" href="avaria.php">Avarias</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="produto.php">Produto</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="relatorios.php">Relatórios</a>
          </li>
         <li class="nav-item active">
            <a class="nav-link" href="settings.php">Configurações</a>
          </li>
          </li>
            <li class="nav-item">
            <a class="nav-link" href="logout.php">Sair</a>
          </li>
        </ul>
      </div>
    </nav>

    <div class="nav-scroller bg-white shadow-sm">
      <nav class="nav nav-underline">
        <a class="nav-link active" href="home.php">Dashboard</a>
        <a class="nav-link" data-toggle="tab" href="#usuario" role="usuario">Usuários</a>
        <a class="nav-link" data-toggle="tab" href="#tipoavaria" role="tipoavaria">Tipo de Avaria</a>
        <a class="nav-link" data-toggle="tab" href="#estoque" role="estoque">Estoque</a>
        <a class="nav-link" data-toggle="tab" href="#sistema" role="sistema">Sistema</a>
        <a class="nav-link" data-toggle="tab" href="#empresa" role="empresa">Empresa</a>
      </nav>
    </div>

    <main role="main" class="container">
      <div class="my-5 p-5 bg-white rounded shadow-sm">
       <div class="col">
          <div class="tab-content" id="nav-tabContent">

                     	
    <div class="tab-pane fade show active" id="usuario" role="tabpanel" aria-labelledby="list-home-list">     
    <fieldset>
			<!-- Cabeçalho da Listagem -->
			<legend><h1>Usuários</h1></legend>
      <?php if (!empty($dados)): ?>  
     <table class="table table-striped table-bordered">    
     <thead>    
       <tr class='active'>    
						<th>ID</th>
						<th>Nome</th>
						<th>Sobrenome</th>
						<th>E-Mail</th>
						<th>Situação</th>
						<th>Nível</th>
						<th>Ação</th>
       </tr>    
     </thead>    
     <tbody>    
       <?php foreach($dados as $usuario):?>   
       <tr>    
							<td><?=$usuario->id_login?></td>
							<td><?=$usuario->nome?></td>
							<td><?=$usuario->sobrenome?></td>
							<td><?=$usuario->email?></td>
							<td><?=$usuario->situacao?></td>
							<td><?=$usuario->nivel?></td>
							<td>
							<a href='editar.php?id=<?=$usuario->id_login?>' class="btn btn-primary">Editar</a>
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
     </div> <br>
<p>
  <button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#cadastrousuario" aria-expanded="false" aria-controls="cadastrousuario">Cadastrar Usuário </button>
</p>
<div class="collapse" id="cadastrousuario">
  <div class="card card-body">
          <form action="funcoes/action_settings.php" method="post" id="form-contato" enctype="multipart/form-data">

          <div class="form-group">
            <label for="nome">Nome</label>
            <input type="text" class="form-control" id="nome" name="nome" placeholder="Nome do Colaborador.">
            <span class="msg-erro msg-nome"></span>
          </div>

          <div class="form-group">
            <label for="nome">Sobrenome</label>
            <input type="text" class="form-control" id="sobrenome" name="sobrenome" placeholder="Sobrenome do Colaborador.">
            <span class="msg-erro msg-nome"></span>
          </div>

          <div class="form-group">
            <label for="nome">E-mail</label>
            <input type="email" class="form-control" id="email" name="email" placeholder="Infome o E-mail de Acesso.">
            <span class="msg-erro msg-nome"></span>
          </div>

          <div class="form-group">
            <label for="nome">Senha</label>
            <input type="password" class="form-control" id="senha" name="senha" placeholder="Infome uma senha.">
            <span class="msg-erro msg-nome"></span>
          </div>

          <div class="form-group">
            <label for="status">Nível de Acesso (Consultar Manual)</label>
            <select class="form-control" name="nivel" id="nivel">
            <option value="">Selecione o Status</option>
            <option value="1">1</option>
            <option value="2">2</option>
          </select>
          <span class="msg-erro msg-status"></span>
          </div>
            <div class="form-group">
            <label for="status">Situação (Opcional)</label>
            <select class="form-control" name="status" id="status">
            <option value="">Selecione o Status</option>
            <option value="Ativo">Ativo</option>
            <option value="Inativo">Inativo</option>
          </select>
          </div>
          <input type="hidden" name="acao" value="incluir_usuario">
          <button type="submit" class="btn btn-primary" id="botao"> 
            Gravar
          </button>
      </form>
  </div>
</div>
    <?php else: ?>   
	<!-- Mensagem caso não exista clientes ou não encontrado  -->
	<h3 class="text-center text-primary">Não encontrada, contactar o suporte!</h3>
    <?php endif; ?> 
		 </div>
        

        <div class="tab-pane fade" id="sistema" role="tabpanel" aria-labelledby="list-profile-list">
 			<fieldset>
			<legend><h1>Sistema</h1></legend>
			
			<form action="funcoes/action_settings.php" method="post" id="form-contato" enctype="multipart/form-data">

			    <div class="form-group">
			      <label for="status">Envio por E-mail - Relatório</label>
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
			      <label for="status">Envio por E-mail - Cadastro de Novas Avarias</label>
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

            <div class="tab-pane fade" id="empresa" role="tabpanel" aria-labelledby="list-messages-list">
			<fieldset>
			<!-- Cabeçalho da Listagem -->
			<legend><h1>Empresa</h1></legend>
				<?php if(!empty($empresa)):?>

				<!-- Tabela de Clientes -->
				<table class="table table-striped table-bordered">
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
               <tbody>   
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
        </tbody>
				</table>
				<?php else: ?>

				<!-- Mensagem caso não exista clientes ou não encontrado  -->
				<h3 class="text-center text-primary">Não encontrada, contactar o suporte!</h3>
			<?php endif; ?>
			</fieldset> 
            </div>

            <div class="tab-pane fade" id="tipoavaria" role="tabpanel" aria-labelledby="list-messages-list">
      <fieldset>
      <legend><h1>Tipos de Avarias</h1></legend>
    
      <?php if(!empty($tipo_avaria)):?>
        <!-- Tabela de Clientes -->
        <table class="table table-striped table-bordered">
          <tr class='active'>
            <th>ID</th>
            <th>Local de Estoque</th>
            <th>Situação</th>
          </tr>
               <tbody>   
          <?php foreach($tipo_avaria as $tipo_avaria):?>
            <tr>
              <td><?=$tipo_avaria->id_tipoavaria?></td>
              <td><?=$tipo_avaria->descricao_tipoavaria?></td>
              <td><?=$tipo_avaria->situacao_tipoavaria?></td>
            </tr> 
          <?php endforeach;?>
        </tbody>
        </table>
        <p>
  <button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#tipo_avaria" aria-expanded="false" aria-controls="tipo_avaria">Cadastrar Tipo de Avaria</button>
</p>
<div class="collapse" id="tipo_avaria">
  <div class="card card-body">
          <form action="funcoes/action_settings.php" method="post" id="form-contato" enctype="multipart/form-data">

          <div class="form-group">
            <label for="nome">Tipos de Avaria</label>
            <input type="text" class="form-control" id="descricao_tipoavaria" name="descricao_tipoavaria" placeholder="Infome o novo tipo de Avaria.">
            <span class="msg-erro msg-nome"></span>
          </div>
            <div class="form-group">
            <label for="status">Situação (Opcional)</label>
            <select class="form-control" name="status" id="status">
            <option value="">Selecione o Status</option>
            <option value="Ativo">Ativo</option>
            <option value="Inativo">Inativo</option>
          </select>
          </div>
          <input type="hidden" name="acao" value="incluir_tipoavaria">
          <button type="submit" class="btn btn-primary" id="botao">Gravar</button>
           </form>
            </div>
        <?php else: ?>
        <!-- Mensagem caso não exista clientes ou não encontrado  -->
        <h3 class="text-center text-primary">Não encontrada, contactar o suporte!</h3>
      <?php endif; ?>
      </fieldset> 
            </div>
            

        <!--Comeca o form usado -->
       <div class="tab-pane fade" id="estoque" role="tabpanel" aria-labelledby="list-messages-list">
      <fieldset>
      <legend><h1>Locais de Estoques</h1></legend>
    
      <?php if(!empty($estoque)):?>
        <!-- Tabela de Clientes -->
        <table class="table table-striped table-bordered">
          <tr class='active'>
            <th>ID</th>
            <th>Local de Estoque</th>
            <th>Situação</th>
          </tr>
               <tbody>   
          <?php foreach($estoque as $estoque):?>
            <tr>
              <td><?=$estoque->id_estoque?></td>
              <td><?=$estoque->descricao_estoque?></td>
              <td><?=$estoque->situacao_estoque?></td>
            </tr> 
          <?php endforeach;?>
        </tbody>
        </table>
        <p>
  <button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#tipo_avaria" aria-expanded="false" aria-controls="tipo_avaria">Cadastrar Local de Estoque</button>
</p>
<div class="collapse" id="tipo_avaria">
  <div class="card card-body">
      
        <form action="funcoes/action_settings.php" method="post" id="form-contato" enctype="multipart/form-data">

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
          <button type="submit" class="btn btn-primary" id="botao">Gravar</button>
           </form>
            </div>
        <?php else: ?>
        <!-- Mensagem caso não exista clientes ou não encontrado  -->
        <h3 class="text-center text-primary">Não encontrada, contactar o suporte!</h3>
      <?php endif; ?>
      </fieldset> 
            </div>

                <!--Termina  o form usado -->
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
