<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 *  @author    : Octavio Fuenzalida Mora.
 * */
require APPPATH . "third_party/MX/Controller.php";

class MY_Controller extends MX_Controller {

    /**
     * encargada de mantener datos que son seteados y luego pedidos por los
     * diferentes controladores.
     * 
     * @var array global
     */
    public $data;

    /**
     * The name of the module that this controller instance actually belongs to.
     *
     * @var string
     */
    public $module;

    /**
     * The name of the controller class for the current class instance.
     *
     * @var string
     */
    public $controller;

    /**
     * The name of the method for the current request.
     *
     * @var string
     */
    public $method;

    /**
     * habilita el debug para los controladores que deseen usar firebug for php
     * @var boolean 
     */
    private $is_debub = TRUE;

    /**
     * recibe en un array lo datos a debugiar
     * @var array 
     */
    private $data_debug = array();

    function __construct() {
        parent::__construct();
        $this->benchmark->mark('my_controller_start');
        ci()->module = $this->module = $this->router->fetch_module();
        ci()->controller = $this->controller = $this->router->fetch_class();
        ci()->method = $this->method = $this->router->fetch_method();
        $this->benchmark->mark('my_controller_end');
    }

    /**
     * @author Octavio Fuenzalida Mora
     * 
     * function encargada de recibir un Identificador de posicion y un dato de 
     * cualquier tipo para hacer debug con apoyo de la libreria de firePHP 
     * integrada.
     * 
     * @param String $id
     * @param Interger,String,Array,Object,Boolean $data 
     */
    function set_data_debug($id, $data) {
        $this->data_debug[$id] = $data;
    }

    /**
     * @author Octavio Fuenzalida Mora
     * 
     * Function encargada de crear toda el debug de la libreria firePHP. 
     */
    function get_data_debug() {
        if ($this->is_debub) {
            $this->load->library("fb");
            $data_debug = NULL;
            foreach ($this->data_debug as $data_debug) {
                $this->fb->log($data_debug);
            }
        }
    }

    /**
     * @author Octavio Fuenzalida Mora
     * 
     * Function encargada de setear la variable publica $data contenido en la
     * clase que extienden todos los controladores, para poder ir insertando
     * datos que se usaran, recibe el identificador de posicion $id y los datos 
     * a insertar en $data.
     * 
     * @param String $id
     * @param  Interger,String,Array,Object,Boolean $data 
     */
    function set_data($id, $data) {
        $this->data[$id] = $data;
    }

    /**
     * @author Octavio Fuenzalida Mora
     * 
     * Function encargada de retorna los datos pedidos, si se especifica el $id
     * se retornada solo ese dato, en caso contrario sera devuelta toda la matriz
     * de datos contenida por la variable publica $data.
     * 
     * @param String $id
     */
    function get_data($id = NULL) {
        if (is_null($id))
            return $this->data;
        else
            return $this->data[$id];
    }

}

/**
 * @author Octavio Fuenzalida Mora.
 * 
 *  La Class Public_Controller sera instanciada en aquellos controladores HMVC
 *  que no requieran de autentificacion del usuario para tener accesos a sus 
 *  diversos methodos internos.
 * 
 * @example  
 *  
 *    Class micontrolador extends Public_Controller {
 * 
 *    }
 */
class Public_Controller extends MY_Controller {

    /**
     * Variable encargada de decir si se imprimira los slider de publicidad 
     * principal en la pagina que sea instanciado.
     * 
     * @var boolean 
     */
    function __construct() {
        parent::__construct();
    }

}

/**
 * @author Octavio Fuenzalida Mora.
 * 
 *  La Class Login_Controller sera instanciada en aquellos controladores HMVC
 *  que requieran autentificacion del usuario, esta clase validara que el 
 *  usuario que la esta llamando esta logueado correctamente en el sistema, de no
 *  estarlo sera automaticamente redireccionado al modulo de autentificacion de usario
 * 
 * @example  
 *  
 *    Class micontrolador extends Login_Controller {
 * 
 *    }
 */
class Login_Controller extends MY_Controller {

    function __construct() {
        parent::__construct();
        $this->load->config("auth/ion_auth");
        $this->load->library('auth/ion_auth');
        $this->load->library('session');
        $this->load->library('form_validation');
        $this->load->model("auth/ion_auth_model");
        $this->load->helper('url');

        $this->load->database();

        if (!$this->ion_auth->logged_in()) {
            redirect('auth/user/' . base64_encode(site_url($this->module . "/" . $this->controller . "/" . $this->method)), 'refresh');
        }
    }

}

//include_once(APPPATH . "/libraries/REST_Controller.php");
/**
 * 
 * La class  Rest_Api_Controller  hereda a Rest_Controller para poder
 * usar y activar las llamadas al estandar REST ( GET, POST, PUT, DELETE)
 * esta ademas valida que el usuario que 
 */
class Rest_Api_Controller extends REST_Controller {

    /**
     * encargada de mantener datos que son seteados y luego pedidos por los
     * diferentes controladores.
     * 
     * @var array global
     */
    public $data_rest;

    /**
     * The name of the module that this controller instance actually belongs to.
     *
     * @var string
     */
    public $module;

    /**
     * The name of the controller class for the current class instance.
     *
     * @var string
     */
    public $controller;

    /**
     * The name of the method for the current request.
     *
     * @var string
     */
    public $method;

    function __construct() {
        parent::__construct();
        ci()->module = $this->module = $this->router->fetch_module();
        ci()->controller = $this->controller = $this->router->fetch_class();
        ci()->method = $this->method = $this->router->fetch_method();
    }

}

/**
 * Returns the CodeIgniter object.
 *
 * Example: ci()->db->get('table');
 *
 * @return \CI_Controller
 */
function ci() {
    return get_instance();
}

/* End of file MY_Controllers */
/* Location: ./core/MY_Controllers.php */