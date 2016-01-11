<?php
echo "<script src='".base_url('assets/plugins/jquery.validate.js')."'></script>";
echo "<script src='".base_url('assets/plugins/jquery.mask.js')."'></script>";
echo "<script src='".base_url('assets/js/validacao_cliente.js')."'></script>";
?>
<legend>Cadastro de Novo Cliente</legend>


	<form method="post" id="form_cliente">
                        <div class="col-md-6 control-group ">

				<label class="control-label" for="Nome">Empresa</label> <input
					id="nome" name="nome" placeholder="Nome"
					class="form-control" type="text">

			</div>
                        <div class="col-md-6 control-group">
				<label class="control-label">Endereço</label>
                                <input id="endereco" type="text"
					class="form-control" name='endereco' placeholder="Endereço">
			</div>
						
			
			<div class="col-md-4 control-group">
				<label class="control-label">Responsável</label> <input
					id="responsavel" type="text" class="form-control" name='responsavel'
					placeholder="Responsável">
			</div>
                        <div class="col-md-4 control-group">
				<label class="control-label">CNPJ</label>
                                <input id="cnpj" type="text"
					class="form-control" name='cnpj' placeholder="CNPJ">
			</div>
			
			
			<div class="col-md-4 control-group">
				<label class="control-label">Email</label> <input
					id="email" type="text" class="form-control" name='email'
					placeholder="Email">
			</div>
                        <div class="col-md-4 control-group">
				<label class="control-label">Telefone1</label>
                                <input id="telefone" type="tel"
					class="form-control telefone" name='telefone' placeholder="Telefone1">
			</div>
            
                        <div class="col-md-4 control-group">
				<label class="control-label">Telefone2</label>
                                <input id="telefone2" type="tel"
					class="form-control telefone" name='telefone2' placeholder="Telefone2">
			</div>
            
                        <div class="col-md-4 control-group">
				<label class="control-label">Telefone3</label>
                                <input id="telefone3" type="tel"
					class="form-control telefone" name='telefone3' placeholder="Telefone3">
			</div>
			
                       

                   
                    <div class="control-group col-md-7 col-md-offset-5">
                        <br><br>
				<button formaction="<?php echo base_url('cliente/cadastrar')?>"
					type="submit" class="btn btn-success" id="salvar">
					<span class="glyphicon glyphicon-save"></span> Salvar
				</button>
				<button id="voltar"
					type="button" class="btn btn-default">
					<span class="glyphicon glyphicon-arrow-left"></span> Voltar
				</button>

			</div>
		

		
	</form>
