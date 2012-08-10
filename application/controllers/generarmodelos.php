<?php
date_default_timezone_set("America/Santiago");
class Generarmodelos extends MX_Controller {

    function __construct() {
        parent::__construct();
        $this->load->database();
        }

        private $author = "Octavio Fuenzalida Mora.";
        private $copyright = "buscalibre.com";
        private $email = "o.fuenzalida@buscalibre.com";
        private $primary_key = "id";
        private $tables = array();
        private $models = array();
        private $datatypes = array(
        'CHAR', 'VARCHAR', 'BINARY', 'VARBINARY', 'TINYBLOB', 'TINYTEXT', 'BLOB',
        'TEXT', 'MEDIUMBLOB', 'MEDIUMTEXT', 'LONGBLOB', 'LONGTEXT', 'ENUM',
        'SET', 'BOOL', 'BOOLEAN', 'TINYINT', 'SMALLINT', 'MEDIUMINT', 'INT',
        'INTEGER', 'BIGINT', 'FLOAT', 'DOUBLE', 'DECIMAL', 'NUMERIC', 'BIT',
        'DATE', 'TIME', 'DATETIME', 'TIMESTAMP', 'YEAR'
        );
        private $header = <<<EOT
<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
		
/**
 *  @developed : %2\$s
 *  @author    : %3\$s
 *  @email     : %4\$s
 *  @File      : %6\$s_m
 *  @Fecha     : %5\$s
 **/
 
class %1\$s_m extends MY_Model
{
	function __construct()
	{
		parent::__construct();
               /**
                 * Nombre de la tabla en la base de dato.
                 */
                \$this->_table = "%6\$s";
               /**
                 * Nombre de la llave primaria de la tabla.
                 */
                \$this->primary_key = "%7\$s";

EOT;

        private $validate_model = <<<EOT
                /**
                  *Validacion para las tablas de la base de datos.
                  */
                  \$this->validate = array(%1\$s);        
EOT;

        private $body_model = <<<EOT
	
 
    /**
     *
     * @param interger \$id
     * @return 1 columna filtrada por el id 
     */
    public function get_by_id_pk(\$id) {
        \$data = parent::get((int) \$id);
        if (\$data) {
            return \$data;
        } else {
            return FALSE;
        }
    }

    /**
     *
     * @param array \$params
     * @return 1 columna filtrada por lo parametros enviados en forma de array 
     */
    public function get_by(\$params) {
        \$data = parent::get_by(\$params);
        if (\$data) {
            return \$data;
        } else {
            return FALSE;
        }
    }

    /**
     *
     * @param array \$params
     * @param boolean \$validacion
     * @return el id de la insercion si todo fue bien, de caso contrario retorno false
     */
    public function create(\$params, \$validacion=FALSE) {
        \$data = parent::insert(\$data, \$validacion);
        if (\$data) {
            return \$data;
        } else {
            return FALSE;
        }
    }

    /**
     *
     * @param array \$params
     * @param boolean \$validacion 
     * @return boolean TRUE o FALSE
     */
    public function update(\$id, \$params, \$validacion=FALSE) {
        \$data = parent::update((int)\$id, \$params, \$validacion);
        if (\$data) {
            return \$data;
        } else {
            return FALSE;
        }
    }

    /**
     *
     * @param integer \$id
     * @return boolean TRUE O FALSE 
     */
    public function delete(\$id) {
        \$data = parent::delete((int) \$id);
        if (\$data) {
            return \$data;
        } else {
            return FALSE;
        }
    }
        
EOT;


        private $footer = <<<EOT
	
	}
        /**
         *Codigo generado automoticamente.
         */  
        
        %2\$s
        
}
/* End of file %1\$s_m.php */
/* Location: ./application/models/%1\$s_m.php */
EOT;



        function _remap()
        {
        ob_start();

        $tables = $this->db->list_tables();

        foreach ($tables as $table)
        {
        $query = $this->db->query("SHOW COLUMNS FROM `$table`");
        $fields = $query->result();

        foreach ($fields as $field)
        {
        $this->tables[$table][] = $this->_parse_column($field);

        }

        echo "\t<li><a href='#$table'>$table</a></li>\n";
        }

        echo "</ul>\n";

        $this->models = $this->_format_output();

        foreach ($this->models as $name => $data) {
            echo "<h1><a name='$name'></a>$name</h1>\n";
            echo "<a href='#'>TOP</a><br />\n";
            echo "<textarea style='width: 1000px; height: 500px;'>$data</textarea>\n";
        }

        $out = ob_get_contents();
        ob_end_clean();

        if (count($_POST) > 0)
            $this->_export();

        echo "<strong>" . count($tables) . " models generated in "
        . $this->benchmark->elapsed_time('total_execution_time_start')
        . " seconds</strong><br />\n"
        . '<form method="post">' . "\n"
        . '<fieldset><legend>Export</legend>' . "\n"
        . '<label><input type="checkbox" name="backup" value="1" checked="checked" /> Backup</label><br />' . "\n"
        . '<input name="save" type="submit" value="Save into ./application/models" />' . "\n"
        . "</fieldset></form>\n"
        . "<ul>\n";

        echo $out;
    }

    private function _export() {
        $backup = FALSE;

        if ($this->input->post('backup') == 1) {
            $backup = TRUE;
        }

        foreach ($this->models as $name => $data) {
            $fullpath = APPPATH . 'models/' . $name . '_m' . EXT;

            if ($backup === TRUE && file_exists($fullpath)) {
                copy($fullpath, $fullpath . '.' . time() . '.bak');
                echo "Backup of " . $fullpath . " created<br />\n";
            }

            file_put_contents($fullpath, $data);
        }

        echo "Export completed.<br />\n";
    }

