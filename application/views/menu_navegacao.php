<?php
$x1 = isset($active) && $active == 'home' ? 'active' : '';
$x2 = isset($active) && $active == 'cliente' ? 'active' : '';
$x3 = isset($active) && $active == 'fornecedor' ? 'active' : '';
$x4 = isset($active) && $active == 'produto' ? 'active' : '';
$x5 = isset($active) && $active == 'servico' ? 'active' : '';
$x6 = isset($active) && $active == 'relatorio' ? 'active' : '';
$x7 = isset($active) && $active == 'anotacao' ? 'active' : '';
?>
<section id="menu"  >
    <nav class="navbar navbar-default" >
        <div class="container-fluid">

            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#clare-collapse-1" aria-expanded="false">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <ul class="nav navbar-nav">
                    <li class="<?php echo $x1 ?>"><a class="navbar-brand" href="<?php echo base_url('home') ?>">Home</a></li>
                </ul>
            </div>
            <div class="collapse navbar-collapse" id="clare-collapse-1">
                <ul class="nav navbar-nav">

                    <li class="<?php echo $x2 ?>"><a href="<?php echo base_url('cliente') ?>" class="limpa_state">Cliente</a></li>
                    <li class="<?php echo $x3 ?>"><a href="<?php echo base_url('fornecedor') ?>" class="limpa_state">Fornecedor</a></li>
                    <li class="<?php echo $x4 ?>"><a href="<?php echo base_url('produto') ?>" class="limpa_state">Produto</a></li>
                    <li class="<?php echo $x5 ?>"><a href="<?php echo base_url('servico') ?>" class="limpa_state">Serviço</a></li>

                    <li class="dropdown <?php echo $x6 ?>">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Emitir Relatório <span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li><a href="<?php echo base_url('relatorio') ?>">Prod/Sv</a></li>
                            <li><a href="<?php echo base_url('relatorio/fluxo') ?>">Fluxo</a></li>
                        </ul>
                    </li>

                    <li class="<?php echo $x7 ?>"><a href="<?php echo base_url('anotacao') ?>" class="limpa_state">Anotações</a></li>


                </ul>

                <div class="navbar-right">
                    <ul class="nav navbar-nav">
                        <li>
                            <a href="<?php echo base_url('login/deslogar') ?>" class="sair">
                                <span class="glyphicon glyphicon-off"></span> Sair
                            </a>


                        </li>

                    </ul>

                </div>
            </div><!-- /.navbar-collapse -->
        </div><!-- /.container-fluid -->
    </nav>


</section> 

<section id="conteudo">  
