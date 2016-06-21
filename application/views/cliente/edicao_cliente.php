<?php
echo "<script src='".base_url('assets/plugins/jquery.validate.js')."'></script>";
echo "<script src='".base_url('assets/plugins/jquery.mask.js')."'></script>";
echo "<script src='".base_url('assets/js/validacao_cliente.js')."'></script>";
?>
<legend>Alteração de Cliente</legend>


	<form method="post" id="form_cliente">
            <input type="hidden" name="id_cliente" value="<?php echo $cliente->get_id_cliente();?>"/>
                        <div class="col-md-6 control-group ">

				<label class="control-label" for="Nome">Empresa</label> 
                                <input id="nome" name="nome" placeholder="Nome"
                                       value="<?php echo $cliente->get_nome();?>"
					class="form-control" type="text">

			</div>
                        <div class="col-md-6 control-group">
				<label class="control-label">Endereço</label>
                                <input id="endereco" type="text"
                                       value="<?php echo $cliente->get_endereco();?>"
					class="form-control" name='endereco' placeholder="Endereço">
			</div>
			
			
			
			<div class="col-md-4 control-group">
				<label class="control-label">Responsável</label> 
                                    <input id="responsavel" type="text" 
                                         value="<?php echo $cliente->get_responsavel();?>"
                                        class="form-control" name='responsavel' 
                                        placeholder="Responsavel">
			</div>
            
                         <div class="col-md-4 control-group">
				<label class="control-label">CNPJ</label>
                                <input id="cnpj" type="text"
                                        value="<?php echo $cliente->get_cnpj();?>"
					class="form-control" name='cnpj'
                                        placeholder="CNPJ">
			</div>
			
			
			<div class="col-md-4 control-group">
				<label class="control-label">Email</label> <input
					id="email" type="text" class="form-control"
                                        value="<?php echo $cliente->get_email();?>"
                                        name='email'
					placeholder="Email">
			</div>
            
			<div class="col-md-4 control-group">
				<label class="control-label">Telefone1</label>
                                <input id="telefone" type="text"
                                       value="<?php echo $cliente->get_telefone();?>"
					class="form-control telefone" name='telefone' placeholder="Telefone1">
			</div>
                        <div class="col-md-4 control-group">
				<label class="control-label">Telefone2</label>
                                <input id="telefone2" type="text"
                                       value="<?php echo $cliente->get_telefone2();?>"
					class="form-control telefone" name='telefone2' placeholder="Telefone2">
			</div>
                        <div class="col-md-4 control-group">
				<label class="control-label">Telefone3</label>
                                <input id="telefone3" type="text"
                                       value="<?php echo $cliente->get_telefone3();?>"
					class="form-control telefone" name='telefone3' placeholder="Telefone3">
			</div>
                   
                    <div class="control-group col-md-7 col-md-offset-5">
                        <br><br>
				<button formaction="<?php echo base_url('cliente/gravar_alteracao')?>"
					type="submit" class="btn btn-success" id="salvar">
					<span class="glyphicon glyphicon-save"></span> Salvar
				</button>
				<button id="voltar"
					type="button" class="btn btn-default">
					<span class="glyphicon glyphicon-arrow-left"></span> Voltar
				</button>

			</div>
		

		
	</form>
