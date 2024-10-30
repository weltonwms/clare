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
                font-size: 11px;
            }

            div.quadradinho{
                padding: 2px;
                margin: 0 0 0 50px;
                text-align: right;
                padding-left: 5px;
                text-align: center;
            }

            .container{

                width:100%;
                /*padding: 20px;*/

            }

            #logo{

                margin:0;
                padding:0;
                /*max-width: 40%;*/
            }

            #tipo_servico{
                border: 2px solid;
                font-size: 12px;
                /*width: 240px;*/
            }

            #info_cliente{

                line-height: 11px;
                padding:9px;
            }

            #discriminacao{
                margin:0;
                /* border: 2px solid;*/
            }

            #discriminacao table{

                margin:0px;
                padding:0;
            }

            #endereco{
                /*
                padding-top: 30px;
                margin-top: 20px;
                font-size: 12px;
                */
            }

            #endereco td{
                text-align: center;

            }
            .borda{
                border: 1px solid;
            }

            .coluna1_tipo_servico{

            }



            .borda_topo{
                border-top: 1px solid;

            }

            .destaque{
                background-color:  #E5E5DB;
            }



            #discriminacao table #preco_total td{
                border-top: 1px solid;
                font-weight: bold;
            }

            #discriminacao table #preco_total td:last-child{

            }

            #discriminacao table td, #discriminacao table th{
                /* border: 1px solid;*/
                text-align: left;
                line-height: 15px;
            }

            #discriminacao table th{
                border-top: 1px solid;
                border-bottom: 1px solid;
            }

            #assinatura{
                margin-top: 20px;
                padding-top: 30px;
            }

            footer .pagenum:before {
                content: counter(page);
            }

            footer { 
                position: fixed; 
                left: 0px; right: 0px; 
                bottom: 0px; 
                font-size: 9px;
               font-weight: bold;
/*                background-color: lightblue; */
/*                height: 50px;*/
            }
            
            footer .texto_base{
               
                 text-align: center;
            }
            
            footer .nr_pagina{
                bottom: -10px; 
                text-align: right;
                position: fixed; 
                 font-style: italic;
            }
          
        </style>
    </head>
    <body>
         <footer class="">
            <div class="texto_base">
                Gráfica BlueSky 61 3624-0091 | Quadra 86, Lote 01 | Cep: 72.871-059 <br>
                Jardim Céu Azul, Valparaíso de Goiás - GO  
             </div>
             <div class="nr_pagina">Página <span class="pagenum"></span></div>
                
           
        </footer>

        <?php
        $base_url = FCPATH;
        $total_pago = $servico->get_soma_pagamentos(CREDITO);
        $restante_pagar = $servico->get_total_geral_venda() - $total_pago;
        ?>




        <div class="container" >
            <table   width="100%" cellspacing='0' cellpadding='0'>
                <tr>
                    <td width="70%">
                        <div id="logo">
                            <img src="<?php echo $base_url ?>assets/imgs/logo_impressao.png" alt="Log" > 
                        </div>
                    </td>

                    <td>
                        <div id="" style="margin:0; padding:0">
                            <table style="width:100%" >
                                <tr >
                                    <td width='40%' align='right'> Nº Serviço: </td>
                                    <td align='right'><?php echo $servico->get_id_servico() ?></td>
                                </tr>
                                <tr>
                                    <td> <div class="borda quadradinho"><?php if ($servico->get_estado() == '2') echo "X" ?>&nbsp;</div> </td>
                                    <td align='right'>Serviço Executado</td>
                                </tr>
                                <tr>
                                    <td> <div class="borda quadradinho"><?php if ($servico->get_estado() == '1') echo "X" ?>&nbsp;</div> </td>
                                    <td align='right'>Orçamento</td>
                                </tr>
                                <tr>
                                    <td align='right'>Data: </td>
                                    <td align='right'><?php echo $servico->get_data() ?> </td>
                                </tr>
                            </table>
                        </div>
                    </td>
                </tr>

            </table>

            <hr>



            <div id="info_cliente">
                <table cellspacing='5' cellpadding='0' >
                    <tr>
                        <td>Empresa:</td>
                        <td width='200' ><?php echo $servico->get_nome_cliente() ?></td>
                        <td colspan="2">Responsável: <?php echo $servico->get_responsavel_cliente() ?>&nbsp;&nbsp;&nbsp;&nbsp;</td>

                    </tr>
                    <tr>
                        <td>Endereço:</td>
                        <td> <?php echo $servico->get_endereco_cliente() ?></td>
                        <td colspan="2">Telefone: <?php echo $servico->get_telefone_cliente() ?></td>

                    </tr>

                    <?php if ($servico->get_cnpj_cliente()):?>
                    <tr>
                        <td>CNPJ:</td>
                        <td width="200"><?php echo $servico->get_cnpj_cliente() ?></td>
                        <td colspan="2"></td>
                    </tr>
                    <?php endif;?>

                    <tr>
                        <td colspan="4"> <b>Valor Pago: <?php echo number_format($total_pago, 2, ",", "."); ?> | Restante: <?php echo number_format($restante_pagar, 2, ",", ".") ?> </b></td>

                    </tr>
                </table>
            </div>
            <div id="discriminacao">
                <table width='100%' cellspacing='0' cellpadding='1'  >
                    <tr >
                        <th width="5%">Item</th>
                        <th width="5%">Qtd</th>
                        <th width="60%">Discriminação</th>
                        <th width="15%">Preço Un</th>
                        <th width="15%">Total</th>
                    </tr>
                    <?php
                    $cont = 1;
                    foreach ($servico->get_itens_servico() as $item):
                        ?>
                        <tr>
                            <td><?php echo $cont ?> </td>
                            <td><?php echo $item->get_qtd_produto() ?></td>
                            <td>
                                <?php echo $item->get_nome_produto() ?>
    <?php echo"<br>" . $item->get_descricao() ?>
                            </td>
                            <td><?php echo "R$ " . formatar_float_to_money($item->get_valor_unitario_venda()); ?></td>
                            <td><?php echo "R$ " . number_format($item->get_total_venda(), 2, ",", "."); ?></td>
                        </tr>
                        <?php
                        $cont++;
                    endforeach;
                    ?>
<?php if ($imprimir_total): ?>
                        <tr id="preco_total">
                            <td colspan="3"> </td>
                            <td>Total Geral</td>
                            <td class="destaque"><?php echo "R$ " . number_format($servico->get_total_geral_venda(), 2, ",", "."); ?></td>
                        </tr>
<?php endif; ?>
                </table>
            </div>


<?php if ($servico->get_obs()) echo "Obs: " . $servico->get_obs() ?>

            <div id="assinatura" align="center">
                <p>___________________________________________________________</p>
                <p>Assinatura</p>
            </div>


        </div>


       
    </body>
</html>







