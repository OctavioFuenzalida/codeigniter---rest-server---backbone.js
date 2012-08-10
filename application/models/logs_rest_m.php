<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
		
/**
 *  @developed : buscalibre.com
 *  @author    : Octavio Fuenzalida Mora.
 *  @email     : o.fuenzalida@buscalibre.com
 *  @File      : logs_rest_m
 *  @Fecha     : 07-08-2012 16:51:28
 **/
 
class Logs_rest_m extends MY_Model
{
	function __construct()
	{
		parent::__construct();
               /**
                 * Nombre de la tabla en la base de dato.
                 */
                $this->_table = "logs_rest";
               /**
                 * Nombre de la llave primaria de la tabla.
                 */
                $this->primary_key = "id";
                /**
                  *Validacion para las tablas de la base de datos.
                  */
                  $this->validate = array(			 array(
                     'field'   => 'uri',
                     'label'   => 'Uri',
                     'rules'   => 'required|trim|max_length[255]'),
			 array(
                     'field'   => 'method',
                     'label'   => 'Method',
                     'rules'   => 'required|trim|max_length[6]'),
			 array(
                     'field'   => 'params',
                     'label'   => 'Params',
                     'rules'   => 'trim|max_length[NULL]'),
			 array(
                     'field'   => 'api_key',
                     'label'   => 'Api_key',
                     'rules'   => 'required|trim|max_length[40]'),
			 array(
                     'field'   => 'ip_address',
                     'label'   => 'Ip_address',
                     'rules'   => 'required|trim|max_length[45]'),
			 array(
                     'field'   => 'time',
                     'label'   => 'Time',
                     'rules'   => 'required|trim|max_length[11]'),
			 array(
                     'field'   => 'authorized',
                     'label'   => 'Authorized',
                     'rules'   => 'required|trim|max_length[1]'),
);        	
	}
        /**
         *Codigo generado automoticamente.
         */  
        
        
        
}
/* End of file logs_rest_m.php */
/* Location: ./application/models/logs_rest_m.php */