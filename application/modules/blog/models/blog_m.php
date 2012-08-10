<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 *  @developed : buscalibre.com
 *  @author    : Octavio Fuenzalida Mora.
 *  @email     : o.fuenzalida@buscalibre.com
 *  @File      : blog_m
 *  @Fecha     : 07-08-2012 16:51:28
 * */
class Blog_m extends MY_Model {

    public $before_create = array('timestamps_insert');
    public $alfer_update = array('timestamps_update');

    function __construct() {
        parent::__construct();
        /**
         * Nombre de la tabla en la base de dato.
         */
        $this->_table = "blog";
        /**
         * Nombre de la llave primaria de la tabla.
         */
        $this->primary_key = "idBlog";
        /**
         * Validacion para las tablas de la base de datos.
         */
        $this->validate = array(array(
                'field' => 'titleBlog',
                'label' => 'TitleBlog',
                'rules' => 'required|trim|max_length[50]'),
            array(
                'field' => 'bodyBlog',
                'label' => 'BodyBlog',
                'rules' => 'required|trim|max_length[NULL]'),
            array(
                'field' => 'updatedBlog',
                'label' => 'UpdatedBlog',
                'rules' => 'required|trim|max_length[NULL]'),
            array(
                'field' => 'createdBlog',
                'label' => 'CreatedBlog',
                'rules' => 'required|trim|max_length[NULL]'),
        );
    }

    protected function timestamps_insert($book) {
        $book['createdBlog'] = date('Y-m-d H:i:s');
        $book['updatedBlog'] = NULL;
        return $book;
    }

    protected function timestamps_update($book) {
        $book['updatedBlog'] = date('Y-m-d H:i:s');
        return $book;
    }

    public function limit_filter($inicio, $fin) {
        $data = $this->db->limit($fin, $inicio)->get($this->_table)->result();
        log_message("debug", $this->db->last_query());
        return $data;
    }

    /**
     * Codigo generado automoticamente.
     */
}

/* End of file blog_m.php */
/* Location: ./application/models/blog_m.php */