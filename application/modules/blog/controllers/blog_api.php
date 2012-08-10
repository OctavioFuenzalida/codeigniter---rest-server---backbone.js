<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of blog_api
 *
 * @author octavio
 */
class Blog_api extends Rest_Api_Controller {

    private $pag_inicial = 0;
    private $pag_maximo = 10;

    function __construct() {
        parent::__construct();
        $this->load->model("blog_m");
    }

    public function blog_get($id = NULL) {
        if (!is_null($id) AND is_numeric($id)) {
            $this->response(
                    $this->blog_m->get($id)
            );
        } else {
            $page = (int) $this->input->get("page");
            if (!is_null($page) and is_numeric($page)) {
                $this->response(
                        array(
                            "rows" => $this->blog_m->limit_filter(($page * 10 - 10), $this->pag_maximo),
                            "totalResults" => $this->blog_m->count_all(),
                            "pageSize" => count($this->blog_m->limit_filter(($page * 10 - 9), $this->pag_maximo)),
                            "currentPage" => $page,
                            "totalPages" => ceil($this->blog_m->count_all() / 10)
                        )
                );
            } else {
                $this->respose(NULL);
            }
        }
    }

    public function blog_post() {

      
        if($this->blog_m->insert($this->post(),TRUE)){
            $this->response(TRUE);
        }
        else
        {
            $this->response(FALSE);
        }
        
    }

    public function blog_put() {
        
        log_message("debug",print_r($this->put(),TRUE));
        
        $idBlog = $this->put("idBlog");
        $data_insert["titleBlog"] = $this->put("titleBlog");
        $data_insert["bodyBlog"] = $this->put("bodyBlog");
        
        
       if($this->blog_m->update($idBlog,$data_insert,TRUE))
        {
            $this->response(TRUE);
        }
        else
        {
            $this->response(FALSE);
        }
               
        
    }

    public function blog_delete($id) {
        $id_blog = (int) $id;
        if (!is_null($id_blog) and is_numeric($id_blog)) {
            $this->load->model("blog_m");
            $this->response(
                    array(
                        "result" => TRUE,
                        "success" => $this->blog_m->delete($id_blog)
                    )
            );
        } else {
            $this->respose(
                    array(
                        "result" => FALSE,
                        "text" => "Id invalido o no existe"
                    )
            );
        }
    }

}

?>
