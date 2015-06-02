<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Hello extends CI_Controller{
   
    public function index() {
        
        $this->load->view('design/header');
        $this->load->view('hello/index');
        $this->load->view('design/footer');
    }
}
