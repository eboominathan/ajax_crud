<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Qry_ajaxform extends CI_Model{
   
    protected $res = "";
    protected $stat = "";

    public function __construct() {
        parent::__construct();
    }
    
    public function select_data() {
        $query = $this->db->get('emp');
        if ($query->num_rows() > 0)
        {
            return $query->result();
        } else {
            return false;
        }

    }
    
    public function set_data() {
        $idemp = $this->input->post('idemp');
        $this->db->where('idemp', $idemp);
        $query = $this->db->get('emp');
        
        foreach ($query->result_array() as $row)
        {
            $res=array(
                'idemp' => $row['idemp'],
                'emp_name' => $row['emp_name'],
                'emp_gender' => $row['emp_gender'],
                'emp_blood' => $row['emp_blood'],
                'emp_phone' => $row['emp_phone'],
                'emp_address' => $row['emp_address'],
            );
        }
        return json_encode($res); 
    }
    
    public function submit() {
        try {
                $idemp = $this->input->post('idemp');
                $stat = $this->input->post('stat');

                $data = array(                       
                    'emp_name' => $this->input->post('emp_name'),
                    'emp_gender' => $this->input->post('emp_gender'),
                    'emp_blood' => $this->input->post('emp_blood'),
                    'emp_phone' => $this->input->post('emp_phone'),
                    'emp_address' => $this->input->post('emp_address'),
                );  

                if(empty($idemp)){
                    $resl = $this->db->insert('emp', $data);
                    if( ! $resl){
                        $err = $this->db->error();
                        $this->res = "<i class=\"fa fa-fw fa-warning\"></i> Error : ". $this->apps->err_code($err['message']);
                        $this->stat = "0";
                    }else{
                        $this->res = "<label class=\"label label-success\">Data berhasil di simpan</label>";
                        $this->stat = "1";
                    }
                    
                }elseif(!empty($idemp) && empty($stat)){

                    $this->db->where('idemp', $idemp);
                    $resl = $this->db->update('emp', $data);
                    if( ! $resl){
                        $err = $this->db->error();
                        $this->res = "<i class=\"fa fa-fw fa-warning\"></i> Error : ". $this->apps->err_code($err['message']);
                        $this->stat = "0";
                    }else{
                        $this->res = "<label class=\"label label-success\">Data berhasil di update</label>";
                        $this->stat = "1";
                    }

                }elseif(!empty($idemp) && !empty($stat)){
                    $this->db->where('idemp', $idemp);
                    $resl = $this->db->delete('emp');

                    if( ! $resl){
                        $err = $this->db->error();
                        $this->res = "Error : ". $this->apps->err_code($err['message']);
                        $this->stat = "0";
                    }else{
                        $this->res = "Data deleted!";
                        $this->stat = "1";
                    }
                    
                }else{
                    $this->res = "<label class=\"label label-danger\">Variable yang dikirim tidak sesuai dengan ketentuan</label>";
                    $this->stat = "0";
                }

        }
        catch (Exception $e) {            
            $this->res = "<label class=\"label label-danger\">".$e->getMessage()."</label>";
            $this->stat = "0";
        }
        
        $arr = array(
            'stat' => $this->stat, 
            'msg' => $this->res,
            );
        
        return  json_encode($arr);
    }
}
