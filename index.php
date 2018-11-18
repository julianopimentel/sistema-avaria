<!DOCTYPE HTML>
<html lang="pt-br">
<head>
<meta charset="utf-8">
<title>Sistema de login</title>
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<meta name="description" content="">
<meta name="author" content="">
<link rel="icon" href="icon/favicon.ico">
<link href="css/estilo-index.css" rel="stylesheet" type="text/css" media="all">
<link href="css/bootstrap.min.css" rel="stylesheet" type="text/css" media="all">
<link href="css/bootstrap-theme.min.css" rel="stylesheet" type="text/css" media="all">
<script src="js/bootstrap.min.js" type="text/javascript"></script>
</head>
  <body class="text-center">

    <form class="form-signin" action="fucoes/login.php" method="post">
      <img class="mb-4" src="icon/logo.jpg" alt="" width="72" height="72">
      <h1 class="h3 mb-3 font-weight-normal">Please sign in</h1>
      <label for="inputEmail" class="sr-only">Email address</label>
      <input type="email" name="email" class="form-control" id="email" placeholder="E-mail" required="required" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$">
      <label for="inputPassword" class="sr-only">Password</label>
      <input type="password" name="password" class="form-control" id="password" placeholder="Senha" required>
      <div class="checkbox mb-3">
        <label>
          <input type="checkbox" value="remember-me"> Remember me
        </label>
      </div>
      <button class="btn btn-lg btn-primary btn-block" type="submit" value="Entrar">Logar</button>
      <p class="mt-5 mb-3 text-muted">&copy; 2017-2018</p>
        <?php if(isset($_GET["login"]) == "error"){ ?>
        <div class="alert alert-danger alert-block alert-aling" role="alert">Ops! E-mail ou Senha estão errado</div>
        <?php } ?>
    </form>

  </body>
</html>                