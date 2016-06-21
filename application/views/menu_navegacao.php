<?php
$x1=isset($active) && $active=='home'?'active':'';
$x2=isset($active) && $active=='cliente'?'active':'';
$x3=isset($active) && $active=='fornecedor'?'active':'';
$x4=isset($active) && $active=='produto'?'active':'';
$x5=isset($active) && $active=='servico'?'active':'';
$x6=isset($active) && $active=='relatorio'?'active':'';
$x7=isset($active) && $active=='anotacao'?'active':'';
?>
<section id="menu"  >
		<nav class="navbar navbar-default" >
			
			<ul class="nav navbar-nav">
				<li class="<?php echo $x1?>"><a href="<?php echo base_url('home')?>">Home</a></li>
                                <li class="<?php echo $x2?>"><a href="<?php echo base_url('cliente') ?>" class="limpa_state">Cliente</a></li>
                                <li class="<?php echo $x3?>"><a href="<?php echo base_url('fornecedor') ?>" class="limpa_state">Fornecedor</a></li>
                                <li class="<?php echo $x4?>"><a href="<?php echo base_url('produto') ?>" class="limpa_state">Produto</a></li>
                                <li class="<?php echo $x5?>"><a href="<?php echo base_url('servico') ?>" class="limpa_state">Serviço</a></li>
				<li class="<?php echo $x6?>"><a href="<?php echo base_url('relatorio') ?>">Emitir Relatório</a></li>
                                <li class="<?php echo $x7?>"><a href="<?php echo base_url('anotacao') ?>" class="limpa_state">Anotações</a></li>
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
		</nav>


</section> 

<section id="conteudo">  
