<?php

/**
 * Description of generarhmvc
 *
 * @author master
 */
date_default_timezone_set("America/Santiago");

class Generarhmvc {

    private $path;
    private $modulo;
    private $auto;
    private $date;

    function __construct($modulo = NULL) {
        if (!is_null($modulo)) {
            $this->path = dirname(dirname(dirname(__FILE__))) . "/modules/" . $modulo;
            $this->modulo = $modulo;
            $this->auto = "Octavio Fuenzalida Mora";
            $this->date = date("d-m-Y");
        } else {
            $this->modoDeUso();
        }
    }

    function generaDirectorios() {


        $directorios = array(
            "Controllers" => $this->path . "/controllers",
            "Models" => $this->path . "/models",
            "Views" => $this->path . "/views",
            "Language" => $this->path . "/language",
            "Spanish" => $this->path . "/language/spanish",
            "English" => $this->path . "/language/english",
            "Config" => $this->path . "/config",
            "Libraries" => $this->path . "/libraries",
            "Assets" => $this->path . "/assets",
            "Javascript" => $this->path . "/assets/js",
            "Css" => $this->path . "/assets/css",
            "Images" => $this->path . "/assets/images",
        );
        $archivos = array(
            "controller" => $this->path . "controllers/" . $this->modulo . ".php",
            "view" => $this->path . "/views/" . $this->modulo . "_view.php"
        );

        echo "* Creando Modulo " . $this->path . "\n";
        if (!is_dir($this->path)) {
             @mkdir($this->path);
             @chmod($this->path, FILE_WRITE_MODE);

        foreach ($directorios as $key => $val) {
            echo "* Creando Directorio " . $key . "\n";
            if (file_exists($val)) {
                echo "Directorio " . $val . " Ya existe.";
            } else {
                @mkdir($val);
            }
            @chmod($val, FILE_WRITE_MODE);
        }

        foreach ($archivos as $key => $val)
            if (!file_exists($val)) {
                switch ($key) {
                    case "controller": {
                            echo "* Creando Template Controlador Inicial\n";
                            $this->write_archivo($this->templateControllers(), $val);
                            break;
                        }
                    case "view": {
                            echo "* Creando Template View Controlador Inicial\n";
                            $this->write_archivo($this->templateViews(), $val);
                            break;
                        }
                }
            }
        }else
        {
            echo "No se puede crear el directorio: ".$this->path;
            exit;
        }

       
    }

    static function modoDeUso() {
        echo "* php generarhmvc.php <NombreModulo>\n";
        exit;
    }

    function templateControllers() {
        $nombre_modulo = ucfirst($this->modulo);
        $controllers = <<<CONT
<?php
        if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class  $nombre_modulo  extends MX_Controller {
    
        function __construct(){
         parent::__construct();
        }
        
        public function index(){
        \$this->load->view("$this->modulo.'_view'");
        }

}
/* End of file $this->modulo.php */
/* Location: ./controllers/$this->modulo.php */
CONT;

        return $controllers;
    }

    function templateViews() {
        $controllers = <<<CONT
<?php
        if (!defined('BASEPATH'))
    exit('No direct script access allowed');
?>
Vista en el modulo $this->modulo
CONT;

        return $controllers;
    }

    public function write_archivo($msg, $archivo) {


        if (!$fp = @fopen($archivo, FOPEN_WRITE_CREATE)) {
            return FALSE;
        }

        flock($fp, LOCK_EX);
        fwrite($fp, $msg);
        flock($fp, LOCK_UN);
        fclose($fp);

        @chmod($archivo, FILE_WRITE_MODE);
        return TRUE;
    }

}

if ($argc == 2) {
    $modulo = $argv[1];
    echo "* Generando HMVC para el Modulo " . $modulo . "\n";
    $template = new Generarhmvc($modulo);
    $template->generaDirectorios();
} else {
    Generarhmvc::modoDeUso();
}
?>

