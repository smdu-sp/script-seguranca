<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <link rel="icon" href="../../../../favicon.ico">

  <title>SMUL - Segurança</title>

  <?php require_once ('scripts.php'); ?>

  <!-- Custom styles for this template -->
  <link href="style.css" rel="stylesheet">
</head>

<body>

  <header>
    <div class="collapse bg-dark" id="navbarHeader">
      <div class="container">
        <div class="row">
          <div class="col-sm-8 col-md-7 py-4">
            <h4 class="text-white">Assessoria de Tecnologia da Informação e Comunicação</h4>
          </div>
          <div class="col-sm-4 offset-md-1 py-4">
            <h4 class="text-white">Links Úteis</h4>
            <ul class="list-unstyled">
              <li><a href="http://intranet.smul.pmsp/" class="text-white">Intranet SMUL</a></li>
              <li><a href="http://suporte.smul.pmsp/glpi" class="text-white">Sistema de Chamados</a></li>
              <li><a href="https://www.prefeitura.sp.gov.br/cidade/secretarias/licenciamento/"
                  class="text-white">Secretaria Municipal de Urbanismo e Licenciamento</a></li>
              <li><a href="https://www.capital.sp.gov.br/" class="text-white">Cidade de São Paulo</a></li>
            </ul>
          </div>
        </div>
      </div>
    </div>
    <div class="navbar navbar-dark bg-dark box-shadow">
      <div class="container d-flex justify-content-between">
        <img src="img/logo.png" alt="Logo SMUL" width="20%">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarHeader"
          aria-controls="navbarHeader" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
      </div>
    </div>
  </header>

  <main role="main">

    <section class="jumbotron text-center">
      <div class="container">
        <h1 class="jumbotron-heading font-weight-bold">SMUL - Segurança</h1>
        <p class="lead text-muted">Scripts para controle de usuários.</p>
      </div>
    </section>

    <div class="album py-5 bg-light">
      <div class="container">
        <div class="row">
          <div class="col-md-4">
            <div class="card mb-4 box-shadow">
              <img class="card-img-top" data-src="holder.js/100px225?theme=thumb&bg=55595c&fg=eceeef&text=Thumbnail"
                alt="Card image cap" src="img/adduser.png">
              <div class="card-body">
                <p class="card-text">Script para adicionar novos usuários no Banco de Dados.</p>
                <div class="d-flex justify-content-between align-items-center">
                  <div class="btn-group">
                    <button type="button" class="btn btn-sm btn-outline-secondary"
                      onclick="window.location.href='gerarusuarios.php'">Executar</button>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-4">
            <div class="card mb-4 box-shadow">
              <img class="card-img-top" data-src="holder.js/100px225?theme=thumb&bg=55595c&fg=eceeef&text=Thumbnail"
                alt="Card image cap" src="img/loginrede.png">
              <div class="card-body">
                <p class="card-text">Script para adicionar o login de rede dos usuários na tabela.</p>
                <div class="d-flex justify-content-between align-items-center">
                  <div class="btn-group">
                    <button type="button" class="btn btn-sm btn-outline-secondary"
                      onclick="window.location.href='usuarioderede.php'">Executar</button>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-4">
            <div class="card mb-4 box-shadow">
              <img class="card-img-top" data-src="holder.js/100px225?theme=thumb&bg=55595c&fg=eceeef&text=Thumbnail"
                alt="Card image cap" src="img/exonerados.png">
              <div class="card-body">
                <p class="card-text">Script para mostrar os servidores exonerados e transferidos no mês atual. <strong>ATENÇÃO</strong> </p>
                <div class="d-flex justify-content-between align-items-center">
                  <div class="btn-group">
                    <button type="button" class="btn btn-sm btn-outline-secondary"
                      onclick="window.location.href='compararsigpec.php'">Executar</button>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-4">
            <div class="card mb-4 box-shadow">
              <img class="card-img-top" data-src="holder.js/100px225?theme=thumb&bg=55595c&fg=eceeef&text=Thumbnail"
                alt="Card image cap" src="img/bloqueados.png">
              <div class="card-body">
                <p class="card-text">Script para mostrar os usuários que estão desativados na rede da PRODAM.</p>
                <div class="d-flex justify-content-between align-items-center">
                  <div class="btn-group">
                    <button type="button" class="btn btn-sm btn-outline-secondary"
                      onclick="window.location.href='usuariosdesativados.php'">Executar</button>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </main>
  <footer class="text-muted">
    <div class="container">
      <p class="float-right">
        <a href="#">Topo</a>
      </p>
      <?php $year = date('Y'); 
      echo "<p>SMUL/ATIC - $year </p>"; ?>      
    </div>
  </footer>

  <!-- Bootstrap core JavaScript
    ================================================== -->
  <!-- Placed at the end of the document so the pages load faster -->

  <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
    integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN"
    crossorigin="anonymous"></script>
  <script>window.jQuery || document.write('<script src="../../../../assets/js/vendor/jquery-slim.min.js"><\/script>')</script>
  <script src="assets/js/vendor/popper.min.js"></script>
  <script src="dist/js/bootstrap.min.js"></script>
  <script src="assets/js/vendor/holder.min.js"></script>
</body>

</html>