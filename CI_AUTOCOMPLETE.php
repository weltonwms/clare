<?php 
//Last update 13.06.2016, 15:07

/** 

* @property CI_DB_active_record $db
* @property CI_DB_forge $dbforge
* @property CI_Benchmark $benchmark
* @property CI_Cache $cache
* @property CI_Calendar $calendar
* @property CI_Cart $cart
* @property CI_Config $config
* @property CI_Controller $controller
* @property CI_Email $email
* @property CI_Encrypt $encrypt
* @property CI_Exceptions $exceptions
* @property CI_Form_validation $form_validation
* @property CI_Ftp $ftp
* @property CI_Image_lib $image_lib
* @property CI_Input $input
* @property CI_Lang $lang
* @property CI_Loader $load
* @property CI_Log $log
* @property CI_Migration $migration
* @property CI_Model $model
* @property CI_Output $output
* @property CI_Pagination $pagination
* @property CI_Parser $parser
* @property CI_Profiler $profiler
* @property CI_Router $router
* @property CI_Session $session
* @property CI_Security $security
* @property CI_Sha1 $sha1
* @property CI_Utf8 $utf8
* @property CI_Table $table
* @property CI_Trackback $trackbackv
* @property CI_Typography $typography
* @property CI_Unit_test $unit_test
* @property CI_Upload $upload
* @property CI_URI $uri
* @property CI_DB_utility $dbutil
* @property CI_User_agent $user_agent
* @property CI_Validation $validation
* @property CI_Xmlrpc $xmlrpc
* @property CI_Xmlrpcs $xmlrpcs
* @property CI_Zip $zip
* @property Produto_composite $Produto_composite
* @property Produto_manager $Produto_manager
* @property Produto_model $Produto_model
* @property Produto_dao $Produto_dao
* @property Generic_model $Generic_model
* @property Relatorio_model $Relatorio_model
* @property Relatorio_manager $Relatorio_manager
* @property Data_tables_writer $Data_tables_writer
* @property Data_tables $Data_tables
* @property Servico_dao $Servico_dao
* @property Servico_composite $Servico_composite
* @property Servico_manager $Servico_manager
* @property Servico_model $Servico_model
* @property Item_servico_model $Item_servico_model
* @property Item_servico_dao $Item_servico_dao
* @property Item_servico_manager $Item_servico_manager
* @property Item_servico_composite $Item_servico_composite
* @property Cliente_model $Cliente_model
* @property Cliente_dao $Cliente_dao
* @property Cliente_manager $Cliente_manager
* @property Fornecedor_dao $Fornecedor_dao
* @property Fornecedor_model $Fornecedor_model
* @property Fornecedor_manager $Fornecedor_manager
* @property Pdf $Pdf
* @property Pdf~ $pdf~
*/
class CI_Controller { 
                
 /**
 * @access public
 * @return CI_Controller
 * 
 */
function get_instance() {}

};


class CI_DB_Driver {
 /**
  * Execute the query
  *
  * Accepts an SQL string as input and returns a result object upon
  * successful execution of a "read" type query.  Returns boolean TRUE
  * upon successful execution of a "write" type query. Returns boolean
  * FALSE upon failure, and if the $db_debug variable is set to TRUE
  * will raise an error.
  *
  * @access public
  * @param string An SQL query string
  * @param array An array of binding data
  * @return CI_DB_mysql_result
  */
 function query() {}
 
   /**
  * Execute the query
  *
  * Accepts an SQL string as input and returns a result object upon
  * successful execution of a "read" type query.  Returns boolean TRUE
  * upon successful execution of a "write" type query. Returns boolean
  * FALSE upon failure, and if the $db_debug variable is set to TRUE
  * will raise an error.
  *
  * @access public
  * @param string An SQL query string
  * @param array An array of binding data
  * @return CI_DB_mysql_result
  */
 function get() {}
 
};
/** 

* @property Produto_composite $Produto_composite
* @property Produto_manager $Produto_manager
* @property Produto_model $Produto_model
* @property Produto_dao $Produto_dao
* @property Generic_model $Generic_model
* @property Relatorio_model $Relatorio_model
* @property Relatorio_manager $Relatorio_manager
* @property Data_tables_writer $Data_tables_writer
* @property Data_tables $Data_tables
* @property Servico_dao $Servico_dao
* @property Servico_composite $Servico_composite
* @property Servico_manager $Servico_manager
* @property Servico_model $Servico_model
* @property Item_servico_model $Item_servico_model
* @property Item_servico_dao $Item_servico_dao
* @property Item_servico_manager $Item_servico_manager
* @property Item_servico_composite $Item_servico_composite
* @property Cliente_model $Cliente_model
* @property Cliente_dao $Cliente_dao
* @property Cliente_manager $Cliente_manager
* @property Fornecedor_dao $Fornecedor_dao
* @property Fornecedor_model $Fornecedor_model
* @property Fornecedor_manager $Fornecedor_manage
* @property CI_DB_active_record $db
* @property CI_DB_forge $dbforge
* @property CI_Config $config
* @property CI_Loader $load
* @property CI_Session $session
*/

class CI_Model {}; 
/**
 * @return CI_Controller
 */
function get_instance() {}