<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Impressão de Serviço</title>
        <style>
            
            
            div{
                padding: 2px;
                margin: 8px;
                font-family: "arial","Bitstream Vera Sans", sans-serif;
                font-size: 15px;
            }

            div.quadradinho{
                padding: 2px;
                margin: 0 60px 0 0;
                text-align: right;
                padding-left: 5px;
            }
            .container{
               
                width:100%;
               padding: 20px;

            }

            #logo{
                

                /*max-width: 40%;*/
            }

            #tipo_servico{
                border: 2px solid;
                font-size: 14px;
                /*width: 240px;*/
           }

            #info_cliente{
               
                line-height: 25px;
                padding:9px;
            }

            #discriminacao{
               
               /* border: 2px solid;*/
            }

            #endereco{
                
                padding-top: 30px;
                margin-top: 20px;
                font-size: 11px;
                
            }
            
            #endereco td{
                text-align: center;
                
            }
            .borda{
                border: 1px solid;
            }

            .coluna1_tipo_servico{
                
            }

            .coluna2_info_cliente{
                min-width: 175px;
            }

            .borda_topo{
               border-top: 1px solid;
              
            }

            .destaque{
                background-color:  #E5E5DB;
            }

           
            
            #discriminacao table #preco_total td:first-child{
                border-left:none ;
                border-bottom: none;
                font-weight: bold;
            }
            
             #discriminacao table #preco_total td:last-child{
                
            }
            
            #discriminacao table td, #discriminacao table th{
                border: 1px solid;
            }
        </style>
    </head>
    <body>
        <?php
        $base_url = FCPATH;
        
        ?>


        <div class="container">
            <table   width="100%" cellspacing='0' cellpadding='0'>
                <tr>
                    <td width="50%">
                        <div id="log">
                            <img src="<?php echo $base_url ?>assets/imgs/logo_impressao.jpg" alt="Log" width="390px"> 
                        </div>
                    </td>

                    <td>
                        <div id="tipo_servico">
                            <table >
                                <tr >
                                    <td  class="coluna1_tipo_servico"> Nº Serviço </td>
                                    <td><?php echo $servico->get_id_servico()?></td>
                                </tr>
                                <tr>
                                    <td> <div class="borda quadradinho"><?php if ($servico->get_estado()=='2') echo "X"?>&nbsp;</div> </td>
                                    <td>Serviço Executado</td>
                                </tr>
                                <tr>
                                    <td> <div class="borda quadradinho"><?php if ($servico->get_estado()=='1') echo "X"?>&nbsp;</div> </td>
                                    <td>Orçamento</td>
                                </tr>
                                <tr>
                                    <td>Data </td>
                                    <td><?php echo $servico->get_data()?> </td>
                                </tr>
                            </table>
                        </div>
                    </td>
                </tr>

            </table>





            <div id="info_cliente">
                <table>
                    <tr>
                        <td>Empresa:</td>
                        <td width='200' class="coluna2_info_cliente"><?php echo $servico->get_nome_cliente()?></td>
                        <td colspan="2">Responsável: <?php echo $servico->get_responsavel_cliente()?>&nbsp;&nbsp;&nbsp;&nbsp;</td>
                        
                    </tr>
                    <tr>
                        <td>Endereço:</td>
                        <td colspan="3"><?php echo $servico->get_endereco_cliente()?></td>
                    </tr>
                    <tr>
                        <td>Telefone:</td>
                        <td colspan="3"><?php echo $servico->get_telefone_cliente()?></td>
                     
                    </tr>
                    <tr>
                        <td>Pagamento:</td>
                        <td colspan="3"> <?php echo $servico->get_forma_pagamento()?></td>
                        
                    </tr>
                </table>
            </div>
            <div id="discriminacao">
                <table width='100%' cellspacing='0' cellpadding='5'>
                    <tr class='destaque'>
                        <th width="5%">Item</th>
                        <th width="5%">Qtd</th>
                        <th width="60%">Discriminação</th>
                        <th width="15%">Preço Un</th>
                        <th width="15%">Total</th>
                    </tr>
                   <?php $cont=1;foreach($servico->get_itens_servico() as $item): ?>
                    <tr>
                        <td><?php echo $cont ?> </td>
                        <td><?php echo $item->get_qtd_produto() ?></td>
                        <td>
                            <?php echo $item->get_nome_produto()?>
                             <?php echo"<br>". $item->get_descricao()?>
                        </td>
                         <td><?php echo "R$ " . number_format($item->get_valor_final(), 3, ",", "."); ?></td>
                         <td><?php echo "R$ " . number_format($item->get_valor_final_multiplicado(), 2, ",", "."); ?></td>
                    </tr>
                    <?php $cont++; endforeach;?>
                    <?php if($imprimir_total):?>
                    <tr id="preco_total">
                        <td colspan="4" align="right"> Total Geral</td>
                        <td class="destaque"><?php echo "R$ " . number_format($servico->get_total_itens_servico(), 2, ",", "."); ?></td>
                    </tr>
                    <?php endif;?>
                </table>
                <br>
             <?php if($servico->get_obs()) echo "Obs: ".$servico->get_obs()?>
            </div>
             
            <div id="endereco">
                <!--<h4>Valparaíso de Goiás <span class='data-final'> ______/_______/_______</span></h4>--><br>
                <table  width="100%" cellspacing='0' cellpadding='0'>
                    <tr>
                        <td width="50%"><div class='borda_topo'>Cliente</div></td>
                        <td><div class='borda_topo'>Contratante</div></td>
                    </tr>
                </table>


            </div>
            
           
        </div>






        <!--
        <script type="text/php">


            if ( isset($pdf) ) {
            $data= date('d-m-Y');
            $texto="Sistema Gerenciador de Mensalidades";
            $font = Font_Metrics::get_font("helvetica", "bold"); $pdf->page_text(220, 760, "{$texto} ", $font, 9, array(0,0,0));
            $font2 = Font_Metrics::get_font("helvetica", "bold"); $pdf->page_text(535, 760, " PG: {PAGE_NUM} de {PAGE_COUNT}", $font2, 9, array(0,0,0));
            $font3 = Font_Metrics::get_font("helvetica", "bold"); $pdf->page_text(30, 760, "{$data} ", $font3, 9, array(0,0,0));
            } </script>
        -->
    </body>
</html>







