<?php

function formatar_data_to_mysql($data)
{
    $date = \DateTime::createFromFormat('d/m/Y', $data);
    return $date->format('Y-m-d');
}

function formatar_float_to_money($valor)
{
    $num_dec = numberOfDecimals($valor);

    if ($num_dec <= 2) {
        return number_format($valor, 2, ",", ".");
    }
    return is_numeric($valor) ? str_replace(".", ",", $valor) : "";
}

function numberOfDecimals($value)
{
    if ((int) $value == $value) {
        return 0;
    } else if (!is_numeric($value)) {
        // throw new Exception('numberOfDecimals: ' . $value . ' is not a number!');
        return false;
    }
    return strlen($value) - strrpos($value, '.') - 1;
}

function moneyBrToUsd($valor)
{

    $valor1 = str_replace(".", "", $valor);
    $valor2 = str_replace(",", ".", $valor1);

    return $valor2;
}

function moneyUsdToBr($valor)
{

    $valor1 = str_replace(".", ",", $valor);
    return $valor1;
}

function nomeContaBoleto($cd)
{

   $nomes=['','INTER GLAUBER','INTER MAURICIO'];
   if(isset($nomes[$cd])):
        return $nomes[$cd];
   endif;
    
}

