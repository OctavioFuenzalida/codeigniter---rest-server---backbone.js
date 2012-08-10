<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of blog
 *
 * @author octavio
 */
class Blog extends MY_Controller {

    public function index() {
        $this->set_data("nav", "blog");
        
        $this->set_data("content", $this->load->view("blog/blog_view", NULL, TRUE));
        
        $this->set_data("script", array(
            base_url() . "assets/modules/blog/app.js",
            base_url() . "assets/modules/blog/models/blog_model.js",
            base_url() . "assets/modules/blog/views/blog_view.js"
                )
        );
        $this->load->view("master_page_view", $this->get_data());
    }

}

?>
