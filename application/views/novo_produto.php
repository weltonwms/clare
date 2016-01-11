<?php
echo "<script src='".base_url('assets/plugins/jquery.validate.js')."'></script>";
echo "<script src='".base_url('assets/plugins/jquery.mask.js')."'></script>";
echo "<script src='".base_url('assets/js/validacao_produto.js')."'></script>";
echo link_tag(array('href'=>'assets/plugins/chosen/chosen.css','rel'=>'stylesheet','type'=>'text/css'));
echo "<script src='".base_url('assets/plugins/chosen/chosen.jquery.js')."'></script>";
?>
<legend>Cadastro de Novo Produto</legend>


<form method="post" id="form_produto" class="form-horizontal">
    <div class="row">
    <div class=" col-md-6">
        <fieldset>
            <legend>Produto</legend>
           
        
                        <div class="form-group ">

				<label class="control-label col-md-4" for="nome">Nome</label> 
                                <div class="col-md-8">
                                    <input id="nome" name="nome" placeholder="Nome"
					class="form-control" type="text">
                                </div>

			</div>
                        
						
			
			
            
                        <div class="form-group">
				<label class="control-label col-md-4">Fornecedor</label>
                                <div class="col-md-8">
                                    <select  name="id_fornecedor" class="form-control meu_chosen" >
                                        <option value="" >Selecione</option>
                                        <?php
                                            foreach($fornecedores as $fornecedor):
                                                echo "<option value='{$fornecedor->get_id_fornecedor()}'>";
                                                echo "(cod {$fornecedor->get_id_fornecedor()}) ".$fornecedor->get_empresa();
                                                echo "</option>";
                                            endforeach;
                                        ?>
                                    </select>
					
                                </div>
			</div>
            </fieldset>
                        
                      
                       
        </div>
        
       
    </div>
                    <div class="control-group col-md-7 col-md-offset-5">
				<button formaction="<?php echo base_url('produto/cadastrar')?>"
					type="submit" class="btn btn-success" id="salvar">
					<span class="glyphicon glyphicon-save"></span> Salvar
				</button>
				<button id="voltar"
					type="button" class="btn btn-default">
					<span class="glyphicon glyphicon-arrow-left"></span> Voltar
				</button>

			</div>
		

		
	</form>
