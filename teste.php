<?php   
 /* Constantes de configuração */  
 define('QTDE_REGISTROS', 5);   
 define('RANGE_PAGINAS', 1);   
   
 /* Recebe o número da página via parâmetro na URL */  
 $pagina_atual = (isset($_GET['page']) && is_numeric($_GET['page'])) ? $_GET['page'] : 1;   
   
 /* Calcula a linha inicial da consulta */  
 $linha_inicial = ($pagina_atual -1) * QTDE_REGISTROS;  
   
 /* Cria uma conexão PDO com MySQL */  
 $opcoes = array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES UTF8');  
 $pdo = new PDO("mysql:host=localhost; dbname=u617793640_cocil;", "u617793640_acess", "fHtjYbni84Xs", $opcoes);  
   
 /* Instrução de consulta para paginação com MySQL */  
 $sql = "SELECT * FROM login LIMIT {$linha_inicial}, " . QTDE_REGISTROS;  
 $stm = $pdo->prepare($sql);   
 $stm->execute();   
 $dados = $stm->fetchAll(PDO::FETCH_OBJ);   
   
 /* Conta quantos registos existem na tabela */  
 $sqlContador = "SELECT COUNT(*) AS total_registros FROM login";   
 $stm = $pdo->prepare($sqlContador);   
 $stm->execute();   
 $valor = $stm->fetch(PDO::FETCH_OBJ);   
   
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
 <!DOCTYPE html>    
 <html>    
 <head>    
 <meta charset='utf-8'>    
 <title>Paginação - William Programação</title>    
 <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">    
    <link href="css/bootstrap.min.css" rel="stylesheet">
   
 </head>    
 <body>    
 <div class='container'>    
   <div class="row">    
    <h1 class="text-center">Paginação de Dados</h1><hr>   
    
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
							<a href='editar.php?id=<?=$cliente->cod_erp?>' class="btn btn-primary">Editar</a>
							</td>  
       </tr>    
       <?php endforeach; ?>   
     </tbody>    
     </table>    
     
     <div class='box-paginacao'>     
       <a class='box-navegacao <?=$exibir_botao_inicio?>' href="index.php?page=<?=$primeira_pagina?>" title="Primeira Página">Primeira</a>    
       <a class='box-navegacao <?=$exibir_botao_inicio?>' href="index.php?page=<?=$pagina_anterior?>" title="Página Anterior">Anterior</a>     
   
      <?php  
      /* Loop para montar a páginação central com os números */   
      for ($i=$range_inicial; $i <= $range_final; $i++):   
        $destaque = ($i == $pagina_atual) ? 'destaque' : '' ;  
        ?>   
        <a class='box-numero <?=$destaque?>' href="index.php?page=<?=$i?>"><?=$i?></a>    
      <?php endfor; ?>    
   
       <a class='box-navegacao <?=$exibir_botao_final?>' href="index.php?page=<?=$proxima_pagina?>" title="Próxima Página">Próxima</a>    
       <a class='box-navegacao <?=$exibir_botao_final?>' href="index.php?page=<?=$ultima_pagina?>" title="Última Página">Último</a>    
     </div>   
    <?php else: ?>   
     <p class="bg-danger">Nenhum registro foi encontrado!</p>  
    <?php endif; ?>   
   </div>    
 </div>    
 </body>    
 </html>  