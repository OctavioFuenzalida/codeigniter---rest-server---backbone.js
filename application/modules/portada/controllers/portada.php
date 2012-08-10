<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of portada
 *
 * @author octavio
 */
class Portada extends MY_Controller {

    public function index() {
        $this->set_data("nav","portada");
        $this->set_data("content", $this->load->view("portada/portada_view", NULL, TRUE));
        $this->load->view("master_page_view",$this->get_data());
    }

}

?>
