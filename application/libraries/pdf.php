<?php
if(!defined('BASEPATH')) exit('No direct script access allowed');
require_once(APPPATH."/third_party/dompdf/dompdf_config.inc.php");
 
class Pdf extends Dompdf{
     
        function createPDF($html, $filename='', $stream=TRUE){  
         
            $this->load_html($html);
            $this->render();
            if ($stream) {
                $this->stream("sample.pdf",array("Attachment"=>0));
            }
	    else{
		return $this->output();
	   }
		 
        }
 
}
?>
