<?php
echo "<script src='".base_url('assets/plugins/jquery.validate.js')."'></script>";
echo "<script src='".base_url('assets/js/validacao_login.js')."'></script>";
?>
<div id="login" >
	<div id="titulo_login"><h2 >Login </h1></div>
	<?php if ($this->session->flashdata('msg')!=null):?>
		<div class="alert alert-danger alert-dismissable">
  			<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
  			<p><?php echo $this->session->flashdata('msg');?></p> 
		</div>
	<?php endif?>
	<div id="corpo_login">  
	<form id="form_login" method="post" action="<?php echo base_url('login/logar') ?>" class="form-horizontal">
		<div class="form-group">
			<label class="col-md-2 control-label">Usuario</label>
			<div class="col-md-8">
				<input name="usuario" type="text" class="form-control" placeholder="Usuário">
			</div>
		</div>
		<div class="form-group">
			<label class="col-md-2 control-label">Senha</label>
			<div class="col-md-8">
				<input name="senha" type="password" class="form-control" placeholder="Senha">
			</div>
		</div>
		<div class="form-group">
			<div class="col-md-offset-2 col-md-10">
				<button type="submit" class="btn btn-primary">Entrar</button>

			</div>
		</div>
		

	</form>
	</div>
</div>    
  