    private function _parse_column($field) {
        $arr = array(
            'name' => NULL,
            'datatype' => NULL,
            'maxlength' => NULL,
            'flags' => array(), // PK, AI, NN, UN
            'default' => NULL
        );

        $arr['name'] = $field->Field;

        if ($field->Key == 'PRI') {
            $this->primary_key = $field->Field;
            $arr['flags'][] = 'PK';
        }

        if ($field->Extra == 'auto_increment') {
            $arr['flags'][] = 'AI';
        }

        if ($field->Null == 'NO' && !in_array('PK', $arr['flags'])) {
            $arr['flags'][] = 'NN';
        }

        if ($field->Default != '') {
            $arr['default'] = $field->Default;
        }

        preg_match_all('/([^ ()]+)/', $field->Type, $matches);

        $matches = $matches[0];

        foreach ($matches as $match) {
            if (in_array($arr['datatype'], array('DECIMAL', 'NUMERIC'))
                    && strpos($match, ',') !== FALSE) {
                $match = str_replace(',', '.', $match);
                $arr['maxlength'] = floatval($match);
            } else if (in_array($arr['datatype'], array('ENUM', 'SET'))
                    && strpos($match, "'") !== FALSE) {
                $match = str_replace("'", '', $match);
                $arr['maxlength'] = explode(',', $match);
            } else if (is_numeric($match)) {
                $arr['maxlength'] = $match;
            } else if ($match == 'unsigned') {
                $arr['flags'][] = 'UN';
            } else if (in_array(strtoupper($match), $this->datatypes)) {
                $arr['datatype'] = strtoupper($match);
            }
        }

        return $arr;
    }

    private function _format_output() {
        $models = array();

        foreach ($this->tables as $name => $fields) {

            $max = array(
                'name' => 0,
                'datatype' => 11,
                'length' => 5,
                'flags' => 8
            );

            $enums = array();
            $enums_str = '';
            $enum_idx = 1;

            foreach ($fields as $field) {
                $length = strlen($field['name']);

                if ($length > $max['name']) {
                    $max['name'] = $length;
                }

                if (in_array($field['datatype'], array('ENUM', 'SET'))) {
                    $enums[] = $field['maxlength'];
                }
            }

            foreach ($enums as $key => $enum) {
                $enums_str .= '$e' . ($key + 1) . ' = array(';

                foreach ($enum as $idx => $val) {
                    $enum[$idx] = "'" . $val . "'";
                }

                $enums_str .= implode(', ', $enum);
                $enums_str .= ");\n\t\t";
            }

            if ($enums_str != '') {
                $enums_str .= "\n\t\t";
            }

            $str = sprintf($this->header, ucfirst($name), $this->copyright, $this->author, $this->email, date("d-m-Y H:i:s"), strtolower($name), 
$fields[0]["name"]);
            $validate = "";

            foreach ($fields as $field) {
                $flags = implode('+', $field['flags']);

                if ($flags == '') {
                    $flags = 'NULL';
                }

                if ($field['maxlength'] == NULL) {
                    $field['maxlength'] = 'NULL';
                }

                if (is_array($field['maxlength'])) {
                    $field['maxlength'] = '$e' . $enum_idx++;
                } else {
                    $field['maxlength'] = (string) $field['maxlength'];
                }

                if ($field['default'] == NULL) {
                    $field['default'] = 'NULL';
                } else if (!is_numeric($field['default'])) {
                    $field['default'] = "'" . $field['default'] . "'";
                }

                if (empty($field['flags'])) {
                    $field['flags'] = 'NULL';
                }

//                $str .= "\t\t\t'" . $field['name'] . "'";
//                $str .= str_repeat(' ', $max['name'] - strlen($field['name']));
//                $str .= ' => array(';
//                $str .= $field['datatype'];
//                $str .= str_repeat(' ', $max['datatype'] - strlen($field['datatype']));
//                $str .= ', ' . $field['maxlength'];
//                $str .= str_repeat(' ', $max['length'] - strlen($field['maxlength']));
//                $str .= ', ' . $flags;
//                $str .= str_repeat(' ', $max['flags'] - strlen($flags));
//                $str .= ', ' . $field['default'] . "),\n";
                $create_validacion = TRUE;
                //Recorre la primary key 
                foreach (explode("+", $flags) as $pk) {
                    //Si la primary key es auto_incremental debe sacarla de ser requerida
                    if ($pk == "AI") {
                        //encontrado auto_increment se sale del bucle altiro.
                        $create_validacion = FALSE;
                        continue;
                    } else {
                        $create_validacion = TRUE;
                    }
                }
                if ($create_validacion) {
                    $validate .= "\t\t\t array(
                     'field'   => '" . $field['name'] . "',
                     'label'   => '" . ucwords($field['name']) . "',
                     'rules'   => '";

                    $validate .= $flags == "NN" ? "required|" : "";
                    $validate .=!is_null($field['maxlength']) ? "trim|max_length[" . $field['maxlength'] . "]" : "";
                    $validate .= "'),\n";
                }
            }
            $str .= sprintf($this->validate_model, $validate);
            $str .= sprintf($this->footer, strtolower($name), '');


            $models[$name] = $str;
        }

        return $models;
    }

}

/* End of file scaffold.php */
/* Location: ./application/controllers/generarmodelos.php */
