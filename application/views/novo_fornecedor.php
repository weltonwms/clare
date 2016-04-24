<?php
echo "<script src='".base_url('assets/plugins/jquery.validate.js')."'></script>";
echo "<script src='".base_url('assets/plugins/jquery.mask.js')."'></script>";
echo "<script src='".base_url('assets/js/validacao_fornecedor.js')."'></script>";
?>
<legend>Cadastro de Novo Fornecedor</legend>


	<form method="post" id="form_fornecedor">
                        <div class="col-md-6 control-group ">

				<label class="control-label" for="empresa">Empresa</label> 
                                <input id="empresa" name="empresa" placeholder="Empresa"
                                       
					class="form-control" type="text">

			</div>
            
                         <div class="col-md-6 control-group ">

				<label class="control-label" for="responsavel">Responsável</label> 
                                <input id="nome" name="responsavel" placeholder="Responsável"
                                       
					class="form-control" type="text">

			</div>
                        <div class="col-md-6 control-group ">

				<label class="control-label" for="fone">Telefone</label> 
                                <input id="fone" name="fone" placeholder="Telefone"
                                       
					class="form-control telefone" type="text">

			</div>
                         <div class="col-md-6 control-group ">

				<label class="control-label" for="conta">Conta Bancária</label> 
                                <input id="conta" name="conta" placeholder="Conta Bancária"
                                       
					class="form-control" type="text">

			</div>
                       
			
                       

                   
                    <div class="control-group col-md-7 col-md-offset-5">
                        <br><br>
				<button formaction="<?php echo base_url('fornecedor/cadastrar')?>"
					type="submit" class="btn btn-success limpa_state" id="salvar">
					<span class="glyphicon glyphicon-save "></span> Salvar
				</button>
				<button id="voltar"
					type="button" class="btn btn-default">
					<span class="glyphicon glyphicon-arrow-left"></span> Voltar
				</button>

			</div>
		

		
	</form>
