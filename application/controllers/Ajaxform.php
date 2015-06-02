<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ajaxform extends CI_Controller{
    public function __construct() {
        parent::__construct();
        $this->load->helper('form');
        $this->load->library('table');
    }
  
    public function index() {
        $this->load->model('ajaxform/qry_ajaxform');
        $data['tabel'] = $this->qry_ajaxform->select_data();
        
        $this->load->view('design/header');
        $this->load->view('ajaxform/index',$data);
        $this->load->view('design/footer');
    }
    
    public function submit() {
        $this->load->model('ajaxform/qry_ajaxform');
        $res = $this->qry_ajaxform->submit();
        echo $res;
    }
    
    public function set_data() {
        $this->load->model('ajaxform/qry_ajaxform');
        $res = $this->qry_ajaxform->set_data();
        echo $res;
    }
}
