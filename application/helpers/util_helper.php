<?php


function formatar_data_to_mysql($data){
    $date= \DateTime::createFromFormat('d/m/Y', $data);
    return $date->format('Y-m-d'); 
    
}
